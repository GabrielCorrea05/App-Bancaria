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
        Schema::create('registre_bizums', function (Blueprint $table) {
            $table->id();

            //Cuenta de origen
            $table->foreignId('idCompteOrigen')->constrained('comptes')->onDelete('cascade');
            //Cuenta de destino
            $table->foreignId('idCompteDesti')->constrained('comptes')->onDelete('cascade');
            //fecha y hora del bizum
            $table->dateTime('dataBizum');
            //cantidad transferida
            $table->decimal('quantitat', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registre_bizums');
    }
};
