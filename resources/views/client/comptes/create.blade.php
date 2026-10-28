<x-app-layout>
    <x-slot name="header">
        <h2>Crear compte bancari</h2>
    </x-slot>

    <div class="container d-flex justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card bg-dark text-white border-success shadow">
                <div class="card-header bg-success text-center">
                    <h3>Nou compte</h3>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('client.comptes.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label text-success">Nom del compte</label>
                            <input type="text" name="alias" class="form-control" value="{{ old('alias') }}" placeholder="Nomina, Estalvis, Viatges..." required>
                            @error('alias')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-success">Tipus de compte</label>
                            <select name="tipus_compte_id" class="form-control" required>
                                @foreach ($tipusComptes as $tipus)
                                    <option value="{{ $tipus->id }}" @selected(old('tipus_compte_id') == $tipus->id)>
                                        {{ ucfirst($tipus->nom) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipus_compte_id')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <p class="text-secondary">El compte es crea amb saldo inicial de 0 EUR.</p>

                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-lg">Crear</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">Atras</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
