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
        Schema::create('tipus_comptes', function (Blueprint $table) {
            $table->id();

            //Nombre del tipo (ahorros, inversiones olo que sea)
            $table->string('nom');
            //descripcion opcional del tipo de cuenta
            $table->string('descripcio')->nullable();
            //Imagen opcional del tipo de cuenta
            $table->string('imatge')->nullable();

            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipus_comptes');
    }
};
