<?php

namespace App\Http\Controllers\ApiControllers;
use  App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pais;
use App\Models\Constantes;

class AuxController extends Controller
{
    public function getPaises(){
        return Pais::where('activo',1)->get();
    }
    public function getConstantes(){
        $cons =Constantes::first();
        if($cons == null){
            return ['id'=>null];
        }
        return $cons;
    }
    public function saveConstantes(Request $request){
        $const = Constantes::first();
        $id = null;
        if($const){
            $id = $const->id;
        }
        return Constantes::updateOrCreate(['id'=>$id],$request->all());
        
        
    }
}
