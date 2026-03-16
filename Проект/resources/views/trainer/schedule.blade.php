@extends('layouts.app')

@section('title', 'Ю-Классик — мое расписание')

@section('main')
<section class="trainer-section padding-y-100">
    <h1 class="title title-large">Мое расписание</h1>

    <div class="schedule-list">
        <table style="width:100%; border-collapse:collapse; margin-top:20px;">
            <thead style="background:#252738;">
                <tr>
                    <th style="padding:12px; text-align:left; border:1px solid #444;">Занятие</th>
                    <th style="padding:12px; text-align:left; border:1px solid #444;">Дата и время</th>
                    <th style="padding:12px; text-align:left; border:1px solid #444;">Записано</th>
                    <th style="padding:12px; text-align:left; border:1px solid #444;">Статус</th>
                    <th style="padding:12px; text-align:center; border:1px solid #444;">Действие</th>
                </tr>
            </thead>
            <tbody>
                @foreach($schedule as $item)
                    <tr style="background:#1E1E1E; border:1px solid #444;">
                        <td style="padding:12px; border:1px solid #444;">{{ $item->name }}</td>
                        <td style="padding:12px; border:1px solid #444;">{{ \Carbon\Carbon::parse($item->date)->format('d.m.Y H:i') }}</td>
                        <td style="padding:12px; border:1px solid #444;">
                            {{ $item->activities->whereIn('status', ['recorded','attended'])->count() }} / {{ $item->capacity }}
                        </td>
                        @php
                        $status = match($item->status) {
                            'active'  => 'Активно',
                            'full'   => 'Заполнено',
                            'ended'   => 'Закончилось',
                            default   => '—',
                        };
                        @endphp
                        <td style="padding:12px; border:1px solid #444;">{{ $status }}</td>
                        <td style="padding:12px; text-align:center; border:1px solid #444;">
                            <a href="{{ route('trainer.activity', $item->id) }}" class="btn btn-accent" style="padding:5px 10px; font-size:12px; text-decoration:none;">Участники</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($schedule->isEmpty())
            <p style="margin-top:20px; color:#999;">У вас пока нет занятий.</p>
        @endif
    </div>
    <x-pagination :i="$schedule"/>
</section>
@endsection
