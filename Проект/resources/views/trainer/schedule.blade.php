@extends('layouts.app')

@section('title', 'Ю-Классик — мое расписание')

@section('main')
<section class="trainer-section padding-y-100">
    <h1 class="title title-large">Мое расписание</h1>

    <div class="schedule-list">
        <table class="trainer-table">
            <thead class="trainer-table-head">
                <tr>
                    <th class="trainer-table-header">Занятие</th>
                    <th class="trainer-table-header">Дата и время</th>
                    <th class="trainer-table-header">Записано</th>
                    <th class="trainer-table-header">Статус</th>
                    <th class="trainer-table-header trainer-table-header-center">Действие</th>
                </tr>
            </thead>
            <tbody>
                @foreach($schedule as $item)
                    <tr class="trainer-table-row">
                        <td class="trainer-table-cell">{{ $item->name }}</td>
                        <td class="trainer-table-cell">{{ \Carbon\Carbon::parse($item->date)->format('d.m.Y H:i') }}</td>
                        <td class="trainer-table-cell">
                            {{ $item->activities->whereIn('status', ['recorded','attended'])->count() }} / {{ $item->capacity }}
                        </td>
                        @php
                        $status = match($item->status) {
                            'active'  => 'Активно',
                            'full'   => 'Заполнено',
                            'completed'   => 'Завершено',
                            default   => '—',
                        };
                        @endphp
                        <td class="trainer-table-cell">{{ $status }}</td>
                        <td class="trainer-table-cell trainer-table-cell-center">
                            <a href="{{ route('trainer.activity', $item->id) }}" class="btn btn-accent btn-sm">Участники</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($schedule->isEmpty())
            <p class="empty-state-margin">У вас пока нет занятий.</p>
        @endif
    </div>
    <x-pagination :i="$schedule"/>
</section>
@endsection
