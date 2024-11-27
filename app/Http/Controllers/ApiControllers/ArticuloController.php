<?php

namespace App\Http\Controllers\ApiControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Articulo;
use App\Models\ArticuloFamilia;
use App\Models\ArticuloFabricante;
use App\Models\ArticuloReceta;
use App\Models\TipoEtiqueta;
class ArticuloController extends Controller
{
    ///CRUD
    public function getArticulos(){
        return Articulo::with('Produccion')->get();
    }
    public function filterArticulos(Request $request){

        $articulo = Articulo::with('Produccion');

        if ($request->busqueda) {
            $articulo->where(function($query) use ($request) {
                $query->where('nombre', 'like', '%' . $request->busqueda . '%')
                    ->orWhere('ref', 'like', '%' . $request->busqueda . '%')
                    ->orWhere('descripcion', 'like', '%' . $request->busqueda . '%');
            });
        }

        if ($request->familias && is_array($request->familias)) {
            $articulo->whereIn('id_familia', $request->familias);
        }

        return $articulo->paginate($request->cantidad ?? 15);
    }
    public function fix(){
        $articulos = Articulo::with('Produccion')->get();
        foreach($articulos as $articulo){
            $arr = explode(',',$articulo->nombre);
            if(count($arr)>1){
                $articulo->nombre = $arr[0];
                $articulo->update();
            }
        }
    }
    public function getArticulo($id){
        return Articulo::with(['Recetas.Ingrediente'])->find($id);
    }
    public function getArticuloProduccion(){
        return Articulo::with(['Recetas.Ingrediente'])->where('principal',1)->get();

    }
    public function saveArticulo(Request $request){
        $articulo =  Articulo::updateOrCreate(['id'=>$request->id],$request->all());
        if($request->id != $articulo->id){
            $last = Articulo::orderBy('sorting_index','DESC')->first();
            $articulo->sorting_index = $last->sorting_index
            +1;
        }
        if($request->recetas){
            $this->saveReceta($articulo,$request->recetas);

        }
    }
    public function deleteArticulo($id){
        return Articulo::find($id)->delete();
    }
    //funciones
    public function saveReceta($articulo, $recetas){
        $ids = [];
        foreach($recetas as $receta){
            $obj = ArticuloReceta::updateOrCreate(['id'=>$receta['id']??null],[
                'id_articulo'=>$articulo->id,
                'id_ingrediente'=>$receta['id_ingrediente'],
                'cantidad'=>$receta['cantidad']
            ]);
            $ids []= $obj->id;
        }
        
        ArticuloReceta::where('id_articulo',$articulo->id)->whereNotIn('id',$ids)->delete();

    }
    ///Etiqueta
    public function getTiposEtiqueta(){
        return TipoEtiqueta::all();
    }
    //Familia
    public function getFamilias(){
        return ArticuloFamilia::all();
    }
    public function getFamilia($id){
        return ArticuloFamilia::find($id);
    }
    public function saveFamilia(Request $request){
        ArticuloFamilia::updateOrCreate(['id'=>$request->id],['nombre'=>$request->nombre]);
        return $this->getFamilias();

    }
    public function deleteFamilia($id){
        ArticuloFamilia::find($id)->delete();
        return $this->getFamilias();

    }
    //Fabricante
    public function getFabricantes(){
        return ArticuloFabricante::all();
    }
    public function getFabricante($id){
        return ArticuloFabricante::find($id);
    }
    public function saveFabricante(Request $request){
         ArticuloFabricante::updateOrCreate(['id'=>$request->id],['nombre'=>$request->nombre]);
         return $this->getFabricantes();
    }
    public function deleteFabricante($id){
        ArticuloFabricante::find($id)->delete();
        return $this->getFabricantes();

    }
}
