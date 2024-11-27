<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direccion extends Model
{
    use HasFactory;
    protected $table = 'direccion';
    protected $fillable = [
        'id',
        'telefono',
        'direccion',
        'ciudad',
        'codigo_postal',
        //'id_provincia',
        'id_pais',
    ];
    public function Pais(){
        return $this->hasOne(Pais::class,'id','id_pais');
    }
}
