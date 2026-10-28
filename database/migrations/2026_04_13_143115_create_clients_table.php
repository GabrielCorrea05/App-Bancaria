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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            //Clau forana que relaciona cada cliente con un usuario (relacion 1:1)
            $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
            //Campos propios del cliente
            $table->string('dni', 9)->unique(); //dni string de 9 caracteres
            $table->date('data_naixement'); //fecha de nacimiento -> fecha de nacimiento
            $table->string('telefon', 15); //telefono lo he hecho con una string de 15 caracteres aun que podria ser un numero tambien
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
