<!-- resources/views/inicio.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Porti</title>
</head>
<link rel="stylesheet" href="{{ asset('/css/style.css') }}">


<body>
  <header>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <nav>
       <div class="logo"><h1>PORTI</h1></div>
       <div class="botoes">
        <button onclick="window.location.href='{{ route('login') }}'" class="ent">Entrar</button>
        <button onclick="window.location.href='{{ route('register') }}'" class="cad">Cadastrar</button>
        
        </div>
        </nav>
    </header>

    <span class="mot">DESTAQUE SEUS TRABALHOS, TODOS EM UM ÚNICO LUGAR!</span>

    <div class="imgs">
        <div><img src="/img/venus.png" alt="Nascimento de venus"></div>
        <div class="mona"><img src="/img/monalisa.png" alt="Nascimento de venus"></div>
        <div><img src="/img/noiteestrelada.png" alt="Nascimento de venus"></div>
    </div>


    
</body>
</html>