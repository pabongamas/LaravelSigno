<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilTarea extends Model
{
    use HasFactory;
    protected $table = 'perfiltarea';

    protected $primaryKey = ['id_perfil', 'id_tarea'];
    
    public $timestamps = false;
}
