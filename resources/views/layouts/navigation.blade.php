<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">AppBancaria Gabriel</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuPrincipal">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        {{ Auth::user()->email === 'admin@admin.cat' ? 'Administracio' : 'Inici' }}
                    </a>
                </li>

                @if (Auth::user()->email !== 'admin@admin.cat')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('client.comptes.create') }}">Crear compte</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('bizums.create') }}">Bizum</a>
                    </li>
                @endif
            </ul>

            <div class="d-flex align-items-center gap-3">
                <span class="text-white">{{ Auth::user()->name }}</span>
                <a class="btn btn-outline-light btn-sm" href="{{ route('profile.edit') }}">Perfil</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-danger btn-sm" type="submit">Sortir</button>
                </form>
            </div>
        </div>
    </div>
</nav>
