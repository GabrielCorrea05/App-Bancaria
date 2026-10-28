<x-app-layout>
    <x-slot name="header">
        <h2>Panell del client</h2>
        <p class="mb-0">Benvingut/da, {{ $client->user->name }}</p>
    </x-slot>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="card bg-dark text-white border-success shadow mb-4">
        <div class="card-header bg-success text-center">
            <h3>Dades del client</h3>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-md-4 fw-bold text-success">DNI</div>
                <div class="col-md-8">{{ $client->dni }}</div>
            </div>
            <div class="row mb-2">
                <div class="col-md-4 fw-bold text-success">Data de naixement</div>
                <div class="col-md-8">{{ $client->data_naixement->format('d/m/Y') }}</div>
            </div>
            <div class="row">
                <div class="col-md-4 fw-bold text-success">Telefon</div>
                <div class="col-md-8">{{ $client->telefon }}</div>
            </div>
        </div>
    </div>

    <div class="card bg-dark text-white border-success shadow mb-4">
        <div class="card-header bg-success text-center">
            <h3>Comptes bancaris</h3>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-dark table-striped align-middle">
                <thead>
                    <tr>
                        <th>Alias</th>
                        <th>Tipus</th>
                        <th>IBAN</th>
                        <th>Saldo</th>
                        <th>Accio</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($client->comptes as $compte)
                        <tr>
                            <td>{{ $compte->alias ?? 'Compte bancari' }}</td>
                            <td>{{ $compte->tipusCompte->nom }}</td>
                            <td>{{ $compte->iban }}</td>
                            <td>{{ number_format($compte->saldo, 2, ',', '.') }} EUR</td>
                            <td>
                                <a href="{{ route('client.comptes.show', $compte) }}" class="btn btn-primary btn-sm">Ver</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Encara no tens comptes assignats.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card bg-dark text-white border-success shadow">
        <div class="card-header bg-success text-center">
            <h3>Ultims moviments</h3>
        </div>
        <div class="card-body">
            @include('client.partials.moviments', ['moviments' => $moviments, 'client' => $client])
        </div>
    </div>
</x-app-layout>
