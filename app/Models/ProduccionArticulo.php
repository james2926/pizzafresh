<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduccionArticulo extends Model
{
    use HasFactory;
    protected $table = 'produccion_articulo';
    protected $fillable = [
        'id_produccion',
        'inventario',
        'id_articulo',
        'total_a_fabricar',
        'etiquetas_impresas',
    ];
    public function Articulo(){
        return $this->hasOne(Articulo::class,'id','id_articulo');
    }
    public function Produccion(){
        return $this->hasOne(Produccion::class,'id','id_produccion');
    }
}
