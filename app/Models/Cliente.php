<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'cliente';
    protected $fillable = [
        'nombre',
        'apellidos',
        'nombre_fiscal',
        'cif',
        'email',
        'fecha_nacimiento',
        'id_direccion_envio',
        'id_direccion_facturacion',
        'id_grupo',
        'id_tipo_cliente',
        'codigo_envio',
    ];
    public function DireccionEnvio(){
        return $this->hasOne(Direccion::class,'id','id_direccion_envio');
    }
    public function DireccionFacturacion(){
        return $this->hasOne(Direccion::class,'id','id_direccion_facturacion');
    }
    public function Grupo(){
        return $this->hasOne(ClienteGrupo::class,'id','id_grupo');
    }
    public function TipoCliente(){
        return $this->hasOne(TipoCliente::class,'id','id_tipo_cliente');
    }
}
