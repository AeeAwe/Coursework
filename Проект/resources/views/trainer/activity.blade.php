@extends('layouts.app')

@section('title', 'Ю-Классик — участники занятия')

@section('main')
<section class="trainer-section padding-y-100">
    <h1 class="title title-large">Участники: {{ $schedule->name }}</h1>
    <p class="text-muted mb-20">{{ \Carbon\Carbon::parse($schedule->date)->format('d.m.Y H:i') }}</p>

    <div class="as-list">
        <table class="trainer-table">
            <thead class="trainer-table-head">
                <tr>
                    <th class="trainer-table-header">Имя</th>
                    <th class="trainer-table-header">Э-мейл</th>
                    <th class="trainer-table-header">Телефон</th>
                    <th class="trainer-table-header trainer-table-header-center">Статус</th>
                    <th class="trainer-table-header trainer-table-header-center">Действие</th>
                </tr>
            </thead>
            <tbody>
                @foreach($schedule->activities as $a)
                    <tr class="trainer-table-row">
                        <td class="trainer-table-cell">{{ $a->user->fio }}</td>
                        <td class="trainer-table-cell">{{ $a->user->phone }}</td>
                        <td class="trainer-table-cell">{{ $a->user->email }}</td>
                        <td class="trainer-table-cell trainer-table-cell-center">
                            @if($a->status === 'recorded')
                                <span class="status-recorded">Записан</span>
                            @elseif($a->status === 'attended')
                                <span class="status-attended">Посещал</span>
                            @endif
                        </td>
                        <td class="trainer-table-cell trainer-table-cell-center">
                            @if($a->status === 'recorded')
                                <form action="{{ route('trainer.mark-attendance', $a->id) }}" method="post" class="form-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Отметить</button>
                                </form>
                            @endif
                            <form action="{{ route('trainer.cancel-a', $a->id) }}" method="post" class="form-inline">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-danger-small">Отменить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($schedule->activities->isEmpty())
            <p class="empty-state-margin">Нет зарегистрированных участников.</p>
        @endif
    </div>
</section>
@endsection
