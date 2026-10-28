<?php

namespace Database\Seeders;

use App\Models\TipusCompte;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipus = [
            ['nom' => 'estalvi', 'descripcio' => 'Compte pensat per guardar diners i planificar objectius.'],
            ['nom' => 'corrent', 'descripcio' => 'Compte principal per operar, cobrar i enviar Bizums.'],
            ['nom' => 'inversions', 'descripcio' => 'Compte orientat a productes d inversio.'],
        ];

        foreach ($tipus as $tipusCompte) {
            TipusCompte::updateOrCreate(['nom' => $tipusCompte['nom']], $tipusCompte);
        }
    }
}
