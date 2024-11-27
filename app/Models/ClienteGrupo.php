<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteGrupo extends Model
{
    use HasFactory;
    protected $table = 'cliente_grupo';
    protected $fillable = ['nombre'];
}
