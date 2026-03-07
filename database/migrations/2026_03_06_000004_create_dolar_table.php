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
        Schema::create('dolar', function (Blueprint $col) {
            $col->id();
            $col->decimal('precio', 10, 2);
            $col->dateTime('fecha_actualizacion');
            // No hay timestamps standard segun el modelo Dolar
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dolar');
    }
};
