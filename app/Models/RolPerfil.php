<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolPerfil extends Model
{
    use HasFactory;
    protected $table = 'rolperfil';

    protected $primaryKey = ['id_rol', 'id_perfil'];
    
    public $timestamps = false;
}
