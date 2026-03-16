@extends('layouts.cabinet')

@section('cabinet-content')

<div id="content-abonements">
    <h2 class="title title-small">Активный абонемент</h2>
    @if($user->abonements->count())
        <ul class="abonements-list">
            @forelse($user->abonements->whereIn('status', ['active','pending']) as $abon)
                <li class="abonement-item">
                    <div class="abon-name title-small">{{ $abon->abonement->name ?? 'Абонемент' }}</div>
                    <div class="abon-details text-large">Осталось посещений: {{ $abon->visits_left ?? '—' }} из {{ $abon->abonement->visits }}</div>
                    <div class="abon-details text-large">Цена: {{ $abon->abonement->price ?? '—' }} ₽</div>
                    <div class="abon-details text-large">Описание: {{ $abon->abonement->description ?? '—' }}</div>
                    <div class="abon-status title-small" style="color: #FCC40A; margin-top: 8px;">
                        @if($abon->status === 'pending')
                            ⏳ В ожидании подтверждения
                        @elseif($abon->status === 'active')
                            ✓ Активно
                        @endif
                    </div>
                </li>
            @empty
                @if($user->role === 'client')
                    <div class="empty">У вас нет активных абонентов. <a href="{{ route('abonements') }}" class="link">Приобрести</a></div>
                @else
                    <div class="empty">Неподходящая роль пользователя</div>
                @endif
            @endforelse
        </ul>
        <h3 class="title title-small" style="margin-top:24px;">Архив абонементов</h3>
        <ul class="abonements-list">
            @forelse($user->abonements->whereIn('status', ['ended','rejected']) as $abon)
                <li class="abonement-item">
                    <div class="abon-name title-small">{{ $abon->abonement->name ?? 'Абонемент' }}</div>
                    <div class="abon-details text-large">Цена: {{ $abon->abonement->price ?? '—' }} ₽</div>
                    <div class="abon-details text-large">Описание: {{ $abon->abonement->description ?? '—' }}</div>
                    <div class="abon-status title-small" style="color: #FCC40A; margin-top: 8px;">
                        @if($abon->status === 'ended')
                            ✗ Закончено
                        @elseif($abon->status === 'rejected')
                            ✗ Отклонено
                        @endif
                    </div>
                </li>
            @empty
                <div class="empty">Нет архивных абонементов</div>
            @endforelse
        </ul>
    @else
        @if($user->role === 'client')
            <div class="empty">У вас нет абонементов. <a href="{{ route('abonements') ?? '#' }}" class="link">Купить абонемент</a></div>
        @else
            <div class="empty">Неподходящая роль пользователя</div>
        @endif
    @endif
</div>

@endsection
