<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Compte;
use App\Models\RegistreBizum;
use App\Models\TipusCompte;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        if ($request->user()->email === 'admin@admin.cat') {
            return view('admin.dashboard', [
                'clients' => Client::with('user')->latest()->get(),
                'tipusComptes' => TipusCompte::withCount('comptes')->get(),
                'comptes' => Compte::with(['client.user', 'tipusCompte'])->latest()->get(),
                'bizums' => RegistreBizum::with(['CompteOrigen.client.user', 'compteDesti.client.user'])->latest()->get(),
            ]);
        }

        $client = $request->user()->client()->with(['comptes.tipusCompte'])->firstOrFail();
        $compteIds = $client->comptes->pluck('id');

        $moviments = RegistreBizum::with(['CompteOrigen.client.user', 'compteDesti.client.user'])
            ->whereIn('idCompteOrigen', $compteIds)
            ->orWhereIn('idCompteDesti', $compteIds)
            ->latest('dataBizum')
            ->limit(10)
            ->get();

        return view('client.dashboard', compact('client', 'moviments'));
    }
}
