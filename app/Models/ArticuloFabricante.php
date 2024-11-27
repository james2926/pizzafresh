<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticuloFabricante extends Model
{
    use HasFactory;
    protected $table = 'articulo_fabricante';
    protected $fillable = [ 'nombre'];
}
