<!doctype html>
<html lang="ca">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">AppBancaria Gabriel</a>
            <a class="btn btn-primary btn-sm" href="{{ route('login') }}">Login</a>
        </div>
    </nav>

    <div class="container py-5 d-flex justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card bg-dark text-white border-success shadow">
                <div class="card-header bg-success text-center">
                    <h3>Registrar client</h3>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label text-success">Nom</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                            @error('name') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-success">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                            @error('email') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-success">DNI</label>
                            <input type="text" name="dni" class="form-control" value="{{ old('dni') }}" maxlength="9" required>
                            @error('dni') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-success">Data naixement</label>
                            <input type="date" name="data_naixement" class="form-control" value="{{ old('data_naixement') }}" required>
                            @error('data_naixement') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-success">Telefon</label>
                            <input type="text" name="telefon" class="form-control" value="{{ old('telefon') }}" required>
                            @error('telefon') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-success">Contrasenya</label>
                            <input type="password" name="password" class="form-control" required>
                            @error('password') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-success">Confirmar contrasenya</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-lg">Registrar</button>
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Atras</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </body>
</html>
