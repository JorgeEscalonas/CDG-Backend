<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'usuario';
    protected $primaryKey = 'idUsuario';
    public $timestamps = false;

    protected $fillable = [
        'nombreU',
        'contrasena',
    ];

    protected $hidden = [
        'contrasena',
    ];

    // No usar 'hashed' en casts porque las contraseñas antiguas pueden no estar hasheadas
    // protected $casts = [
    //     'contrasena' => 'hashed',
    // ];

    public function getAuthPassword()
    {
        return $this->contrasena;
    }
    
    /**
     * Verificar si la contraseña está hasheada
     */
    public function isPasswordHashed()
    {
        return password_get_info($this->contrasena)['algoName'] === 'bcrypt';
    }
}

