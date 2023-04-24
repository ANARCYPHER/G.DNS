<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.settings.name', 'Laravel') }}</title>
    @if(Illuminate\Support\Facades\Storage::disk('local')->has('public/images/custom-favicon.png'))
    <link rel="icon" href="{{ url('storage/images/custom-favicon.png') }}" type="image/png">
    @else
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    @endif

    {!! config('app.settings.global.header') !!}
    
    <!-- Scripts -->
    <script src="{{ asset('js/frontend.min.js') }}" defer></script>
    <script src="{{ asset('js/scripts.js') }}" defer></script>

    <!-- jVectorMap Scripts -->
    <script src="{{ asset('vendor/jvectormap/jquery-jvectormap-2.0.5.min.js') }}" defer></script>
    <script src="{{ asset('vendor/jvectormap/jquery-jvectormap-world-mill.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family={{ config('app.settings.font_family') }}:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />

    <!-- jVectorMap Styles -->
    <link href="{{ asset('vendor/jvectormap/jquery-jvectormap-2.0.5.css') }}" rel="stylesheet">

    <!-- ShortcodeJS -->
    <script src="{{ asset('vendor/shortcode/shortcode.js') }}"></script>

    <!-- Styles -->
    <link href="{{ asset('vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('css/frontend.min.css') }}" rel="stylesheet">
    <style>
        .darkmode--activated .navbar-light .navbar-nav a.nav-link {
            color: #fff;
        }
        .navbar-light .navbar-nav a.nav-link {
            color: #000;
            transition: all 0.3s;
        }
        .socials {
            font-size: 1.2rem;
        }
        .socials a:not(:last-child) {
            margin-right: 1rem;
        }
        .ql-editor {
            height: auto;
            overflow: hidden;
            padding-top: 0px;
        }
        body {
            font-family: "{{ config('app.settings.font_family') }}";
        }
        #whois input[type=submit] {
            background: {{ config('app.settings.whois_btn.color') }};
            color: {{ config('app.settings.whois_btn.text_color') }};
        }
    </style>
    <style>
        {!! config('app.settings.global.css') !!}
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light justify-content-between px-0 mt-5">
            @if(Illuminate\Support\Facades\Storage::disk('local')->has('public/images/custom-logo.png'))
            <a class="navbar-brand" href="/"><img src="{{ url('storage/images/custom-logo.png') }}" alt="logo"></a>
            @else
            <a class="navbar-brand" href="/"><img src="{{ asset('images/logo.png') }}" alt="logo"></a>
            @endif
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    @foreach($menus as $menu)
                    @if($menu->hasChild())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink{{ $menu->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ __($menu->name) }}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink{{ $menu->id }}">
                                @foreach($menu->getChild() as $child)
                                <a class="dropdown-item" href="{{ $child->link }}" target="{{ $child->target }}">{{ __($child->name) }}</a>
                                @endforeach
                            </div>
                        </li>
                    @else
                        @if($menu->parent_id === null)
                        <li class="nav-item {{ url()->current() === $menu->link ? 'active' : '' }}">
                            <a class="nav-link" href="{{ $menu->link }}" target="{{ $menu->target }}">{{ __($menu->name) }}</a>
                        </li>
                        @endif
                    @endif
                    @endforeach
                </ul>
            </div>
        </nav>
        <div class="row mt-5">
            <div class="ad-space ad-space-1 d-flex align-items-center">{!! config('app.settings.ads.one') !!}</div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                @if($page->slug == 'whois')
                {!! $page->content->one !!}
                <div id="whois" class="input">
                    <form method="POST" action="{{ route('whois') }}">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-8">
                                <input type="text" class="form-control" id="domain" name="domain" value="{{ $page->domain }}" placeholder="example.com" required>
                            </div>
                            <div class="form-group col-md-4">
                                <input type="submit" class="form-control btn" value="{{ config('app.settings.whois_btn.text') }}">
                            </div>
                        </div>
                    </form>
                    @if($page->whois)
                    <div>{!! $page->whois !!}</div>
                    @endif
                </div>
                {!! $page->content->two !!}
                @else
                {!! $page->content !!}
                @endif
            </div>
        </div>
        <div class="row mt-5">
            <div class="ad-space ad-space-6 d-flex align-items-center">{!! config('app.settings.ads.six') !!}</div>
        </div>
        <div class="row mt-5">
            <div class="col-12 d-flex justify-content-center align-items-center socials">
                @foreach(config('app.settings.socials') as $social)
                <a href="{{ $social['link'] }}" target="_blank" class="text-lg" rel="noopener noreferrer"><i class="{{ $social['icon'] }}"></i></a>
                @endforeach
            </div>
            <div class="ql-editor col-12">
                {!! config('app.settings.text.footer') !!}
            </div>
        </div>
    </div>
    @if(Auth::check())
    <a id="admin-icon" href="{{ route('admin') }}" target="_blank">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
        </svg>
    </a>
    @endif
    <div class="d-none" id="servers">{{ json_encode([]) }}</div>
    <div class="d-none" id="options">{{ json_encode(config('app.settings')) }}</div>
    @if(config('app.settings.show_dark_mode'))
    <!-- DarkMode.JS Scripts -->
    <script src="{{ asset('vendor/darkmode/darkmode-js.min.js') }}"></script>
    <script>
        function addDarkmodeWidget() {
            new Darkmode({ label: '🌓' }).showWidget();
        }
        window.addEventListener('load', addDarkmodeWidget);
    </script>
    @endif
    @if($page->slug == 'whois')
    <script defer>
        let whois = setInterval(() => {
            if(document.querySelector('#whois form')) {
                document.querySelector('#whois form').addEventListener('submit', e => {
                    e.preventDefault();
                    document.querySelector('#whois form input[type="text"]').value = document.querySelector('#whois form input[type="text"]').value.replace('http://', '').replace('https://', '').split(/[/?#]/)[0];
                    document.querySelector('#whois form input[type="submit"]').disabled = true;
                    document.querySelector('#whois form input[type="submit"]').value = '. . .';
                    document.querySelector('#whois form').submit();
                })
                clearInterval(whois)
            }
        }, 1000);
    </script>
    @endif
    <script>
    {!! config('app.settings.global.js') !!}
    </script>
    {!! config('app.settings.global.footer') !!}
</body>
</html>