<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    protected $table='log';
    protected $fillable = ['id_usuario','id_accion'];
    public function User(){
        return $this->hasOne(User::class,'id','id_usuario');
    }
    public function Accion(){
        return $this->hasOne(AccionLog::class,'id','id_accion');
    }
}
