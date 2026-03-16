@extends('layouts.app')

@section('title', 'Ю-Классик — расписание')

@section('main')
<section class="main-section schedule-section padding-y-100">
	<div>
		<h1 class="title title-large">Расписание занятий</h1>
		<form method="get" action="{{ route('schedule') }}" class="schedule-filters">
			<div class="filter-item">
				<label for="date_from" class="text-small">Дата от</label>
				<input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="filter-input">
			</div>
			<div class="filter-item">
				<label for="date_to" class="text-small">Дата до</label>
				<input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="filter-input">
			</div>
			<div class="filter-item">
				<label for="trainer" class="text-small">Тренер</label>
				<select name="trainer" id="trainer" class="filter-input">
					<option value="">Все</option>
					@if(isset($trainers))
						@foreach($trainers as $t)
							<option value="{{ $t->id }}" {{ request('trainer') == $t->id ? 'selected' : '' }}>{{ $t->fio }}</option>
						@endforeach
					@endif
				</select>
			</div>
			<div class="filter-actions">
				<button type="submit" class="btn btn-outline">Применить</button>
                <a href="{{ route('schedule') }}" class="btn btn-outline">Сброс</a>
                <a href="{{ route('cabinet.abonements') }}" class="btn btn-accent">Мой кабинет</a>
			</div>
		</form>

		<div class="schedule-list">
			@if($schedule->count())
				<div class="cards-grid">
				@foreach($schedule as $item)
						<div class="grid-item schedule-item">
							<div class="schedule-item-content">
								<div class="title title-small">{{ $item->name ?? 'Занятие' }}</div>
								<div class="text-large">{{
									(isset($item->date) ? \Carbon\Carbon::parse($item->date)->format('d.m.Y H:i') : ($item['date'] ?? '-'))
								}}</div>
								<div class="text-small">Тренер: {{ $item->trainer->fio ?? '—' }}</div>
								<div class="text-small">Записано  : {{ $item->activities()->count() ?? 0 }} / {{ $item->capacity ?? '?' }}</div>
								<div class="schedule-item-actions">
									@if(auth()->check())
										@if(auth()->user()->role === 'client')
                                            @if(!auth()->user()->abonements()->where('status','active')->exists())
                                                <button class="btn btn-accent" disabled style="background:#666; cursor:not-allowed;">Необходим активный абонемент</button>
                                            @elseif($item->activities()->where('user_id', auth()->id())->exists())
                                                <button class="btn btn-accent" disabled style="background:#666; cursor:not-allowed;">Вы уже записаны</button>
                                            @elseif($item->activities()->whereIn('status', ['recorded', 'attended'])->count() >= $item->capacity)
												<button class="btn btn-accent" disabled style="background:#666; cursor:not-allowed;">Занятие полностью заполнено</button>
                                            @else
												<form action="{{ route('schedules.book', $item->id) }}" method="post" style="display:inline;">
													@csrf
													<button type="submit" class="btn btn-accent">Записаться</button>
												</form>
											@endif
										@else
											<p style="color:#999; font-size:14px;">Неподходящая роль пользователя</p>
										@endif
									@else
										<p style="color:#999; font-size:14px;">Войдите, чтобы записаться</p>
									@endif
								</div>
							</div>
						</div>
					@endforeach
				</div>
			@else
				<div class="empty">Занятия отсутствуют</div>
			@endif
		</div>
        <x-pagination :i="$schedule"/>
	</div>
</section>
@endsection
