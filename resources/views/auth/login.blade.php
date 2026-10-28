<!doctype html>
<html lang="ca">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">AppBancaria Gabriel</a>
        </div>
    </nav>

    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="col-md-8 col-lg-6">
            <div class="card bg-dark text-white border-success shadow">
                <div class="card-header bg-success text-center">
                    <h3>Iniciar sessio</h3>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">Email o contrasenya incorrectes.</div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label text-success">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-success">Contrasenya</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-lg">Entrar</button>
                            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Registrar-me</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </body>
</html>
