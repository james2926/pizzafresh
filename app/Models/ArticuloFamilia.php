<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticuloFamilia extends Model
{
    use HasFactory;
    protected $table = 'articulo_familias';
    protected $fillable = [ 'nombre'];
}
