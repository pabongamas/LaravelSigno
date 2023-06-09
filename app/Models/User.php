<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Rol;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $primaryKey = 'id_usuario';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'login',
        'clave',
        'estado',
        'horasacceso',
        'id_documento',
        'tipo_documento',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'clave',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];

    public function getAuthPassword()
    {
        return $this->clave;
    }
    public function getAuthIdentifier(){
        return $this->id_usuario;
    }
    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'usuariorol','id_usuario', 'usuariorol.id_rol');
    }
    public function hasRole($roleName)
    {
        return $this->roles()->where('usuariorol.id_rol', $roleName)->exists();
    }
   
}
