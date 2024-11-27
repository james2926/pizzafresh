<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenFabricacion extends Model
{
    use HasFactory;
    protected $table = 'orden_fabricacion';
    protected $fillable = [
        'fecha',
        'factor_inc',
        'observaciones',
        'urgencia',
        'finalizada'
    ];
 
    public function Articulos(){
        return $this->hasMany(OrdenArticulo::class,'id_orden','id');
    }
}
