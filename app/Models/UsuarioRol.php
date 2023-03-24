<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioRol extends Model
{
    use HasFactory;
    protected $table = 'usuariorol';

    protected $primaryKey = ['id_usuario,', 'id_rol'];
    
    public $timestamps = false;
}
