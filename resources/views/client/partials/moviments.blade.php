<div class="table-responsive">
    <table class="table table-dark table-striped align-middle">
        <thead>
            <tr>
                <th>Data</th>
                <th>Operacio</th>
                <th>Compte</th>
                <th>Import</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($moviments as $moviment)
                @php
                    $enviat = $client->comptes->pluck('id')->contains($moviment->idCompteOrigen);
                    $altre = $enviat ? $moviment->compteDesti->client->user->name : $moviment->CompteOrigen->client->user->name;
                @endphp
                <tr>
                    <td>{{ $moviment->dataBizum->format('d/m/Y H:i') }}</td>
                    <td>{{ $enviat ? 'Enviat a '.$altre : 'Rebut de '.$altre }}</td>
                    <td>{{ $enviat ? $moviment->CompteOrigen->iban : $moviment->compteDesti->iban }}</td>
                    <td class="{{ $enviat ? 'text-danger' : 'text-success' }}">
                        {{ $enviat ? '-' : '+' }}{{ number_format($moviment->quantitat, 2, ',', '.') }} EUR
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Encara no hi ha moviments.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
