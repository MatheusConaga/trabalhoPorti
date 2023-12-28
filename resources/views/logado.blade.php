<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Porti</title>
</head>
<link rel="stylesheet" href="/css/style.css">

<body>
    <header>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <nav>
            <div class="logo">
                <a href="{{ route('dashboard') }}"><h1>PORTI</h1></a>
            </div>
            <div class="botoes-e-formulario">
                <div class="botoes">
                    <button onclick="window.location.href='{{ route('artwork.store') }}'" class="art">Artes</button>
                </div>
                <div class="botoes">
                    <button onclick="window.location.href='{{ route('profile.edit') }}'" class="env">Editar conta</button>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link>
                        <button type="submit" class="edt" onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Sair') }}
                        </button>
                    </x-responsive-nav-link>
                </form>
            </div>
        </nav>
    </header>

    <div class="info">
        <div class="inf-art">
            <h1>{{ Auth::user()->name }}</h1>
            <span><p>{{ Auth::user()->description }}</p></span>
        </div>
        <div class="inf-foto">
            <img src="{{ Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : asset('img/default-profile-image.png') }}" alt="Foto do artista">
        </div>
    </div>
    
    <div class="artes">
    <!-- Seção para adicionar nova arte -->
    <h2>Adicionar Nova Arte</h2>
    <form method="post" action="{{ route('artwork.store') }}" enctype="multipart/form-data" class="envImg">
        @csrf

        <div class="mb-3">
            <label for="image">Imagem:</label>
            <input type="file" id="image" name="image" accept="image/*" required>
        </div>

        <div class="mb-3">
            <label for="title">Título:</label>
            <input type="text" id="title" name="title" required>
        </div>

        <div class="mb-3">
            <label for="description">Descrição:</label>
            <textarea id="description" name="description" rows="3" required></textarea>
        </div>

        <button type="submit" class="art">Enviar</button>
    </form>
</div>
        
        
       

</body>
</html>
