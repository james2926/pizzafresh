<?php

namespace App\Http\Controllers\ApiControllers;
use  App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\PedidoItem;
use  App\Events\NuevoPedido;
use App\Models\EstadoPedido;
use App\Models\ArticuloReceta;
use App\Models\Articulo;
class PedidoController extends Controller
{
    public function getEstadosPedido(){
        return EstadoPedido::all();
    }
    public function getPedido($id){
        $fecha = date('Y-m-d');
        $pedido = Pedido::with(['Items.Articulo'])
        ->with(['ProduccionPedidoHoy'])->find($id);
        return $pedido;
    }
    public function getPedidos(Request $request){
        $pedido = Pedido::with(['Items.Articulo','Cliente','ProduccionPedidoHoy']);
        if($request->start){
            $pedido->whereDate('fecha','>=',$request->start);
        }
        if($request->end){
            $pedido->whereDate('fecha','<=',$request->end);
        }
        if($request->busqueda){
            $pedido->where(function($query) use ($request){
                $query->where('nro','like','%'.$request->busqueda.'%');
                $query->orWhere('id','like','%'.$request->busqueda.'%');
                $query->orWhereHas('Cliente',function ($query) use($request){
                    $query->where('nombre_fiscal','like','%'.$request->busqueda.'%');
                    $query->orWhere('codigo_envio','like','%'.$request->busqueda.'%');
                });
            });
        }
        if($request->sort_by != null){
            $pedido->orderBy($request->sort_by,$request->sort_desc == 'false'?'ASC':'DESC');
        }
        else{
            $pedido->orderBy('id_prestashop', 'DESC');
        }
        return $pedido->paginate($request->cantidad??15);
    }
    public function setPedidoState(Request $request){
        try{
            $pedido = Pedido::find($request->id);
            if($pedido){
                $pedido->id_estado = $request->id_estado;

                if(!isset($pedido->fecha_empaquetado) && $request->id_estado == 2){
                    $pedido->fecha_empaquetado = Carbon::parse($request->fecha_cambio_estado)->format('Y-m-d'); 
                }

                $pedido->update();
                $this->savePedidoItems($pedido,$request->items);
                event(new NuevoPedido());

                return Pedido::with('Items.Articulo')->find($request->id);
            }   
        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
    public function deletePedido($id){
        return Pedido::find($id)->delete();
    }
    public function savePedido(Request $request){
        if($request->fecha == null ){
            $request->fecha = date('Y-m-d H:i:s');
        }
        $pedido = Pedido::updateOrCreate(['id'=>$request->id], $request->all());
        $this->savePedidoItems($pedido,$request->items);
        try{
            event(new NuevoPedido());

        }catch(\Exception $ex){

        }
       
    }

    public function savePedidoItems($pedido,$items){
        $ids = [];
        foreach($items as $item){
            $cantidad_servida = $item['cantidad_servida']??0; // enviada en la request

            $articulo = Articulo::find($item['id_articulo']);
            $unidades_cajs = $articulo->unidades_caja;
            $item['cantidad'] = $item['cantidad'] / $unidades_cajs;
            $ca = $articulo?->unidades_caja??1; // unidades del articulo que conforman una caja 
            
            if($ca == 0) $ca = 1; // si las unidades_caja = 0 entonces pasar a 1 por defcto
            
            // Si el pedido esta pedniente entonces la cantidad srvida sera de 0, es decir,
            // falta entregar el total del pedido
            if($pedido->id_estado == 1){ 
                $cantidad_servida = 0;
            }

            // Si el pedido fue completado entonces la cantidad_servida (en cajas) 
            // sera la cantidad total del pedido multiplicando por articulo.unidades_caja 
            if($pedido->id_estado == 2){
                $cantidad_servida = $item['cantidad']*$ca;
            }

            if(($item['id']??null) != null){    
                $pedidoItem = PedidoItem::find($item['id']);
                $recetas = ArticuloReceta::where('id_articulo', '=', $item['id_articulo'])->get();

                if($pedidoItem != null){
                    // Si el pedfido se ha empaquetado parcialmente entonces la cantidad servida sera 
                    // la cantidad servida del pedido multiplicado por articulo.unidades_caja
                    if($pedido->id_estado == 3){
                        $cantidad_und = intval($item['cantidad_servida'])*$ca;
                        $inventario = $cantidad_und - ($pedidoItem->cantidad_servida)*$ca;

                        if($recetas) {
                            $result = intval($item['cantidad_servida']) - $pedidoItem->cantidad_servida;
                            foreach($recetas as $receta) {
                                $ingrediente = Articulo::where('id', '=', $receta->id_ingrediente)->first();
                                $ingrediente->cantidad -= $receta->cantidad * $result;
                                $ingrediente->update();
                            }
                        }
                    } else if($pedido->id_estado == 2){
                        $inventario = $cantidad_servida - ($pedidoItem->cantidad_servida)*$ca;
                        
                        if($recetas) {
                            $result = $pedidoItem->cantidad - $pedidoItem->cantidad_servida;

                            foreach($recetas as $receta) {                                
                                $ingrediente = Articulo::where('id', '=', $receta->id_ingrediente)->first();
                                $ingrediente->cantidad -= $receta->cantidad * $result;
                                $ingrediente->update();
                            }
                        }
                    }else{
                        $inventario = $cantidad_servida - $pedidoItem->cantidad_servida;
                    }

                    $articulo = $pedidoItem->Articulo;
                    $articulo->cantidad -= $inventario;
                    $articulo->update();
                }
            }

            $item_obj = PedidoItem::updateOrCreate(['id'=>$item['id']??null],[
                'id_pedido'=>$pedido->id,
                'id_articulo'=>$item['id_articulo'],
                'cantidad'=>$item['cantidad'],
                'precio'=>$item['precio'],
                'sin_stock'=>$item['sin_stock']??0,
                'cantidad_servida'=>$cantidad_servida,
            ]);

            // dump($item_obj);
            $ids[] = $item_obj->id;
        }
        PedidoItem::where('id_pedido',$pedido->id)->whereNotIn('id',$ids)->delete();
    }

    public function updatePedidoItem(Request $request) {
        if ($request->has(['id', 'value', 'articulo_id'])) {
            $value = $request->value;
            $articulo_id = $request->articulo_id;
    
            // Find the Articulo and check if it exists
            $articulo = Articulo::find($articulo_id);

            if (!$articulo) {
                return response()->json(['status' => 'error', 'message' => 'Articulo not found'], 404);
            }
            
            $unidades_cajas = $articulo->unidades_caja;
    
            $parcial = null;
            if (is_string($value) && str_contains($value, '/')) {
                $parcial = explode('/', $value);
                $cantidad = $parcial[1];
            } else {
                $cantidad = $value;
            }
    
            // Find the PedidoItem and check if it exists
            $pedidoItem = PedidoItem::find($request->id);
            if (!$pedidoItem) {
                return response()->json(['status' => 'error', 'message' => 'PedidoItem not found'], 404);
            }
    
            // Set cantidad, dividing by unidades_cajs
            $pedidoItem->cantidad = $cantidad / $unidades_cajas;
    
            // If $parcial is set, assign cantidad_servida
            if ($parcial != null) {
                $pedidoItem->cantidad_servida = $parcial[0];
            }
    
            $pedidoItem->save();
    
            return response()->json(['status' => 'success']);
        }
    
        return response()->json(['status' => 'error', 'message' => 'Invalid request'], 400);
    }
    

    public function exitPedidoItem(Request $request) {
        $existItem = PedidoItem::where('id_pedido', '=', $request->id)->where('id_articulo', '=', $request->articulo_id)->first();
        if($existItem) {
            return response()->json(['result' => true]);
        } else {
            return response()->json(['result' => false]);
        }
    }

    public function savePedidoItem(Request $request) {
        if ($request->all()) {
            if($request->cantidad != null) {
                $articulo = Articulo::find($request->articulo_id);
                $pedido = Pedido::find($request->id);
                $cantidad_servida = 0;

                $value = $request->cantidad;
                if(is_string($value) && str_contains($value, '/')){
                    $parcial = explode('/', $request->cantidad);
                    $cantidad_servida = $parcial[0];
                    $cantidad = $parcial[1];
                }else{
                    $cantidad = $request->cantidad;
                }

                if($pedido->id_estado != 1) {
                    // dump($pedido->id_estado);
                    $cantidad_servida = $cantidad * $articulo->unidades_caja;
                }

                $articulo = Articulo::find($request->articulo_id);

                if (!$articulo) {
                    return response()->json(['status' => 'error', 'message' => 'Articulo not found'], 404);
                }
                
                $unidades_cajas = $articulo->unidades_caja;

                $precio = $articulo->precio;

                $pedidoItem = new PedidoItem;
    
                $pedidoItem->id_pedido          = $request->id;
                $pedidoItem->id_articulo        = $request->articulo_id;
                $pedidoItem->cantidad           = $cantidad / $unidades_cajas;
                $pedidoItem->cantidad_servida   = $cantidad_servida;
                $pedidoItem->precio             = $precio;
    
                $pedidoItem->save();
            
                return response()->json(['status' => 'success']);
            }
        }
    }
}
