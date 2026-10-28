<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// El model Compte representa la taula 'comptes'.
// Cada compte bancari pertany a un client i té un tipus (estalvi, corrent, inversions).
class Compte extends Model
{
    // $fillable: camps que es poden assignar massivament
    // client_id:        clau forana → quin client és el propietari
    // tipus_compte_id:  clau forana → quin tipus de compte és
    // iban:             número de compte bancari (format ESXX XXXX ...)
    // alias:            nom personalitzat que el client li posa al compte
    // saldo:            quantitat de diners que té el compte (decimal)
    protected $fillable = ['client_id', 'tipus_compte_id', 'iban', 'alias', 'saldo'];

    protected $casts = [
        'saldo' => 'decimal:2',
    ];

    // ── RELACIÓ N:1 amb Client 
    // Un compte PERTANY A un únic client.
    // Laravel busca a 'clients' el registre amb id = $this->client_id
    // Ús: $compte->client  →  retorna l'objecte Client propietari
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // ── RELACIÓ N:1 amb TipusCompte
    // Un compte PERTANY A un únic tipus (estalvi, corrent o inversions).
    // Laravel busca a 'tipus_comptes' el registre amb id = $this->tipus_compte_id
    // Ús: $compte->tipusCompte  →  retorna l'objecte TipusCompte
    public function tipusCompte()
    {
        return $this->belongsTo(TipusCompte::class);
    }

    // ── RELACIÓ N:M amb sí mateix via RegistreBizum 
    // Un compte pot transferir diners a molts altres comptes (bizums enviats).
    // belongsToMany(): relació molts-a-molts a través de la taula pivot 'registre_bizums'
    //   - 'idCompteOrigen': clau forana d'aquest compte a la taula pivot
    //   - 'idCompteDesti':  clau forana del compte destí a la taula pivot
    // withPivot(): inclou camps addicionals de la taula pivot en els resultats
    // Ús: $compte->cuentasConMovimientos  →  comptes als quals hem enviat bizums
    public function cuentasConMovimientos()
    {
        return $this->belongsToMany(
            Compte::class,
            'registre_bizums',    // Nom de la taula pivot
            'idCompteOrigen',     // Clau forana d'aquest model a la pivot
            'idCompteDesti'       // Clau forana del model relacionat a la pivot
        )->withPivot(['quantitat', 'dataBizum']); // Camps extres que volem de la pivot
    }

    public function bizumsEnviats()
    {
        return $this->hasMany(RegistreBizum::class, 'idCompteOrigen');
    }

    public function bizumsRebuts()
    {
        return $this->hasMany(RegistreBizum::class, 'idCompteDesti');
    }
}
