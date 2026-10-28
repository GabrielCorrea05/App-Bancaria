<x-app-layout>
    <x-slot name="header">
        <h2>Ver {{ str_replace('-', ' ', $section) }}</h2>
    </x-slot>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="container d-flex justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card bg-dark text-white border-success shadow">
                <div class="card-header bg-success text-center">
                    <h3>Detall</h3>
                </div>
                <div class="card-body">
                    @if ($section === 'clients')
                        <div class="row mb-3"><div class="col-md-4 fw-bold text-success">Nom</div><div class="col-md-8">{{ $item->user->name }}</div></div>
                        <div class="row mb-3"><div class="col-md-4 fw-bold text-success">Email</div><div class="col-md-8">{{ $item->user->email }}</div></div>
                        <div class="row mb-3"><div class="col-md-4 fw-bold text-success">DNI</div><div class="col-md-8">{{ $item->dni }}</div></div>
                        <div class="row mb-3"><div class="col-md-4 fw-bold text-success">Data naixement</div><div class="col-md-8">{{ $item->data_naixement->format('d/m/Y') }}</div></div>
                        <div class="row mb-3"><div class="col-md-4 fw-bold text-success">Telefon</div><div class="col-md-8">{{ $item->telefon }}</div></div>
                    @elseif ($section === 'tipus-comptes')
                        <div class="row mb-3"><div class="col-md-4 fw-bold text-success">Nom</div><div class="col-md-8">{{ $item->nom }}</div></div>
                        <div class="row mb-3"><div class="col-md-4 fw-bold text-success">Descripcio</div><div class="col-md-8">{{ $item->descripcio }}</div></div>
                    @elseif ($section === 'comptes')
                        <div class="row mb-3"><div class="col-md-4 fw-bold text-success">IBAN</div><div class="col-md-8">{{ $item->iban }}</div></div>
                        <div class="row mb-3"><div class="col-md-4 fw-bold text-success">Client</div><div class="col-md-8">{{ $item->client->user->name }}</div></div>
                        <div class="row mb-3"><div class="col-md-4 fw-bold text-success">Alias</div><div class="col-md-8">{{ $item->alias }}</div></div>
                        <div class="row mb-3"><div class="col-md-4 fw-bold text-success">Tipus</div><div class="col-md-8">{{ $item->tipusCompte->nom }}</div></div>
                        <div class="row mb-3"><div class="col-md-4 fw-bold text-success">Saldo</div><div class="col-md-8">{{ number_format($item->saldo, 2, ',', '.') }} EUR</div></div>
                    @else
                        <div class="row mb-3"><div class="col-md-4 fw-bold text-success">Data</div><div class="col-md-8">{{ $item->dataBizum->format('d/m/Y H:i') }}</div></div>
                        <div class="row mb-3"><div class="col-md-4 fw-bold text-success">Origen</div><div class="col-md-8">{{ $item->CompteOrigen->client->user->name }}</div></div>
                        <div class="row mb-3"><div class="col-md-4 fw-bold text-success">Desti</div><div class="col-md-8">{{ $item->compteDesti->client->user->name }}</div></div>
                        <div class="row mb-3"><div class="col-md-4 fw-bold text-success">Quantitat</div><div class="col-md-8">{{ number_format($item->quantitat, 2, ',', '.') }} EUR</div></div>
                    @endif

                    <div class="text-center">
                        <a href="{{ route('admin.edit', [$section, $item->id]) }}" class="btn btn-success btn-lg">Editar</a>
                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">Atras</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
