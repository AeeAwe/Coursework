<header class="app-header header">
    <div class="container">
        <nav class="header-nav nav">
            <a href="{{ url('/') }}" class="logo"><img src="{{ asset('icon/logo-filled.svg') }}" alt="логотип"></a>
            <ul class="nav-list">
                <li class="nav-item"><a href="{{ url('/') }}" class="nav-link">Главная</a></li>
                <li class="nav-item"><a href="{{ route('contacts') }}" class="nav-link">Связь с нами</a></li>
                <li class="nav-item"><a href="{{ route('trainers') }}" class="nav-link">Тренеры</a></li>
                <li class="nav-item"><a href="{{ route('abonements') }}" class="nav-link">Абонементы</a></li>
                <li class="nav-item"><a href="{{ route('schedule') }}" class="nav-link">Расписание</a></li>
            </ul>
            <div class="nav-action">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.abonements.bookings') }}" class="btn btn-outline mr-10">Админ-панель</a>
                    @elseif(auth()->user()->role === 'trainer')
                        <a href="{{ route('trainer.schedule') }}" class="btn btn-outline mr-10">Тренер-панель</a>
                    @endif
                        <a href="{{ route('cabinet.abonements') }}" class="btn btn-accent">Личный кабинет</a>
                @else
                    <a href="{{ route('s_login') }}" class="btn btn-accent">Войти</a>
                @endauth
            </div>
        </nav>
    </div>
</header>
