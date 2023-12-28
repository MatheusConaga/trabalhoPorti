<div class="obras-de-arte">
    <link rel="stylesheet" href="/css/style.css">

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

    <!-- Site -->
<h1 class="artsSub">ARTES SUBMETIDAS</h1>

@if(isset($artworks) && count($artworks) > 0)
    <div class="obras-de-arte-container">
        @foreach ($artworks as $artwork)
            <div class="obra-de-arte">
                <img src="{{ asset('storage/' . $artwork->image_path) }}" alt="{{ $artwork->title }}">
                <h3>{{ $artwork->title }}</h3>
                <p>{{ $artwork->description }}</p>
            </div>
        @endforeach
    </div>
@else
    <p class="artsSub">Sem obras de arte disponíveis.</p>
@endif

</div>