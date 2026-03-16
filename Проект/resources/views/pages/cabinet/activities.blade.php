@extends('layouts.cabinet')

@section('cabinet-content')

<div id="content-records">
    <h2 class="title title-small">Активные занятия</h2>
    @if($user->activities->count())
        <ul class="records-list">
            @forelse($user->activities->where('status', 'recorded') as $activity)
                <li class="record-item">
                    <div class="record-info">
                        <div class="record-service title-small">{{ $activity->schedule->name ?? 'Услуга' }}</div>
                        <div class="record-date text-large">{{ \Carbon\Carbon::parse($activity->schedule->date)->format('d.m.Y H:i') ?? '—' }}</div>
                    </div>
                    <div class="record-meta">
                        <span class="record-instructor">{{ $activity->schedule->trainer->fio ?? '—' }}</span>
                        <span class="record-status">{{ $activity->status == 'recorded' ? 'Записано' : ($activity->status == 'attended' ? 'Посещено' : '—') }}</span>
                        @if(isset($activity->schedule->date) && \Carbon\Carbon::parse($activity->schedule->date)->isFuture())
                            <form action="{{ route('cabinet.activities.cancel', $activity->id ?? $activity['id']) }}" method="POST" class="form-inline">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-outline btn-xs">Отменить</button>
                            </form>
                        @endif
                    </div>
                </li>
            @empty
                @if($user->role === 'client')
                    <div class="empty">У вас нет активных занятий. <a href="{{ route('schedule') }}" class="link">Записаться</a></div>
                @else
                    <div class="empty">Неподходящая роль пользователя</div>
                @endif
            @endforelse
        </ul>
        <h3 class="title title-small mt-20">Архивные занятия</h3>
        <ul class="records-list">
            @forelse($user->activities->where('status', 'attended') as $activity)
                <li class="record-item">
                    <div class="record-info">
                        <div class="record-service title-small">{{ $activity->schedule->name ?? 'Занятие' }}</div>
                        <div class="record-date text-large">{{ \Carbon\Carbon::parse($activity->schedule->date)->format('d.m.Y H:i') ?? '-' }}</div>
                    </div>
                    <div class="record-meta">
                        <span class="record-instructor">{{ $activity->schedule->trainer->fio ?? '—' }}</span>
                        <span class="record-status">{{ $activity->status == 'recorded' ? 'Записано' : ($activity->status == 'attended' ? 'Посещено' : '—') }}</span>
                    </div>
                </li>
            @empty
                @if($user->role === 'client')
                    <div class="empty">У вас нет архивных занятий.</div>
                @else
                    <div class="empty">Неподходящая роль пользователя</div>
                @endif
            @endforelse
        </ul>
    @else
        @if($user->role === 'client')
            <div class="empty">У вас нет активных занятий. <a href="{{ route('schedule') }}" class="link">Записаться</a></div>
        @else
            <div class="empty">Неподходящая роль пользователя</div>
        @endif
    @endif
</div>

@endsection
