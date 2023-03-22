<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventosAuditables extends Model
{
    use HasFactory;
    protected $table = 'eventosauditables';

    protected $primaryKey = 'id_evento';
    
    public $timestamps = false;
}
