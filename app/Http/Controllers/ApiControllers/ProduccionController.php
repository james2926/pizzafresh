<?php

namespace App\Http\Controllers\ApiControllers;
use  App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\PedidoItem;

use App\Models\Articulo;
use App\Models\Produccion;
use App\Models\ProduccionArticulo;
use App\Models\ProduccionPedido;
use Barryvdh\DomPDF\Facade as PDF;
use App\Exports\EmpaquetadoExport;
use Maatwebsite\Excel\Facades\Excel;
class ProduccionController extends Controller
{
    public function testEtiquetas($fecha,Request $request){
        $es = [
            'fecha_elaboracion'=>'Fecha Elaboración:',
            'consumo_preferente'=>'Consumo preferente:',
            'ingredientes_1'=>'INGREDIENTES:Harina de trigo (glúten),',
            'ingredientes_2'=>' agua, sal, levadura, aceite de oliva.',
            'informacion_nutricional'=>'INFORMACIÓN NUTRICIONAL (Valores medios 100gr)',
            'valor_energetico'=>'Valor energético: 1160 KJ/274 kcal - Grasas: 4,3g - Grasas saturadas: 1,2g – Hidratos de carbono:50g – Azúcares: 0,5g – Proteínas: 8,6g – Sal: 1,5g.',
            'conservacion_1'=>'CONSERVACIÓN: ',
            'conservacion_2'=>'Mantener refrigeradas en cámara entre 0°C y 4 °C',
            'elaboracion_1'=>'ELABORACIÓN:',
            'elaboracion_2'=>'Cocinar en horno a temperatura entre 200°C y 300°C aprox.',
        ];
        $pt = [
            'fecha_elaboracion'=>'Data de elaboraçao:',
            'consumo_preferente'=>'melhor antes da data:',
            'ingredientes_1'=>'INGREDIENTES: Farinha de trigo (glúten),',
            'ingredientes_2'=>' agua, sal, fermento, azeite de oliva.',
            'informacion_nutricional'=>'INFORMAÇAO NUTRICIONAL (100gr)',
            'valor_energetico'=>'Energia: 1160 KJ/274 kcal - Lípidos: 4,3g – acidos gordos saturados: 1,2g – Hidratos de carbono: 50g – Azúcares: 0,5g – Proteínas: 8,6g – Sal: 1,5g.',
            'conservacion_1'=>'CONSERVAÇAO: ',
            'conservacion_2'=>'Mantener refrigerado em cámara ente 0º y 4ºC',
            'elaboracion_1'=>'',
            'elaboracion_2'=>'',
        ];
        if($request->lan == 2){
            $language = $pt;
        }
        else{
            $language = $es;
        }
        //$articulos = $request->articulos;
        $articulos = Produccion::where('fecha',$fecha)->first()->Articulos;
        foreach($articulos as $articulo){
            $articulo->cantidad_imprimir = $request[$articulo->Articulo->ref];
        }
        if($request->caducidad){
            
            $caducidad = date("d - m - Y", strtotime($request->caducidad));
        }else{
            $caducidad = date("d - m - Y", strtotime('+21 days'));
        }
        $customPaper = array(0,0,226.8,99.36);
      
     
        $pdf = PDF::setPaper($customPaper);

        $data = $pdf->loadView('pdf.etiqueta_base',compact('articulos','caducidad','language'))->output();

        return $pdf->stream();
     
    }
    public function getHeaders(){
        $headers = [
            ['text'=> 'Ref', 'value'=> 'pedido.nro','sortable'=> false],
            ['text'=> 'Cliente','value'=> 'pedido.cliente.nombre_fiscal','sortable'=> false, 'width'=> '250px'],
            ['text'=> 'Código envío','value'=> 'pedido.cliente.codigo_envio','sortable'=> false],
            ['text'=> 'Total Pedido (cajas)','value'=> 'pedido.total_cantidad','sortable'=> false],
            // ['text'=> 'Total Cajas','value'=> 'pedido.total_cajas','sortable'=> false],
        ];
        $principales =  Articulo::where('principal',0)->where('ingrediente',0)->orderBy('sorting_index','ASC')->get();
        foreach($principales as $articulo){
            $headers [] = ['text'=> $articulo->nombre, 'value'=> $articulo->nombre,'sortable'=> true];
        }
        //$headers [] = ['text'=> 'sorting', 'value'=> 'sorting_value','sortable'=> true];
        return $headers;
    }
    public function ExportProduccion($fecha){
        $produccion = $this->getProduccion($fecha);
        $headers = $this->getHeaders();
       // return $headers;
        return Excel::download(new EmpaquetadoExport($produccion,$headers), 'empaquetado.xlsx');

    }
    public function getProduccion($fecha){
        $this->GenerateProduccionbyDate($fecha);
        $produccion =  Produccion::with(['Articulos.Articulo','Pedidos.Pedido.Cliente','Pedidos.Pedido.Cliente.TipoCliente','Pedidos.Pedido.Items.Articulo'])->where('fecha',$fecha)->first();

        if($produccion){
            $merma_no_0 = false;
            $id_pedidos = $produccion->Pedidos()->pluck('id_pedido')->toArray();
            $articulos = $produccion->Articulos;
            foreach($articulos as $articulo){
                $query = PedidoItem::whereIn('id_pedido',$id_pedidos)->where(function($query)use($articulo){
                    $query->where('id_articulo',$articulo->id_articulo);
                    //$query->orWhereHas('Articulo',function($query2) use($articulo){
                    //    $query2->where('id_produccion',$articulo->id_articulo);
                    //});
                });
                $ca = isset($articulo->Articulo->unidades_caja)?$articulo->Articulo->unidades_caja:1;
             
                $total_ventas = $query->sum('cantidad')*$ca;
                $fabricado = $query->sum('cantidad_servida');

                $query->whereHas('Pedido',function($query){
                    $query->where('id_estado',4);
                });
                $merma = ($query->sum('cantidad')*$ca - $query->sum('cantidad_servida'));
                //agregando la data nueva a articulos
                $inventario_nuevo = (abs($total_ventas) - abs($articulo->inventario)  )
                                    - abs($articulo->total_a_fabricar);
                
                $artciulo_padre = $articulo->Articulo;
                $artciulo_padre->cantidad += $inventario_nuevo;
                if($artciulo_padre->cantidad < 0) $artciulo_padre->cantidad = 0;
                $artciulo_padre->update();
                $articulo ->total_a_fabricar = $articulo->inventario - $total_ventas;
               // if($articulo ->total_a_fabricar <0  ) $articulo ->total_a_fabricar = 0 ;
                if($merma >0){
                    $merma_no_0 = true;
                }
                $articulo->update();
                $articulo->ca = $ca;
                $articulo->total_ventas = $total_ventas;
                $articulo->cantidad_imprimir = $articulo->total_a_fabricar - $articulo->etiquetas_impresas;
                $articulo->merma = $merma;
                $articulo->fabricado = $fabricado;
                $articulo->pendiente =abs($articulo ->total_a_fabricar)- $fabricado;
            }

            $produccion->merma = $merma_no_0;
            foreach($produccion->Pedidos as $pedido){
                $principales = [];
                if($pedido->Pedido->id_estado == 2){
                    $prippedidoncipales[] = ['id'=>0,'val'=>3000000];
                }
                foreach($pedido->Pedido->Items as $item){
                    if($item->Articulo){
                        $principal = $item->Articulo->Produccion;
                        $cantidad = $item->cantidad;
                        if($principal){
                            if(isset($pedido[$principal->nombre])){
                                $pedido[$principal->nombre] += $cantidad;
                            }
                            else{
                                $pedido[$principal->nombre] = $cantidad;
                            }
                            $found = false;
                            foreach($principales as $p){
                                if($p['id'] == $principal->id) $found= true;
                            }
                            if( !$found){
                                $principales[] = ['id'=>$principal->id,'val'=>pow(2,$principal->sorting_index)] ;
                            }
                        }
                        $ca = $item->Articulo?->unidades_caja??1;
                        if($ca == 0) $ca = 1;
                        if($pedido->Pedido->id_estado == 3 || $pedido->Pedido->id_estado == 4){
                            /*Esta linea muestra la cantidad de pizzas individuales. Se comenta y se cambia a nº de cajas servidas*/
                            //$pedido[$item->Articulo->nombre]  = number_format( $item->cantidad_servida/$ca,3,',','.').'/'.$cantidad;
                            $pedido[$item->Articulo->nombre]  = $item->cantidad_servida.'/'.$cantidad;
                        }
                        else{
                            $pedido[$item->Articulo->nombre] = $cantidad;
                        }
                    }
                }
                usort($principales,function($a,$b){
                    return $b['val']-$a['val'];
                });
                $pedido->principales = $principales;
                $sorting_value = 0;
                foreach($principales as $item){
                    $sorting_value += $item['val'];
                }
                if($sorting_value == 0){
                    $sorting_value = 300000;
                }
                $pedido->sorting_value=  $sorting_value;
            }
            $articulos_sorted = $articulos->toArray();
            $p_array =$produccion->Pedidos->toArray();
            
            usort($articulos_sorted, function ($a,$b){
                return  $a['articulo']['sorting_index'] - $b['articulo']['sorting_index'] ;
            });
            usort($p_array, function($a,$b){
                if(isset($a['principales'][0])&isset($b['principales'][0])){
                    if($a['principales'][0] == $b['principales'][0]){
                        return $b['sorting_value']-$a['sorting_value'];
                    }
                }
                return  $a['sorting_value'] - $b['sorting_value'] ;
            });
            $produccion = $produccion->toArray();
            $produccion['pedidos'] = $p_array;
            $produccion['articulos']= $articulos_sorted;

            return $produccion;
        }
        else{
            return ;
        }
    }
    public function saveProduccion(Request $request){
        $produccion = Produccion::where('fecha',$request->fecha)->first();
        $produccion->update([
            'observaciones'=>$request->observaciones
        ]);
    }

    public function GenerateProduccion(){
        $fecha =date('Y-m-d');
        return $this->getProduccion($fecha);
    }
    public function AddProductoEmpaquetado($id){
        $fecha = date('Y-m-d');

        $this->GenerateProduccionbyDate($fecha);
        $produccion = Produccion::with([
            'Articulos.Articulo',
            'Pedidos.Pedido.Cliente',
            'Pedidos.Pedido.Items.Articulo'
        ])
        ->where('fecha',$fecha)
        ->first();
        ProduccionPedido::create([
            'id_produccion'=>$produccion->id,
            'id_pedido'=>$id
        ]);
    }
    public function deletePedido($id){
        ProduccionPedido::find($id)->delete();
    }
    public function GenerateProduccionbyDate($fecha){
        $produccion = Produccion::where('fecha',$fecha)->first();
        if(!$produccion){
            $produccion = Produccion::create(['fecha'=>$fecha,'horas'=>0]);
        }
        //conseguir fecha de ayer y hoy para poder conseguir el periodo de tiempo de 24 horas desde 10am has 10am
        $hoy = new \DateTime($fecha);
        $ayer = new \DateTime($fecha);
        $ayer->modify("-1 day");
        ///conseguir pedidos que no han sido agregados a la produccion del dia
        $pedidos = Pedido::with(['Items.Articulo','Cliente'])
            ->whereDoesntHave('ProduccionPedido', function($query)use($produccion){
                $query->where('id_produccion',$produccion->id);
                $query->withTrashed();
            })
            ->where(function($query) use($hoy){
                $query ->where('fecha','<=',$hoy->format("Y-m-d").' 10:00');
            })
            //->where('fecha',<=,$hoy->format("Y-m-d").' 10:00')
            ->where('id_estado','!=',2)
            ->get();

        //return $pedidos;
        foreach($pedidos as $pedido){
            ProduccionPedido::create(['id_produccion'=>$produccion->id,'id_pedido'=>$pedido->id]);
        }
        ///la misma accion con los articulos principales
        $principales = Articulo::where('principal',0)
            ->where('ingrediente',0)
            ->whereDoesntHave('ProduccionArticulo', function($query)use($produccion){
                $query->where('id_produccion',$produccion->id);
            })
            ->get();

        foreach($principales as $articulo){
            ProduccionArticulo::create([
                'id_produccion'=>$produccion->id,
                'id_articulo'=>$articulo->id,
                'inventario'=>$articulo->cantidad
            ]);
           // $articulo = Articulo::find($articulo->id);
        }
    }
}
