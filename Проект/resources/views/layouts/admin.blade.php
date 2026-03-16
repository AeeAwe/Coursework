@extends('layouts.app')

@section('title', 'Ю-Классик — админ-панель')

@section('main')

<section class="admin-section padding-y-100">
    <div class="admin-wrapper">
        <aside class="admin-sidebar">
            <h3 class="admin-logo">Админ-панель</h3>
            <nav class="admin-links">
                <a href="{{ route('admin.abonements.bookings') }}" class="admin-link {{ request()->routeIs('admin.abonements.bookings') ? 'active' : '' }}">Бронь абонементов</a>
                <a href="{{ route('admin.users') }}" class="admin-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">Пользователи</a>
                <a href="{{ route('admin.abonements') }}" class="admin-link {{ request()->routeIs('admin.abonements') ? 'active' : '' }}">Абонементы</a>
                <a href="{{ route('admin.schedule') }}" class="admin-link {{ request()->routeIs('admin.schedule') ? 'active' : '' }}">Расписание</a>
            </nav>
        </aside>
        <main class="admin-main">
            @yield('admin-content')
        </main>
    </div>
</section>

@endsection
