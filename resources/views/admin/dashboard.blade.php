<x-app-layout>
    <x-slot name="header">
        <h2>Administracio - AppBancaria</h2>
        <p class="mb-0">Projecte de Gabriel</p>
    </x-slot>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="card bg-dark text-white border-success shadow mb-4">
        <div class="card-header bg-success text-center">
            <h3>Clients</h3>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-dark table-striped align-middle">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>DNI</th>
                        <th>Telefon</th>
                        <th>Accions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clients as $client)
                        <tr>
                            <td>{{ $client->user->name }}</td>
                            <td>{{ $client->user->email }}</td>
                            <td>{{ $client->dni }}</td>
                            <td>{{ $client->telefon }}</td>
                            <td>@include('admin.partials.actions', ['section' => 'clients', 'id' => $client->id])</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card bg-dark text-white border-success shadow mb-4">
        <div class="card-header bg-success text-center">
            <h3>Tipus de comptes</h3>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-dark table-striped align-middle">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Descripcio</th>
                        <th>Comptes</th>
                        <th>Accions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tipusComptes as $tipus)
                        <tr>
                            <td>{{ $tipus->nom }}</td>
                            <td>{{ $tipus->descripcio }}</td>
                            <td>{{ $tipus->comptes_count }}</td>
                            <td>@include('admin.partials.actions', ['section' => 'tipus-comptes', 'id' => $tipus->id])</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
                        <th>IBAN</th>
                        <th>Client</th>
                        <th>Alias</th>
                        <th>Tipus</th>
                        <th>Saldo</th>
                        <th>Accions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($comptes as $compte)
                        <tr>
                            <td>{{ $compte->iban }}</td>
                            <td>{{ $compte->client->user->name }}</td>
                            <td>{{ $compte->alias }}</td>
                            <td>{{ $compte->tipusCompte->nom }}</td>
                            <td>{{ number_format($compte->saldo, 2, ',', '.') }} EUR</td>
                            <td>@include('admin.partials.actions', ['section' => 'comptes', 'id' => $compte->id])</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card bg-dark text-white border-success shadow">
        <div class="card-header bg-success text-center">
            <h3>Bizums entre clients</h3>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-dark table-striped align-middle">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Origen</th>
                        <th>Desti</th>
                        <th>Quantitat</th>
                        <th>Accions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($bizums as $bizum)
                        <tr>
                            <td>{{ $bizum->dataBizum->format('d/m/Y H:i') }}</td>
                            <td>{{ $bizum->CompteOrigen->client->user->name }}</td>
                            <td>{{ $bizum->compteDesti->client->user->name }}</td>
                            <td>{{ number_format($bizum->quantitat, 2, ',', '.') }} EUR</td>
                            <td>@include('admin.partials.actions', ['section' => 'bizums', 'id' => $bizum->id])</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Encara no hi ha Bizums registrats.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
