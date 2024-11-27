<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $table ='pedido';
    protected $fillable =[
        'nro',
        'id_cliente',
        'gastos_envio',
        'descuento',
        'id_prestashop',
        'fecha',
        'fecha_empaquetado',
        'id_estado',
        'cod_barras'
    ];
    protected $appends = ['total_cantidad','total_bolas','total_cajas'];

    protected $casts = [
        'fecha_empaquetado' => 'datetime:Y-m-d',
    ];

    public function getTotalAttribute(){
        $total = 0;
        foreach($this->Items as $item){
            $total += $item->cantidad*$item->precio;
        }
        $total -= $this->descuento;
        $total *= 1.21;
        return $total;
    }
    public function getTotalCantidadAttribute(){
        $total = 0;
        foreach($this->Items as $item){
            $total += $item->cantidad;
        }
   
        return $total;
    }
    public function getTotalBolasAttribute(){
        $total = 0;
        foreach($this->Items as $item){
            $rate = 1;
            if($item->Articulo)if($item->Articulo->Produccion) $rate = $item->Articulo->Produccion->unidades_caja;
            $total += $item->cantidad*$rate;
        }
   
        return $total;
    }
    public function getTotalCajasAttribute(){
        $total = 0;
        foreach($this->Items as $item){
            $rate = 1;
            $rate = $item?->Articulo?->unidades_caja??0;
            $total += $item->cantidad*$rate;
        }
   
        return $total;
    }
    public function Estado(){
        return $this->hasOne(EstadoPedido::class,'id_estado','id');
    }
    public function Items(){
        return $this->hasMany(PedidoItem::class,'id_pedido','id');
    }
    public function ItemsSorted(){
        return $this->hasMany(PedidoItem::class,'id_pedido','id');
    }
    public function Cliente(){
        return $this->hasOne(Cliente::class,'id','id_cliente');
    }
    public function ProduccionPedido(){
        return $this->hasOne(ProduccionPedido::class,'id_pedido','id');
    }
    public function ProduccionPedidoHoy(){
        $fecha = date('Y-m-d');
      
        return $this->ProduccionPedido()->whereHas('Produccion',function($query)use($fecha){
                $query->where('fecha',$fecha);
            });
        
    }
}
