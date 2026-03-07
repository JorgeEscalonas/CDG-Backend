<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dolar extends Model
{
    use HasFactory;

    protected $table = 'dolar';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'precio',
        'fecha_actualizacion'
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'fecha_actualizacion' => 'datetime',
    ];

    // Obtener el último precio registrado
    public static function obtenerUltimoPrecio()
    {
        return self::orderBy('fecha_actualizacion', 'desc')->first();
    }
}

