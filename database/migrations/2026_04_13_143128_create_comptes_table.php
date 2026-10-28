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
        Schema::create('comptes', function (Blueprint $table) {
            $table->id();

            //clau forana al cliente propietario de la cuenta
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            //clau forana al tipo de cuenta
            $table->foreignId('tipus_compte_id')->constrained()->onDelete('cascade');
            //IBAN de la cuenta bancaria
            $table->string('iban', 34)->unique(); //para que no se pueda repetir
            //Alias que el cliente puede personalizar (roollo "nomina" o "ahorros")
            $table->string('alias')->nullable(); //lo hago oopcional
            //saldo actual de la cuenta en euros
            $table->decimal('saldo', 10, 2)->default(0.00); //lo pongo predeterminado a 0
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comptes');
    }
};
