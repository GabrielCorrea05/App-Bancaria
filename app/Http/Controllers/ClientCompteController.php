<?php

namespace App\Http\Controllers;

use App\Models\Compte;
use App\Models\RegistreBizum;
use App\Models\TipusCompte;
use Illuminate\Http\Request;

class ClientCompteController extends Controller
{
    public function create()
    {
        return view('client.comptes.create', [
            'tipusComptes' => TipusCompte::orderBy('nom')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipus_compte_id' => ['required', 'exists:tipus_comptes,id'],
            'alias' => ['required', 'string', 'max:255'],
        ]);

        $client = $request->user()->client()->firstOrFail();

        Compte::create([
            'client_id' => $client->id,
            'tipus_compte_id' => $validated['tipus_compte_id'],
            'iban' => $this->generateIban(),
            'alias' => $validated['alias'],
            'saldo' => 0,
        ]);

        return redirect()->route('dashboard')->with('status', 'Compte creat correctament.');
    }

    public function show(Request $request, Compte $compte)
    {
        abort_unless($compte->client->user_id === $request->user()->id, 403);

        $moviments = RegistreBizum::with(['CompteOrigen.client.user', 'compteDesti.client.user'])
            ->where('idCompteOrigen', $compte->id)
            ->orWhere('idCompteDesti', $compte->id)
            ->latest('dataBizum')
            ->get();

        return view('client.comptes.show', compact('compte', 'moviments'));
    }

    ///preguntado al chat para poder randomizar
    private function generateIban(): string
    {
        do {
            $iban = 'ES'.random_int(10, 99).' '.random_int(1000, 9999).' '.random_int(1000, 9999).' '.random_int(10, 99).random_int(1000000000, 9999999999);
        } while (Compte::where('iban', $iban)->exists());

        return $iban;
    }
}
