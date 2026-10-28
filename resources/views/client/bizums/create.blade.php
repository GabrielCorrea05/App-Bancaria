<x-app-layout>
    <x-slot name="header">
        <h2>Enviar Bizum</h2>
    </x-slot>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="row">
        <div class="col-lg-5 mb-4">
            <div class="card bg-dark text-white border-success shadow">
                <div class="card-header bg-success text-center">
                    <h3>Nou Bizum</h3>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('bizums.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label text-success">Compte origen</label>
                            <select name="compte_origen_id" class="form-control" required>
                                @foreach ($client->comptes as $compte)
                                    <option value="{{ $compte->id }}" @selected(old('compte_origen_id') == $compte->id)>
                                        {{ $compte->alias ?? $compte->iban }} - {{ number_format($compte->saldo, 2, ',', '.') }} EUR
                                    </option>
                                @endforeach
                            </select>
                            @error('compte_origen_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-success">Client desti</label>
                            <select name="client_desti_id" class="form-control" required>
                                @foreach ($clients as $clientDesti)
                                    <option value="{{ $clientDesti->id }}" @selected(old('client_desti_id') == $clientDesti->id)>
                                        {{ $clientDesti->user->name }} - {{ $clientDesti->dni }}
                                    </option>
                                @endforeach
                            </select>
                            @error('client_desti_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-success">Quantitat</label>
                            <input type="number" step="0.01" min="0.01" name="quantitat" class="form-control" value="{{ old('quantitat') }}" required>
                            @error('quantitat')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-lg">Enviar</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">Atras</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card bg-dark text-white border-success shadow">
                <div class="card-header bg-success text-center">
                    <h3>Darrers Bizums</h3>
                </div>
                <div class="card-body">
                    @include('client.partials.moviments', ['moviments' => $bizums, 'client' => $client])
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
