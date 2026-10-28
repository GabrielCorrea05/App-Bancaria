<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; // Classe base de tots els models Eloquent

// El model Client representa la taula 'clients' de la BD.
// Cada client és una persona que té un compte bancari a l'aplicació.
// Un Client sempre está associat a un User (per poder fer login).
class Client extends Model
{
    // $fillable: camps que es poden emplenar amb Client::create([...]) o $client->update([...])
    // user_id: clau forana que apunta a la taula users
    // dni: document nacional d'identitat (màxim 9 caràcters)
    // data_naixement: data de naixement del client
    // telefon: número de telèfon de contacte
    protected $fillable = ['user_id', 'dni', 'data_naixement', 'telefon'];

    protected $casts = [
        'data_naixement' => 'date',
    ];

    // ── RELACIÓ 1:1 amb User 
    // belongsTo() indica que aquest Client PERTANY A un User.
    // Laravel buscarà a la taula 'users' el registre amb id = $this->user_id
    // Ús: $client->user  →  retorna l'objecte User d'aquest client
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ── RELACIÓ 1:N amb Compte 
    // hasMany() indica que un Client pot tenir MOLTS Comptes bancaris.
    // Laravel buscarà a la taula 'comptes' tots els registres amb client_id = $this->id
    // Ús: $client->comptes  →  retorna una col·lecció de Compte
    //     $client->comptes() →  retorna el QueryBuilder (per afegir filtres)
    public function comptes()
    {
        return $this->hasMany(Compte::class);
    }
}
