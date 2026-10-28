<x-app-layout>
    <x-slot name="header">
        <h2>Editar {{ str_replace('-', ' ', $section) }}</h2>
    </x-slot>

    <div class="container d-flex justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card bg-dark text-white border-success shadow">
                <div class="card-header bg-success text-center">
                    <h3>Formulari</h3>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.update', [$section, $item->id]) }}">
                        @csrf
                        @method('PUT')

                        @if ($section === 'clients')
                            <div class="mb-3"><label class="form-label text-success">DNI</label><input class="form-control" name="dni" value="{{ old('dni', $item->dni) }}" required></div>
                            <div class="mb-3"><label class="form-label text-success">Data naixement</label><input class="form-control" type="date" name="data_naixement" value="{{ old('data_naixement', $item->data_naixement->format('Y-m-d')) }}" required></div>
                            <div class="mb-3"><label class="form-label text-success">Telefon</label><input class="form-control" name="telefon" value="{{ old('telefon', $item->telefon) }}" required></div>
                        @elseif ($section === 'tipus-comptes')
                            <div class="mb-3"><label class="form-label text-success">Nom</label><input class="form-control" name="nom" value="{{ old('nom', $item->nom) }}" required></div>
                            <div class="mb-3"><label class="form-label text-success">Descripcio</label><input class="form-control" name="descripcio" value="{{ old('descripcio', $item->descripcio) }}"></div>
                        @elseif ($section === 'comptes')
                            <div class="mb-3">
                                <label class="form-label text-success">Client</label>
                                <select name="client_id" class="form-control">
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}" @selected(old('client_id', $item->client_id) == $client->id)>{{ $client->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-success">Tipus</label>
                                <select name="tipus_compte_id" class="form-control">
                                    @foreach ($tipusComptes as $tipus)
                                        <option value="{{ $tipus->id }}" @selected(old('tipus_compte_id', $item->tipus_compte_id) == $tipus->id)>{{ $tipus->nom }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3"><label class="form-label text-success">IBAN</label><input class="form-control" name="iban" value="{{ old('iban', $item->iban) }}" required></div>
                            <div class="mb-3"><label class="form-label text-success">Alias</label><input class="form-control" name="alias" value="{{ old('alias', $item->alias) }}"></div>
                            <div class="mb-3"><label class="form-label text-success">Saldo</label><input class="form-control" type="number" step="0.01" name="saldo" value="{{ old('saldo', $item->saldo) }}" required></div>
                        @else
                            <div class="mb-3">
                                <label class="form-label text-success">Compte origen</label>
                                <select name="idCompteOrigen" class="form-control">
                                    @foreach ($comptes as $compte)
                                        <option value="{{ $compte->id }}" @selected(old('idCompteOrigen', $item->idCompteOrigen) == $compte->id)>{{ $compte->client->user->name }} - {{ $compte->iban }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-success">Compte desti</label>
                                <select name="idCompteDesti" class="form-control">
                                    @foreach ($comptes as $compte)
                                        <option value="{{ $compte->id }}" @selected(old('idCompteDesti', $item->idCompteDesti) == $compte->id)>{{ $compte->client->user->name }} - {{ $compte->iban }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3"><label class="form-label text-success">Data Bizum</label><input class="form-control" type="datetime-local" name="dataBizum" value="{{ old('dataBizum', $item->dataBizum->format('Y-m-d\TH:i')) }}" required></div>
                            <div class="mb-3"><label class="form-label text-success">Quantitat</label><input class="form-control" type="number" step="0.01" name="quantitat" value="{{ old('quantitat', $item->quantitat) }}" required></div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">Revisa els camps del formulari.</div>
                        @endif

                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-lg">Guardar</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">Atras</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
