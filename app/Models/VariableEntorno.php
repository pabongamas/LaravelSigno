<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariableEntorno extends Model
{
    use HasFactory;

    protected $table = 'variableentorno';

    protected $primaryKey = 'codigo_variable';

    public $timestamps = false;
}
