<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produccion extends Model
{
    use HasFactory;
    protected $table = 'produccion';
    protected $fillable = ['horas','fecha','observaciones'];
    public function Pedidos(){
        return $this->hasMany(ProduccionPedido::class,'id_produccion','id')->whereHas('Pedido');
    }
    public function Articulos(){
        return $this->hasMany(ProduccionArticulo::class,'id_produccion','id')->whereHas('Articulo',function ($query){
            $query->where('principal',0);
        });
    }
}
