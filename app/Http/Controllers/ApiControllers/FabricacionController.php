<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Articulo;
use App\Models\PedidoItem;
use App\Models\Constantes;
use App\Models\OrdenFabricacion;
use App\Models\OrdenArticulo;
use App\Http\Resources\OrdenResource;
use App\Exports\OrdenFabricacionExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class FabricacionController extends Controller
{
    function isDate($value) {
        if (!$value) {
            return false;
        }

        try {
            new \DateTime($value);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
    public function ExportOrdenes($fecha){
        $ordenes = $this->getOrden($fecha)[0];

        return Excel::download(new OrdenFabricacionExport($ordenes), 'ordenes_fabricacion.xlsx');

    }
    public function getOrdenes(){
        return OrdenFabricacion::with(['Articulos.Articulo'])->get();
    }
    public function getOrden($fecha){
        $bool = $this->isDate($fecha);
        $date = '';
        if($bool){
            $date = $fecha;
        }else{
            $date = Carbon::now()->format('Y-m-d');
        }
        
        // Calcula el día de la semana basado en la fecha proporcionada
        // $dayOfweek = Carbon::parse($date)->dayOfWeek;
        $orden = [];

        // if($dayOfweek == 1) {
        //     $previousFriday = Carbon::parse($date)->previous(Carbon::FRIDAY)->format('Y-m-d');
        //     $orden = OrdenFabricacion::with(['Articulos.Articulo'])->where('fecha',$date)->orWhere('fecha', $previousFriday)->get();
        // } else {
            $orden = OrdenFabricacion::with(['Articulos.Articulo'])->where('fecha',$date)->get();
        // }
        
        if(count($orden) == 0){
            $orden = $this->generarOrden($fecha);
            $constantes = Constantes::first();
            $incremento = $constantes->incremento_inv;
            $orden_obj = OrdenFabricacion::create([
                'fecha'=>$fecha,
                'factor_inc'=>$incremento,	
                'observaciones'=>'',
                'urgencia'=>0,
            ]);
            $this->saveArticulos($orden_obj, $orden['articulos'] ?? $this->GetArticulosOrden());
        
            //return $orden;
            return OrdenFabricacion::with(['Articulos.Articulo'])->where('fecha',$fecha)->get();
        }
        
        return $orden;
    }

    public function getOrdenAmasado($fecha){
        $bool = $this->isDate($fecha);
        $date = '';
        if($bool){
            $date = $fecha;
        }else{
            $date = Carbon::now()->format('Y-m-d');
        }
        
        // Calcula el día de la semana basado en la fecha proporcionada
        $dayOfweek = Carbon::parse($date)->dayOfWeek;
        $orden = [];

        if($dayOfweek == 1) {
            $previousFriday = Carbon::parse($date)->previous(Carbon::FRIDAY)->format('Y-m-d');
            $orden = OrdenFabricacion::with(['Articulos.Articulo'])->where('fecha',$date)->orWhere('fecha', $previousFriday)->get();
        } else {
            $orden = OrdenFabricacion::with(['Articulos.Articulo'])->where('fecha',$date)->get();
        }
        
        if(count($orden) == 0){
            $orden = $this->generarOrden($fecha);
            $constantes = Constantes::first();
            $incremento = $constantes->incremento_inv;
            $orden_obj = OrdenFabricacion::create([
                'fecha'=>$fecha,
                'factor_inc'=>$incremento,	
                'observaciones'=>'',
                'urgencia'=>0,
            ]);
            $this->saveArticulos($orden_obj, $orden['articulos'] ?? $this->GetArticulosOrden());
        
            //return $orden;
            return OrdenFabricacion::with(['Articulos.Articulo'])->where('fecha',$fecha)->get();
        }
        
        return $orden;
    }


    public function getOrdenSinGenerar($fecha){
        $orden = OrdenFabricacion::with(['Articulos.Articulo'])
            ->where('fecha', $fecha)
            ->get();
        
        if($orden == null || count($orden) == 0){
            return response()->json(
                ['error' => 'No se ha generado una orden para el dia '. Carbon::parse($fecha)->format('d-m-Y')],
                400
            );
        }
        
        return response()->json(['success' => $orden]);
    }

    public function deleteOrden($id){
        OrdenFabricacion::with(['Articulos.Articulo'])->find($id)->delete();
    }
    public function saveOrden(Request $request){
        if($request->id){
            $orden = OrdenFabricacion::find($request->id);
            if($orden){
                if($orden->finalizada == 1){
                    return response('Orden Finalizada',400);
                }
            }
        }
        $constantes = Constantes::first();
        $incremento = $request->incremento?$request->incremento:$constantes->incremento_inv;
        $orden = OrdenFabricacion::updateOrCreate(['id'=>$request->id],[
            'fecha'=>$request->fecha,
            'factor_inc'=>$incremento,	
            'observaciones'=>$request->observaciones,
        ]);
        $this->saveArticulos($orden,$request->articulos);
    }
    public function saveArticulos($orden, $articulos){
        $ids= [];
        foreach($articulos as $articulo){
            $element = OrdenArticulo::updateOrCreate(
                ['id' => $articulo['id'] ?? null],
                [
                    'id_orden' => $orden->id,
                    'id_articulo' => $articulo['id_articulo'],
                    'inventario_inicial' => $articulo['inventario_inicial'],
                    'total_pedidos' => $articulo['total_pedidos'],
                    'total_fabricar' => $articulo['total_fabricar'],
                ]
            );
            $ids[] = $element->id;
        }
        OrdenArticulo::where('id_orden',$orden->id)->whereNotIn('id',$ids)->delete();
    }
    public function generarOrden($fecha){
        return $this->generarOrdenCampos($fecha, 0);
    }
    public function generarOrdenUrgencia($fecha){
        $articulos = $this->GetArticulosOrden();

        $constantes = Constantes::first();
        $incremento = $constantes->incremento_inv;

        $orden_obj = OrdenFabricacion::updateOrCreate(['fecha'=>$fecha,'urgencia'=>1],[
            'fecha' => $fecha,
            'factor_inc' => $incremento,	
            'urgencia' => 1
        ]);

        $res = [];
        foreach($articulos as $articulo){
            $res[] =[
                'id_articulo' => $articulo->id,
                'articulo' => $articulo,
                'inventario_inicial' => 0,
                'total_pedidos' => 0,
                'total_fabricar' => 0
            ];
        }
        $this->saveArticulos($orden_obj,$res);
    }
    public function finalizarOrden(Request $request){
        $orden = OrdenFabricacion::find($request->id);
        if($orden->finalizada == 0){
            $this->saveOrden($request);
            $orden->finalizada = 1;
            $orden->update();
            foreach($orden->Articulos as $articulo){
                $articulo_inv = $articulo->Articulo;
                $articulo_inv->cantidad = $articulo_inv->cantidad +  $articulo->total_fabricar;
                $articulo_inv->update();
            }
        }
        return $orden;
    }
    private function GetArticulosOrden(){
        return  Articulo::where('principal', 1)->where('ingrediente', 0)->get();
    }

    public function generarOrdenCampos($fecha, $urgencia){
        $articulos = $this->GetArticulosOrden();
        $constantes = Constantes::first();

        $fecha_arr = explode('-',$fecha);
        $fecha_pasado = (intVal($fecha_arr[0])-1).'-'.$fecha_arr[1].'-01'; // primero del mes actual del año anterior, por ejemplo fecha=2024-05-06, fecha_pasado=2023-05-01
        $time = strtotime($fecha_pasado);
        $final = date("Y-m-d", strtotime("+1 month", $time)); // fecha un mes despues de fecha_pasado, en este caso final=2023-06-01 

        $res = [];
        foreach($articulos as $articulo){
            $total_query = Articulo::where(function($query) use($articulo){
                $query->where('id',$articulo->id)->orWhere('id_produccion',$articulo->id);
            })->whereHas('PedidoItem')->withSum(['PedidoItem'=>function ($query)use ($fecha_pasado, $final){
                $query->whereHas('pedido', function ($query) use ($fecha_pasado, $final){
                    $query->whereDate('fecha','>=', $fecha_pasado)->whereDate('fecha', '<', $final);
                });
            } ],'cantidad')->get();
            $total  = 0 ;
            foreach($total_query as $item){
                $total += $item->pedido_item_sum_cantidad * $item->unidades_caja;
            }
    
            // total es como un promedio de cuantos pedidos se hicieron en el mes indicado multiplicado por las unidades por caja de un articulo
            $total = ceil(intVal($total)/cal_days_in_month(CAL_GREGORIAN, $fecha_arr[1], intVal($fecha_arr[0])-1))*$articulo->unidades_caja; // ceil redondea hacia el entero mas proximo hacia arriba
                                                                                                                                             // y cal_days_in_month devuelve la cantidad de dias del mes desdeado 
                                                                                                                                             // segun $fecha_arr
            $articulo->inicio = $fecha_pasado;
            $articulo->fin = $final;
            //foreach($items as $item){
            //    $total += $item->cantidad;
            //}
            //$articulo->items = $items;
            $articulo->total = $total;
            $total_incremento = $total*(1 + $constantes->incremento_inv/100); // total_pedido es el total de unidades antes calculado multilplicado 
                                                                              // por el porcentaje del incremnto del inventario
            $total_fabricar = $total_incremento - $articulo->cantidad;
            if($total_fabricar <0 ) $total_fabricar = 0;
            $res[] =[
                //'items'=>$items,
                'id_articulo' => $articulo->id,
                'articulo' => $articulo,
                'pedidos_items'=>$total_query,
                // 'inventario_inicial' => $articulo->cantidad,
                'inventario_inicial' => 0,
                'total_pedidos' => $total_incremento,
                'total_fabricar' =>  $total_fabricar,
                'inicio' => $fecha_pasado,
                'fin' => $final,
            ];
        }
        return ['fecha' => $fecha, 'articulos' => $res];
    }
}
