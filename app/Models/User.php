<?php

// Espai de noms del model
namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Permet crear usuaris de prova amb factories
use Illuminate\Foundation\Auth\User as Authenticatable; // Classe base que gestiona l'autenticació
use Illuminate\Notifications\Notifiable;               // Permet enviar notificacions (email, etc.)

// El model User representa la taula 'users' de la base de dades.
// Extén Authenticatable perquè Laravel pugui fer el login/logout amb aquest model.
class User extends Authenticatable
{
    // HasFactory: permet usar User::factory()->create() per generar usuaris de prova
    // Notifiable: permet enviar notificacions com emails de restabliment de contrasenya
    use HasFactory, Notifiable;

    // $fillable: llista de camps que es poden assignar massivament (p.ex. User::create([...]))
    // Els camps que NO hi siguin estan protegits contra assignació massiva (seguretat)
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // $hidden: camps que s'amaguen quan convertim el model a JSON o array
    // (per exemple quan retornem l'usuari en una API, la contrasenya no es mostra)
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // casts(): defineix com es converteixen automàticament els camps
    // 'email_verified_at' => 'datetime': es converteix a objecte Carbon (dates)
    // 'password' => 'hashed': quan assignem la contrasenya, es fa hash automàticament
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ── RELACIÓ 1:1 amb Client 
    // hasOne() indica que un User TÉ UN Client associat.
    // Laravel buscarà a la taula 'clients' un registre amb user_id = $this->id
    // Ús: $user->client  →  retorna l'objecte Client d'aquest usuari
    public function client()
    {
        return $this->hasOne(Client::class);
    }
}
