<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'producto';
    protected $primaryKey = 'idProducto';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'pvp',
        'costo',
        'idProveedor',
        'idCategoria'
    ];

    protected $casts = [
        'pvp' => 'decimal:2',
        'costo' => 'decimal:2',
    ];

    // Relaciones
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'idProveedor', 'idProveedor');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'idCategoria', 'idCategoria');
    }

    // Boot method para calcular PVP automáticamente
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($producto) {
            if (isset($producto->costo) && !isset($producto->pvp)) {
                $producto->pvp = $producto->costo / 0.7;
            }
        });

        static::updating(function ($producto) {
            if (isset($producto->costo)) {
                $producto->pvp = $producto->costo / 0.7;
            }
        });
    }
}

