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

            <article class="primer-torneo">
              <div class="imagen-torneo1">
                <img src="{{ asset('Images/torneo1.jpg') }}" alt="Torneo 1">
              </div>
              <div class="textotorneo1">
                <h3>Copa Fifas</h3>
                <p>Código: 1738433</p>
              </div>
              <a href="#" class="torneo1-boton">Ver información</a>
            </article>

            <article class="segundo-torneo">
              <div class="imagen-torneo2">
                <img src="{{ asset('Images/torneo2.jpg') }}" alt="Torneo 2">
              </div>
              <div class="textotorneo2">
                <h3>Copa Fifas</h3>
                <p>Código: 1738433</p>
              </div>
              <a href="#" class="torneo2-boton">Ver información</a>
            </article>

            <article class="tercer-torneo">
              <div class="imagen-torneo3">
                <img src="{{ asset('Images/torneo3.jpg') }}" alt="Torneo 3">
              </div>
              <div class="textotorneo3">
                <h3>Copa Fifas</h3>
                <p>Código: 1738433</p>
              </div>
              <a href="#" class="torneo3-boton">Ver información</a>
            </article>

          </div>
        </section>
      </main>

      <script src="{{ asset('JavaScript/app.js') }}"></script>
  </body>
</html>
