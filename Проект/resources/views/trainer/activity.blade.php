@extends('layouts.app')

@section('title', 'Ю-Классик — участники занятия')

@section('main')
<section class="trainer-section padding-y-100">
    <h1 class="title title-large">Участники: {{ $schedule->name }}</h1>
    <p style="color:#999; margin-bottom:20px;">{{ \Carbon\Carbon::parse($schedule->date)->format('d.m.Y H:i') }}</p>

    <div class="as-list">
        <table style="width:100%; border-collapse:collapse; margin-top:20px;">
            <thead style="background:#252738;">
                <tr>
                    <th style="padding:12px; text-align:left; border:1px solid #444;">Имя</th>
                    <th style="padding:12px; text-align:left; border:1px solid #444;">Email</th>
                    <th style="padding:12px; text-align:left; border:1px solid #444;">Телефон</th>
                    <th style="padding:12px; text-align:center; border:1px solid #444;">Статус</th>
                    <th style="padding:12px; text-align:center; border:1px solid #444;">Действие</th>
                </tr>
            </thead>
            <tbody>
                @foreach($schedule->activities as $a)
                    <tr style="background:#1E1E1E; border:1px solid #444;">
                        <td style="padding:12px; border:1px solid #444;">{{ $a->user->fio }}</td>
                        <td style="padding:12px; border:1px solid #444;">{{ $a->user->phone }}</td>
                        <td style="padding:12px; border:1px solid #444;">{{ $a->user->email }}</td>
                        <td style="padding:12px; text-align:center; border:1px solid #444;">
                            @if($a->status === 'recorded')
                                <span style="color:#FFC107;">Записан</span>
                            @elseif($a->status === 'attended')
                                <span style="color:#4CAF50;">Посещал</span>
                            @endif
                        </td>
                        <td style="padding:12px; text-align:center; border:1px solid #444;">
                            @if($a->status === 'recorded')
                                <form action="{{ route('trainer.mark-attendance', $a->id) }}" method="post" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-accent" style="background:#4CAF50; padding:5px 10px; font-size:12px; margin-right:5px;">Отметить</button>
                                </form>
                            @endif
                            <form action="{{ route('trainer.cancel-a', $a->id) }}" method="post" style="display:inline;">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-accent" style="background:#D00000; padding:5px 10px; font-size:12px;">Отменить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if($schedule->activities->isEmpty())
            <p style="margin-top:20px; color:#999;">Нет зарегистрированных участников.</p>
        @endif
    </div>
</section>
@endsection
