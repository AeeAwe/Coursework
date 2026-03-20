<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Ю-Классик')</title>
    <link rel="shortcut icon" href="{{ asset('favicon.webp') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="app">
        <x-header/>
        <main class="app-main">
            <div class="container">
                @if(session('success'))
                    <div class="flash flash-success" role="status">
                        <div class="flash-icon" aria-hidden="true">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <div class="flash-body">{{ session('success') }}</div>
                        <button class="close-btn" type="button" onclick="this.parentElement.classList.add('fade-out'); setTimeout(()=>this.parentElement.remove(),380);">&times;</button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="flash flash-error" role="alert">
                        <div class="flash-icon" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 9v4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 17h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <div class="flash-body">{{ session('error') }}</div>
                        <button class="close-btn" type="button" onclick="this.parentElement.classList.add('fade-out'); setTimeout(()=>this.parentElement.remove(),380);">&times;</button>
                    </div>
                @endif
                @yield('main')
            </div>
        </main>
        <x-footer/>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
