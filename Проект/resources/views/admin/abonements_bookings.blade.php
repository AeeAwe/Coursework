@extends('layouts.admin')

@section('title', 'Ю-Классик — бронирования')

@section('admin-content')
    <h1 class="title title-large">Брони на абонементы</h1>
    <div class="admin-list">
        @if($bookings->count())
            <h3>Ожидающие заявки</h3>
            <table>
                <thead>
                    <tr>
                        <th>Клиент</th>
                        <th>Абонемент</th>
                        <th>Цена</th>
                        <th>Статус</th>
                        <th>Действие</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                        <tr>
                            <td>{{ $booking->user->fio }}</td>
                            <td>{{ $booking->abonement->name }}</td>
                            <td>{{ $booking->abonement->price }} ₽</td>
                            <td><span style="padding:4px 8px; background:#333; border-radius:4px; font-size:12px;">{{ $booking->status }}</span></td>
                            <td>
                                <form action="{{ route('admin.approve-booking', $booking->id) }}" method="post" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-accent" style="display:inline-flex; align-items:center; gap:8px;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        Одобрить
                                    </button>
                                </form>
                                <form action="{{ route('admin.reject-booking', $booking->id) }}" method="post" style="display:inline; margin-left:8px;">
                                    @csrf
                                    <button type="submit" class="btn-danger" style="display:inline-flex; align-items:center; gap:8px;">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        Отклонить
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="color:#999; margin-top:20px;">Нет ожидающих заявок.</p>
        @endif
    </div>
@endsection
