<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProduccionPedido extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'produccion_pedido';
    protected $fillable = [
        'id_produccion',
        'id_pedido',
    ];
    public function Pedido(){
        return $this->hasOne(Pedido::class,'id','id_pedido');
    }
    public function Produccion(){
        return $this->hasOne(Produccion::class,'id','id_produccion');
    }
}
