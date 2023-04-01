<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    protected $table = 'persona';

    protected $primaryKey = ['id_documento', 'tipo_documento'];
    
    public $timestamps = false;

    protected $fillable = [
        'nombre_usuario',
        'apellidos_usuario',
        'domicilio_usuario',
        'telefonos_usuario',
        'email_usuario',
        'sexo',
        'idmunicipio',
        'celular'
    ];
    public function getNombreCompleto()
    {
        return $this->attributes['nombre_usuario']." ".$this->attributes['apellidos_usuario'];
    }

}
