<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Compte;
use App\Models\TipusCompte;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
       $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'email'           => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'        => ['required', 'confirmed', 'min:8'],
            'dni'             => ['required', 'string', 'max:20', 'unique:clients'],
            'data_naixement'  => ['required', 'date'],
            'telefon'         => ['required', 'string', 'max:20'],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Crear el client associat a l'usuari (relació 1:1)
        Client::create([
            'user_id'         => $user->id,
            'dni'             => $request->dni,
            'data_naixement'  => $request->data_naixement,
            'telefon'         => $request->telefon,
        ]);

        $client = $user->client;
        $corrent = TipusCompte::firstOrCreate(['nom' => 'corrent'], ['descripcio' => 'Compte principal per operar.']);
        $estalvi = TipusCompte::firstOrCreate(['nom' => 'estalvi'], ['descripcio' => 'Compte per guardar diners.']);

        Compte::create([
            'client_id' => $client->id,
            'tipus_compte_id' => $corrent->id,
            'iban' => $this->generateIban(),
            'alias' => 'Compte corrent',
            'saldo' => 1000,
        ]);

        Compte::create([
            'client_id' => $client->id,
            'tipus_compte_id' => $estalvi->id,
            'iban' => $this->generateIban(),
            'alias' => 'Estalvis',
            'saldo' => 500,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');
    }

    private function generateIban(): string
    {
        do {
            $iban = 'ES'.random_int(10, 99).' '.random_int(1000, 9999).' '.random_int(1000, 9999).' '.random_int(10, 99).random_int(1000000000, 9999999999);
        } while (Compte::where('iban', $iban)->exists());

        return $iban;
    }
    
}
