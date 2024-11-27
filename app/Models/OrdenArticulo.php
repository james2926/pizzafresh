<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenArticulo extends Model
{
    use HasFactory;
    protected $table='orden_articulo';
    protected $appends =['cajas','torres'];
    protected $fillable =[
        'id_orden',
        'id_articulo',
        'inventario_inicial',
        'total_pedidos',
        'total_fabricar',
    ];
    
    public function getCajasAttribute(){
        $cajas = $this->Articulo?->unidades_caja??1;
        if($cajas == 0) $cajas = 1;
        return $this->total_fabricar/($cajas);
    }
    public function getTorresAttribute(){
        $cajas = $this->Articulo?->unidades_caja??1;
        if($cajas == 0) $cajas = 1;
        $torres = $this->Articulo?->unidades_torre??1;
        if($torres == 0) $torres = 1;
        return $this->total_fabricar/($cajas)/($torres);
    }
    public function Orden(){
        return $this->hasOne(OrdenFabricacion::class,'id','id_orden');
    }
    public function Articulo(){
        return $this->hasOne(Articulo::class,'id','id_articulo');
    }
}
