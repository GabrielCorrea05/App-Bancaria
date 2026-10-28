<div class="d-flex gap-2">
    <a class="btn btn-primary btn-sm" href="{{ route('admin.show', [$section, $id]) }}">Ver</a>
    <a class="btn btn-success btn-sm" href="{{ route('admin.edit', [$section, $id]) }}">Editar</a>
    <form method="POST" action="{{ route('admin.destroy', [$section, $id]) }}" onsubmit="return confirm('Segur que vols esborrar aquest element?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger btn-sm" type="submit">Eliminar</button>
    </form>
</div>
