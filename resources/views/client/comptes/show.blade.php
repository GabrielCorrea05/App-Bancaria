<x-app-layout>
    <x-slot name="header">
        <h2>Detall del compte</h2>
    </x-slot>

    <div class="card bg-dark text-white border-success shadow mb-4">
        <div class="card-header bg-success text-center">
            <h3>{{ $compte->alias ?? 'Compte bancari' }}</h3>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4 fw-bold text-success">IBAN</div>
                <div class="col-md-8">{{ $compte->iban }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4 fw-bold text-success">Tipus</div>
                <div class="col-md-8">{{ $compte->tipusCompte->nom }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4 fw-bold text-success">Saldo</div>
                <div class="col-md-8">{{ number_format($compte->saldo, 2, ',', '.') }} EUR</div>
            </div>
            <div class="text-center">
                <a href="{{ route('bizums.create') }}" class="btn btn-success">Fer Bizum</a>
                <a href="{{ route('dashboard') }}" class="btn btn-primary">Atras</a>
            </div>
        </div>
    </div>

    <div class="card bg-dark text-white border-success shadow">
        <div class="card-header bg-success text-center">
            <h3>Moviments</h3>
        </div>
        <div class="card-body">
            @include('client.partials.moviments', ['moviments' => $moviments, 'client' => $compte->client])
        </div>
    </div>
</x-app-layout>
