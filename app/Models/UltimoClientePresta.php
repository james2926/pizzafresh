<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UltimoClientePresta extends Model
{
    use HasFactory;
    protected $table = 'ultimo_cliente_presta';
    protected $fillable = ['id_cliente'];
}
