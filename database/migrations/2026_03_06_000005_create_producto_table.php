<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('producto', function (Blueprint $col) {
            $col->id('idProducto');
            $col->string('nombre', 100);
            $col->decimal('costo', 10, 2);
            $col->decimal('pvp', 10, 2);
            
            // Relaciones
            $col->unsignedBigInteger('idProveedor');
            $col->unsignedBigInteger('idCategoria');

            $col->foreign('idProveedor')->references('idProveedor')->on('proveedor')->onDelete('cascade');
            $col->foreign('idCategoria')->references('idCategoria')->on('categoria')->onDelete('cascade');
            
            // No hay timestamps segun el modelo Producto
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto');
    }
};
