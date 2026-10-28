<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Compte;
use App\Models\RegistreBizum;
use App\Models\TipusCompte;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function show(string $section, int $id)
    {
        return view('admin.show', [
            'section' => $section,
            'item' => $this->findItem($section, $id),
        ]);
    }

    public function edit(string $section, int $id)
    {
        return view('admin.edit', [
            'section' => $section,
            'item' => $this->findItem($section, $id),
            'clients' => Client::with('user')->get(),
            'tipusComptes' => TipusCompte::all(),
            'comptes' => Compte::with('client.user')->get(),
        ]);
    }

    public function update(Request $request, string $section, int $id)
    {
        $item = $this->findItem($section, $id);

        if ($section === 'clients') {
            $item->update($request->validate([
                'dni' => ['required', 'string', 'max:9', 'unique:clients,dni,'.$item->id],
                'data_naixement' => ['required', 'date'],
                'telefon' => ['required', 'string', 'max:15'],
            ]));
        }

        if ($section === 'tipus-comptes') {
            $item->update($request->validate([
                'nom' => ['required', 'string', 'max:255'],
                'descripcio' => ['nullable', 'string', 'max:255'],
            ]));
        }

        if ($section === 'comptes') {
            $item->update($request->validate([
                'client_id' => ['required', 'exists:clients,id'],
                'tipus_compte_id' => ['required', 'exists:tipus_comptes,id'],
                'iban' => ['required', 'string', 'max:34', 'unique:comptes,iban,'.$item->id],
                'alias' => ['nullable', 'string', 'max:255'],
                'saldo' => ['required', 'numeric', 'min:0'],
            ]));
        }

        if ($section === 'bizums') {
            $item->update($request->validate([
                'idCompteOrigen' => ['required', 'exists:comptes,id'],
                'idCompteDesti' => ['required', 'exists:comptes,id', 'different:idCompteOrigen'],
                'dataBizum' => ['required', 'date'],
                'quantitat' => ['required', 'numeric', 'min:0.01'],
            ]));
        }

        return redirect()->route('admin.show', [$section, $id])->with('status', 'Element actualitzat.');
    }

    public function destroy(string $section, int $id)
    {
        $this->findItem($section, $id)->delete();

        return redirect()->route('dashboard')->with('status', 'Element esborrat.');
    }

    private function findItem(string $section, int $id)
    {
        return match ($section) {
            'clients' => Client::with(['user', 'comptes.tipusCompte'])->findOrFail($id),
            'tipus-comptes' => TipusCompte::with('comptes')->findOrFail($id),
            'comptes' => Compte::with(['client.user', 'tipusCompte', 'bizumsEnviats', 'bizumsRebuts'])->findOrFail($id),
            'bizums' => RegistreBizum::with(['CompteOrigen.client.user', 'compteDesti.client.user'])->findOrFail($id),
            default => abort(404),
        };
    }
}
