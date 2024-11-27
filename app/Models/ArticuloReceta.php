<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticuloReceta extends Model
{
    use HasFactory;
    protected $table = 'articulo_receta';
    protected $fillable = [ 'id_articulo','id_ingrediente','cantidad'];
    public function Articulo(){
        return $this->hasOne(Articulo::class,'id','id_articulo');
    }
    public function Ingrediente(){
        return $this->hasOne(Articulo::class,'id','id_ingrediente');
    }
}
