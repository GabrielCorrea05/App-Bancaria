<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\RegistreBizum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BizumController extends Controller
{
    public function create(Request $request)
    {
        $client = $request->user()->client;
        $client->load('comptes.tipusCompte');

        $clients = Client::with('user')
            ->where('id', '!=', $client->id)
            ->get();

        $idsComptes = $client->comptes->pluck('id');

        $bizums = RegistreBizum::with(['CompteOrigen.client.user', 'compteDesti.client.user'])
            ->whereIn('idCompteOrigen', $idsComptes)
            ->orWhereIn('idCompteDesti', $idsComptes)
            ->latest('dataBizum')
            ->limit(10)
            ->get();

        return view('client.bizums.create', compact('client', 'clients', 'bizums'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'compte_origen_id' => 'required|exists:comptes,id',
            'client_desti_id' => 'required|exists:clients,id',
            'quantitat' => 'required|numeric|min:0.01',
        ]);

        $client = $request->user()->client;
        $client->load('comptes');

        $compteOrigen = $client->comptes->find($request->compte_origen_id);

        if ($compteOrigen == null) {
            return back()->withErrors(['compte_origen_id' => 'Aquest compte no es teu.'])->withInput();
        }

        $clientDesti = Client::with('comptes.tipusCompte')->findOrFail($request->client_desti_id);

        if ($clientDesti->id == $client->id) {
            return back()->withErrors(['client_desti_id' => 'No pots enviar un Bizum a tu mateix.'])->withInput();
        }

        $compteDesti = null;

        foreach ($clientDesti->comptes as $compte) {
            if ($compte->tipusCompte->nom == 'corrent') {
                $compteDesti = $compte;
            }
        }

        if ($compteDesti == null) {
            $compteDesti = $clientDesti->comptes->first();
        }

        if ($compteDesti == null) {
            return back()->withErrors(['client_desti_id' => 'El client desti no te cap compte per rebre el Bizum.'])->withInput();
        }

        if ($compteOrigen->saldo < $request->quantitat) {
            return back()->withErrors(['quantitat' => 'Saldo insuficient per fer aquesta operacio.'])->withInput();
        }

        DB::beginTransaction();

        try {
            $compteOrigen->saldo = $compteOrigen->saldo - $request->quantitat;
            $compteOrigen->save();

            $compteDesti->saldo = $compteDesti->saldo + $request->quantitat;
            $compteDesti->save();

            $bizum = new RegistreBizum();
            $bizum->idCompteOrigen = $compteOrigen->id;
            $bizum->idCompteDesti = $compteDesti->id;
            $bizum->quantitat = $request->quantitat;
            $bizum->dataBizum = now();
            $bizum->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors(['quantitat' => 'No sha pogut fer el Bizum.'])->withInput();
        }

        return redirect()->route('bizums.create')->with('status', 'Bizum enviat correctament.');
    }
}
