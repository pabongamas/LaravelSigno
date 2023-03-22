<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;

    protected $table = 'tarea';

    protected $primaryKey = 'id_tarea';
    
    public $timestamps = false;

    const DATOS_NOTARIA = 2;
}
