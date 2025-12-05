<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLAY MATCH</title>

    <link rel="icon" type="image/png" href="{{ asset('Images/Logo.png') }}">
    <link rel="stylesheet" href="{{ asset('CSS/Global/global.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/Visitante/styles.css') }}">
  </head>

  <body>
      <header>
        <div class="top-bar">
          <div class="left-size">
            <img src="{{ asset('Images/Logo.png') }}" alt="Logo" class="logo">
            <h1 class="titulo">Play Match</h1>

            <nav class="menu"> 
              <a href="{{ url('buscar-torneo') }}">Buscar Torneos</a>
              <a href="{{ url('partidos') }}">Partidos</a>
              <a href="{{ url('equipos') }}">Equipos</a>
            </nav>
          </div>

          <div class="buttons-container">      
            <section class="sigin">
                <button type="button" onclick="location.href='{{ url('registrarse') }}'">
                    Registrarse
                </button>
            </section>

            <section class="login">
                <button type="button" onclick="location.href='{{ route('login') }}'">
                    Inicio de sesión
                </button>
            </section>
          </div>
        </div>
      </header>

      <main>
        <section class="cuerpo">
          <h2 class="subtitulo">TORNEOS DESTACADOS - FÚTBOL 11</h2>

          <div class="torneos">

            @foreach ($torneos as $torneo)

                <article class="tarjeta-torneo">

                    {{-- IMAGEN DEL TORNEO --}}
                    <div class="imagen">
                        <img src="{{ $torneo->imagen ?: asset('Images/Logo.png') }}" alt="Imagen torneo">
                    </div>

                    {{-- TEXTO DEL TORNEO --}}
                    <div class="texto">
                        <h3>{{ $torneo->nombre_torneo }}</h3>
                        <p>Código: {{ $torneo->id_torneo }}</p>
                    </div>

                    <a href="#" class="boton">Ver información</a>
                </article>

            @endforeach

          </div>
        </section>
      </main>

      <script src="{{ asset('JavaScript/app.js') }}"></script>
  </body>
</html>


