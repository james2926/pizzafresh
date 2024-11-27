<?php

namespace App\Http\Controllers\ApiControllers;

use App\Models\Articulo;
use App\Models\OrdenArticulo;
use App\Models\OrdenFabricacion;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Produccion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ControlPedidosController extends Controller
{
    public function index(Request $request){
        try{
            $fecha = $request->fecha;

            // Fabricacion
            $fabricacion = $this->getFabricacionDiaAnterior($fecha);

            // Empaquetado
            // $pedidos = $this->getPedidosPorEmpaquetar($fecha);
            $pedidos = $this->getPedidosPorEmpaquetarPrueba($fecha);

            // dump($pedidos);exit;

            // Ventas diarias
            $ventas_diarias = $this->getVentasDiarias($fabricacion->articulos??[], $pedidos??[]);

            $data = [
                'fabricacion' => $fabricacion,
                'pedidos' => $pedidos ?? [],
                'ventas_diarias' => $ventas_diarias
            ];

            return response()->json(['success' => $data], 200);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /*private function getFabricacionDiaAnterior($fecha){
        // $fecha = Carbon::now()->subDay()->format('Y-m-d'); // Obtiene la fecha de ayer
        $ayer = Carbon::parse($fecha)->subDay()->format('Y-m-d'); // Obtiene la fecha de ayer
        $fabricacion = OrdenFabricacion::with(['Articulos.Articulo'])->whereHas('Articulos', function ($query) {
            $query->whereHas('Articulo', function ($query2){
                $query2->where('principal', 1)->where('ingrediente', 0);
            });
        })->where('fecha', $ayer)->first();
        
        // Si no se encontraron resultados para ayer, intenta obtener los resultados del día anterior
        // al día de ayer hasta encontrar un día con resultados
        $diasAtras = 1;
        while (!$fabricacion && $diasAtras <= 7) {
            $fecha = Carbon::now()->subDays($diasAtras)->format('Y-m-d');
            $fabricacion = OrdenFabricacion::with(['Articulos.Articulo'])->whereHas('Articulos', function ($query) {
                $query->whereHas('Articulo', function ($query2){
                    $query2->where('principal', 1)->where('ingrediente', 0);
                });
            })->where('fecha', $ayer)->first();
            $diasAtras++;
        }

        return $fabricacion;
    }*/

    private function getFabricacionDiaAnterior($fecha) {
        $ayer = Carbon::parse($fecha)->subDay()->format('Y-m-d'); // Obtiene la fecha de ayer
        $fabricacion = $this->buscarFabricacionPorFecha($ayer);
    
        // Si no se encontraron resultados para ayer, intenta obtener los resultados del día anterior
        // al día de ayer hasta encontrar un día con resultados
        $diasAtras = 1;
        while (!$fabricacion && $diasAtras <= 7) {
            $fechaAnterior = Carbon::parse($fecha)->subDays($diasAtras)->format('Y-m-d');
            $fabricacion = $this->buscarFabricacionPorFecha($fechaAnterior);
            $diasAtras++;
        }
    
        return $fabricacion;
    }

    private function buscarFabricacionPorFecha($fecha) {
        // return OrdenFabricacion::with(['Articulos' => function ($query) {
        //         $query->whereHas('Articulo', function ($query2) {
        //             $query2->where('principal', 1)->where('ingrediente', 0);
        //         })
        //         ->with(['Articulo' => function ($query2) {
        //             $query2->where('principal', 1)->where('ingrediente', 0);
        //         }]);
        //     }])
        //     ->where('fecha', $fecha)
        //     ->whereHas('Articulos', function ($query) {
        //         $query->whereHas('Articulo', function ($query2) {
        //             $query2->where('principal', 1)->where('ingrediente', 0);
        //         });
        //     })
        //     ->first();
        $query = OrdenFabricacion::where('fecha', $fecha)
            ->whereHas('Articulos', function ($query) {
                $query->whereHas('Articulo', function ($query2) {
                    $query2->where('principal', 1)
                        ->where('ingrediente', 0);
                });
            })
            ->with(['Articulos' => function ($query) {
                $query->whereHas('Articulo', function ($query2) {
                    $query2->where('principal', 1)
                        ->where('ingrediente', 0);
                });
            }]);

        // Debug the query
        // dd($query->toSql(), $query->getBindings());

        return $query->first();

        $fabricacion = OrdenFabricacion::with(['Articulos' => function ($query){
            $query->whereHas('Articulo', function($query2){
                $query2->where('principal', 1)->where('ingrediente', 0);
            });
        }])->where('fecha', $fecha)->first();
        return $fabricacion;
    }

    private function getPedidosPorEmpaquetarPrueba($fecha){
        $fecha_parsed = Carbon::parse($fecha);
        $pedidos = Pedido::with(['ProduccionPedido.Produccion', 'ProduccionPedido.Produccion.Articulos.Articulo', 'Cliente', 'Cliente.TipoCliente', 'Items', 'Items.Articulo']);
            
        $today = Carbon::now()->format('Y-m-d'); // Obtiene la fecha de hoy
        if($fecha_parsed < $today){
            $pedidos->where('id_estado', 2)->whereDate('fecha_empaquetado', $fecha_parsed);
        }else{
            $pedidos->where(function ($query) use ($fecha_parsed){
                $query->whereDate('fecha_empaquetado', $fecha_parsed);
                $query->orWhereHas('ProduccionPedido', function ($query2) use ($fecha_parsed){
                    $query2->whereHas('Produccion', function ($query3) use ($fecha_parsed){
                        $query3->whereDate('fecha', $fecha_parsed);
                    });
                });
            });
        }

        // Excluir pedidos programados para fechas futuras y filtrar por fecha_empaquetado no null
        $pedidos->where(function ($query) use ($fecha_parsed) {
            $query->whereDate('fecha_empaquetado', '<=', $fecha_parsed)
                ->orWhereNull('fecha_empaquetado');
        });

        $pedidos = $pedidos->get();

        $p_array = [];
        foreach($pedidos as $pedido){
            $principales = [];
            if($pedido->id_estado == 2){
                $prippedidoncipales[] = ['id'=>0,'val'=>3000000];
            }
            foreach($pedido->Items as $item){
                if($item->Articulo){
                    $principal = $item->Articulo->Produccion;
                    // dump($item->Articulo->unidades_caja);exit;
                    $cantidad = $item->cantidad * $item->Articulo->unidades_caja;
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
                    if($pedido->id_estado == 3 || $pedido->id_estado == 4){
                        $pedido[$item->Articulo->nombre]  = $item->cantidad_servida.'/'.$cantidad;
                    }
                    else{
                        $pedido[$item->Articulo->nombre] = $cantidad;
                    }
                    $item['unidades_caja'] = $item->Articulo->unidades_caja;
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
            $pedido->sorting_value = $sorting_value;

            // si la fecha de empaquetado es diferente de la fecha a consultar y esta completado entonces no se agrega al arreglo de pedidos
            if($pedido->fecha_empaquetado != $fecha_parsed && $pedido->id_estado == 2){ 
                //
            }else{
                $p_array[] = $pedido;
            }
        }
        
        // $p_array = $pedidos->toArray();

        return $p_array;
    }

    private function getVentasDiarias($articulos, $pedidos){
        $ventas = [];
        foreach($pedidos as $pedido){
            // if(isset($pedido['pedido'])){
                // foreach($pedido['pedido']['items'] as $item){
                foreach($pedido['items'] as $item){
                    foreach($articulos as $articulo){
                        if(isset($articulo['articulo']) && isset($articulo['articulo']['id']) && isset($item['articulo']['id_produccion'])){
                            if($articulo['articulo']['id'] == $item['articulo']['id_produccion']){
                                $nombre_articulo = $item['articulo']['nombre'];
                                $nombre_bola = $articulo['articulo']['nombre'];

                                // Verificar si el artículo ya existe en $ventas
                                $found = false;
                                foreach ($ventas as &$venta) {
                                    if ($venta['bola'] === $nombre_bola) {
                                        // Si el artículo ya existe, sumar la venta actual
                                        if(is_string($pedido[$nombre_articulo])){
                                            //si es un string entonces es un pedido parcial descrito en fracciones (ej: 1/2; es decir, 
                                            //1 de 2 pedidos) por lo que se tomara el numerador de la fraccion ya que este es la parte servida 
                                            // del pedido, mientras que el demoninador es la cantidad total
                                            $parte_servida = explode('/', $pedido[$nombre_articulo]);
                                            $cantidad_venta = (int)$parte_servida[0];
                                        }else{
                                            $cantidad_venta = $pedido[$nombre_articulo];
                                        }

                                        // Cantidad_venta esta en cajas por lo que se pasara a unidades multiplicandolo 
                                        // por las unidades por caja configuradas en el articulo
                                        $venta_en_und = $cantidad_venta * $item['articulo']['unidades_caja'];
                                        // $venta['venta'] += $pedido[$nombre_articulo];
                                        $venta['venta'] += $venta_en_und;
                                        // Verificar si el artículo ya está en la lista de artículos
                                        if (!in_array($nombre_articulo, $venta['articulos'])) {
                                            $venta['articulos'][] = $nombre_articulo;
                                        }
                                        $found = true;
                                        break;
                                    }
                                }
                                unset($venta); // Liberamos la referencia del último elemento

                                // Si el artículo no existe, agregarlo a $ventas
                                if (!$found) {
                                    if (is_string($pedido[$nombre_articulo])) {
                                        // si es un string entonces es un pedido parcial descrito en fracciones (ej: 1/2; es decir, 1 de 2 pedidos)
                                        $parte_servida = explode('/', $pedido[$nombre_articulo]);
                                        $cantidad_venta = (int)$parte_servida[0];
                                    }else{
                                        $cantidad_venta = $pedido[$nombre_articulo];
                                    }

                                    $venta_en_und = $cantidad_venta * $item['articulo']['unidades_caja'];

                                    $ventas[] = [
                                        'articulos' => [$nombre_articulo], // Inicializamos como un array con el artículo actual
                                        'bola' => $nombre_bola,
                                        'venta' => $venta_en_und
                                    ];
                                }
                            }
                        }
                    }
                }
            // }
        }

        // Verificar y agregar bolas sin ventas
        foreach ($articulos as $articulo) {
            if (isset($articulo['articulo']) && !in_array($articulo['articulo']['nombre'], array_column($ventas, 'bola'))) {
                $ventas[] = [
                    'articulos' => [],
                    'bola' => $articulo['articulo']['nombre'],
                    'venta' => 0
                ];
            }
        }

        return $ventas;
    }

    public function getHeaders(){
        $headers = [
            // ['text'=> 'Ref', 'value'=> 'nro','sortable'=> false],
            ['text'=> 'Cliente','value'=> 'cliente.nombre_fiscal','sortable'=> false, 'width' => '250px', 'cellClass' => 'cliente-column', 'tooltip' => 'setsetsetessetg'],
            ['text'=> 'Código envío','value'=> 'cliente.codigo_envio','sortable'=> false],
            ['text'=> 'Total Pedido (uds)','value'=> 'total_cajas','sortable'=> false],
            ['text'=> 'Total Cajas','value'=> 'total_cantidad','sortable'=> false],
        ];
        $principales =  Articulo::where('principal',0)->where('ingrediente',0)->orderBy('sorting_index','ASC')->get();
        foreach($principales as $articulo){
            $headers [] = ['text'=> $articulo->nombre, 'value'=> $articulo->nombre, 'id'=> $articulo->id, 'sortable'=> true];
        }
        //$headers [] = ['text'=> 'sorting', 'value'=> 'sorting_value','sortable'=> true];
        return $headers;
    }

    public function changeInventarios(Request $request){
        try{
            $orden_articulo = OrdenArticulo::where('id_orden', $request->id)->get();
            foreach($orden_articulo as $orden){
                foreach($request->articulos as $articulo){
                    if($orden->id_articulo == $articulo['id_articulo']){
                        if($orden->inventario_inicial != $articulo['inventario_inicial']){
                            if($articulo['inventario_inicial'] > 0)
                                $orden->inventario_inicial = $articulo['inventario_inicial'];
                        }

                        if($orden->total_fabricar != $articulo['total_fabricar']){
                            $orden->total_fabricar = $articulo['total_fabricar'];
                        }
                    }
                }
                $orden->save();
            }
            return response()->json(['success' => 'Inventarios actualizados'], 200);
        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    // private function getPedidosPorEmpaquetar($fecha){
    //     // $fecha = Carbon::now()->format('Y-m-d'); // Obtiene la fecha de hoy
    //     $fecha_parsed = Carbon::parse($fecha);
    //     $produccion = Produccion::with(['Articulos.Articulo','Pedidos.Pedido.Cliente','Pedidos.Pedido.Items.Articulo'])
    //         ->whereHas('Pedidos', function ($query) use ($fecha_parsed) {
    //             $query->whereHas('Pedido', function ($query2) use ($fecha_parsed) {
    //                 $query2
    //                     // ->where('id_estado', '!=', 2) // id_estado = 2 es completado
    //                     ->where('fecha_empaquetado', '<=', $fecha_parsed);
    //             });
    //         })    
    //         ->where('fecha', $fecha_parsed)
    //         ->first();

    //     if($produccion){
    //         $merma_no_0 = false;
    //         $id_pedidos = $produccion->Pedidos()->pluck('id_pedido')->toArray();
    //         /*$articulos = $produccion->Articulos;
    //         foreach($articulos as $articulo){
    //             $query = PedidoItem::whereIn('id_pedido',$id_pedidos)
    //                 ->where(function ($query) use ($articulo){
    //                     $query->where('id_articulo',$articulo->id_articulo);
    //                 });
    //             $ca = isset($articulo->Articulo->unidades_caja)?$articulo->Articulo->unidades_caja:1;
             
    //             $total_ventas = $query->sum('cantidad')*$ca;
    //             $fabricado = $query->sum('cantidad_servida');

    //             $query->whereHas('Pedido',function($query){
    //                 $query->where('id_estado',4);
    //             });
    //             $merma = ($query->sum('cantidad')*$ca - $query->sum('cantidad_servida'));
                
    //             $articulo ->total_a_fabricar =$articulo->inventario - $total_ventas  ;
    //            // if($articulo ->total_a_fabricar <0  ) $articulo ->total_a_fabricar = 0 ;
    //             if($merma >0){
    //                 $merma_no_0 = true;
    //             }
    //             $articulo->update();
    //             $articulo->ca = $ca;
    //             $articulo->total_ventas = $total_ventas;
    //             $articulo->cantidad_imprimir = $articulo->total_a_fabricar - $articulo->etiquetas_impresas;
    //             $articulo->merma = $merma;
    //             $articulo->fabricado = $fabricado;
    //             $articulo->pendiente =abs($articulo ->total_a_fabricar)- $fabricado;
    //         }*/

    //         // $produccion->merma = $merma_no_0;
    //         foreach($produccion->Pedidos as $pedido){
    //             $principales = [];
    //             if($pedido->Pedido->id_estado == 2){
    //                 $prippedidoncipales[] = ['id'=>0,'val'=>3000000];
    //             }
    //             foreach($pedido->Pedido->Items as $item){
    //                 if($item->Articulo){
    //                     $principal = $item->Articulo->Produccion;
    //                     $cantidad = $item->cantidad;
    //                     if($principal){
    //                         if(isset($pedido[$principal->nombre])){
    //                             $pedido[$principal->nombre] += $cantidad;
    //                         }
    //                         else{
    //                             $pedido[$principal->nombre] = $cantidad;
    //                         }
    //                         $found = false;
    //                         foreach($principales as $p){
    //                             if($p['id'] == $principal->id) $found= true;
    //                         }
    //                         if( !$found){
    //                             $principales[] = ['id'=>$principal->id,'val'=>pow(2,$principal->sorting_index)] ;
    //                         }
    //                     }
    //                     $ca = $item->Articulo?->unidades_caja??1;
    //                     if($ca == 0) $ca = 1;
    //                     if($pedido->Pedido->id_estado == 3 || $pedido->Pedido->id_estado == 4){
    //                         //Esta linea muestra la cantidad de pizzas individuales. Se comenta y se cambia a nº de cajas servidas
    //                         //$pedido[$item->Articulo->nombre]  = number_format( $item->cantidad_servida/$ca,3,',','.').'/'.$cantidad;
    //                         $pedido[$item->Articulo->nombre]  = $item->cantidad_servida.'/'.$cantidad;
    //                     }
    //                     else{
    //                         $pedido[$item->Articulo->nombre] = $cantidad;
    //                     }
    //                 }
    //             }
    //             usort($principales,function($a,$b){
    //                 return $b['val']-$a['val'];
    //             });
    //             $pedido->principales = $principales;
    //             $sorting_value = 0;
    //             foreach($principales as $item){
    //                 $sorting_value += $item['val'];
    //             }
    //             if($sorting_value == 0){
    //                 $sorting_value = 300000;
    //             }
    //             $pedido->sorting_value=  $sorting_value;
    //         }

    //         // $articulos_sorted = $articulos->toArray();
    //         $p_array = $produccion->Pedidos->toArray();
    //         /*$p_array = [];
    //         $produccion_pedidos = $produccion->Pedidos;
    //         foreach($produccion_pedidos as $produccion_pedido){
    //             if(isset($produccion_pedido->Pedido)){
    //                 $pedido = $produccion_pedido->Pedido;
    //                 if($pedido->id_estado != 2){
    //                     $p_array[] = $produccion_pedido;
    //                 }
    //             }
    //         }*/
            
    //         /*usort($articulos_sorted, function ($a,$b){
    //             return  $a['articulo']['sorting_index'] - $b['articulo']['sorting_index'] ;
    //         });*/
    //         usort($p_array, function($a,$b){
    //             if(isset($a['principales'][0])&isset($b['principales'][0])){
    //                 if($a['principales'][0] == $b['principales'][0]){
    //                     return $b['sorting_value']-$a['sorting_value'];
    //                 }
    //             }
    //             return  $a['sorting_value'] - $b['sorting_value'] ;
    //         });
    //         // $produccion = $produccion->toArray();
    //         // $produccion['pedidos'] = $p_array;
    //         // $produccion['articulos']= $articulos_sorted;
    //         return $p_array;
    //     }
    //     else{
    //         return ;
    //     }
    // }
}
