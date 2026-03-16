@extends('layouts.cabinet')

@section('cabinet-content')

<div id="content-personal">
    <div class="personal-card">
        <div class="personal-row"><strong>Имя:</strong> {{ $user->fio ?? '—' }}</div>
        <div class="personal-row"><strong>E-mail:</strong> {{ $user->email ?? '—' }}</div>
        <div class="personal-row"><strong>Телефон:</strong> {{ $user->phone ?? '—' }}</div>
        @php
            $role = match($user->role) {
                'client'  => 'Клиент',
                'admin'   => 'Админ',
                'trainer' => 'Тренер',
                default   => '—',
            };
        @endphp
        <div class="personal-row"><strong>Роль:</strong> {{ $role }}</div>
        @if (Auth::user()->role === 'admin')
            <a href="{{ route('admin.users') }}" class="btn btn-accent">Изменение данных</a>
        @else
            <p class="text-semi-muted">Изменение личных данных доступно только администратору</p>
        @endif
    </div>
</div>

@endsection
