<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// El model TipusCompte representa la taula 'tipus_comptes'.
// Guarda els tipus de compte que existeixen: Estalvi, Corrent, Inversions.
// Aquests valors es carreguen amb el Seeder i no els crea l'usuari.
class TipusCompte extends Model
{
    // $fillable: camps assignables massivament
    // nom:       nom del tipus (ex: "Corrent")
    // descripcio: descripció opcional del tipus de compte
    // imatge:    camp opcional per una imatge (no usat de moment)
    protected $fillable = ['nom', 'descripcio', 'imatge'];

    // ── RELACIÓ 1:N amb Compte 
    // Un tipus de compte pot estar assignat a MOLTS comptes.
    // Laravel busca a 'comptes' tots els registres amb tipus_compte_id = $this->id
    // Ús: $tipusCompte->comptes  →  retorna tots els comptes d'aquest tipus
    public function comptes()
    {
        return $this->hasMany(Compte::class);
    }
}
