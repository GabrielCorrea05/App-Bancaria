<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// El model RegistreBizum representa la taula 'registre_bizums'.
// Cada registre és una transferència de diners entre dos comptes bancaris.
// Funciona com a taula pivot entre Compte i Compte (relació N:M consigo mateix).
class RegistreBizum extends Model
{
    // $fillable: camps assignables massivament
    // idCompteOrigen: id del compte que ENVIA els diners (clau forana → comptes)
    // idCompteDesti:  id del compte que REP els diners (clau forana → comptes)
    // dataBizum:      data i hora en que es va fer la transferència
    // quantitat:      import transferit en euros (decimal)
    protected $fillable = ['idCompteOrigen', 'idCompteDesti', 'dataBizum', 'quantitat'];

    protected $casts = [
        'dataBizum' => 'datetime',
        'quantitat' => 'decimal:2',
    ];

    // ── RELACIÓ amb el Compte origen
    // belongsTo() indica que aquest bizum pertany a un compte origen.
    // El segon paràmetre 'idCompteOrigen' indica quina columna és la clau forana
    // (cal especificar-la perquè no segueix la convenció per defecte de Laravel)
    // Ús: $bizum->CompteOrigen  →  retorna l'objecte Compte que va enviar els diners
    public function CompteOrigen()
    {
        return $this->belongsTo(Compte::class, 'idCompteOrigen');
    }

    // ── RELACIÓ amb el Compte destí
    // Igual que l'anterior però per al compte que rep els diners.
    // Ús: $bizum->compteDesti  →  retorna l'objecte Compte que va rebre els diners
    public function compteDesti()
    {
        return $this->belongsTo(Compte::class, 'idCompteDesti');
    }
}
