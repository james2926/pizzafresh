<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Constantes extends Model
{
    use HasFactory;
    public $table = 'constantes';
    public $fillable = ['incremento_inv', 'total_gr_masa', 'capacidad_max'];
}
