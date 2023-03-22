<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditoriaPrincipal extends Model
{
    use HasFactory;
    protected $table = 'auditoriaprincipal';

    protected $primaryKey = 'id_auditoriaprincipal';
    
    public $timestamps = false;
}
