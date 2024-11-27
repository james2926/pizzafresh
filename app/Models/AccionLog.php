<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccionLog extends Model
{
    use HasFactory;
    protected $table ='accion_log';
    protected $fillable = ['nombre'];
}
