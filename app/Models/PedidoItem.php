<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoItem extends Model
{
    use HasFactory;
    protected $table = 'pedido_item';
    protected $fillable = [
        'id_pedido',
        'id_articulo',
        'cantidad',
        'precio',
        'sin_stock',
        'cantidad_servida'
    ];
    public function Pedido(){
        return $this->hasOne(Pedido::class,'id','id_pedido');
    }
    public function Articulo(){
        return $this->hasOne(Articulo::class,'id','id_articulo');
    }
}
