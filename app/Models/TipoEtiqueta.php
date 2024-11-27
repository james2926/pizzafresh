<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEtiqueta extends Model
{
    use HasFactory;
    protected $table = "tipo_etiqueta";
    protected $fillable = ['nombre'];
}
