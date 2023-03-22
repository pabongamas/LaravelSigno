<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccionAuditable extends Model
{
    use HasFactory;
    protected $table = 'accionauditable';

    protected $primaryKey = 'idaccionauditable';
    
    public $timestamps = false;

    const Insercion = 1;
    const Modificacion = 2;
    const Eliminacion = 3;
    const Expedicion = 4;
    const IngresoAlSistema = 5;
    const CierreDelSistema = 6;
    const Imprecion = 7;
}
