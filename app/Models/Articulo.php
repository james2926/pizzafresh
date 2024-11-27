<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    use HasFactory;
    protected $table = 'articulo';
    protected $fillable = [
        'ref',
        'nombre',
        'descripcion',
        'id_familia',
        'id_fabricante',
        'venta_stock',
        'peso',
        'cantidad',
        'id_tipo_etiqueta',
        'precio',
        'principal',
        'id_produccion',
        'id_prestashop',
        'unidades_torre',
        'unidades_caja',
        'ingrediente',
        'sorting_index'
    ];
    public function PedidoItem(){
        return $this->hasMany(PedidoItem::class,'id_articulo','id');
    }
    public function Recetas(){
        return $this->hasMany(ArticuloReceta::class,'id_articulo','id');
    }
    public function IngredienteDe(){
        return $this->hasMany(ArticuloReceta::class,'id_ingrediente','id');
    }
    public function Familia(){
        return $this->hasOne(ArticuloFamilia::class,'id','id_familia');
    }
    public function Fabricante(){
        return $this->hasOne(ArticuloFabricante::class,'id','id_fabricante');
    }
    public function Produccion(){
        if($this->principal) return $this->hasOne(Articulo::class,'id','id');
        return $this->hasOne(Articulo::class,'id','id_produccion');
    }
    public function ProduccionArticulo(){
        return $this->hasOne(ProduccionArticulo::class,'id_articulo','id');
    }
}
