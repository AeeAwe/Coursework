@extends('layouts.app')

@section('title', 'Ю-Классик — расписание')

@section('main')
<section class="main-section schedule-section padding-y-100">
	<div>
		<h1 class="title title-large">Расписание занятий</h1>
		<form method="get" action="{{ route('schedule') }}" class="schedule-filters">
		<div class="filter-item">
			<label for="search" class="text-small">Поиск</label>
			<input type="text" name="search" id="search" placeholder="Название занятия..." value="{{ request('search') }}" class="filter-input">
			</div>
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
			<div class="filter-item">
				<label for="sort_by" class="text-small">Сортировка</label>
				<select name="sort_by" id="sort_by" class="filter-input">
					<option value="date" {{ request('sort_by', 'date') === 'date' ? 'selected' : '' }}>По дате</option>
					<option value="availability" {{ request('sort_by') === 'availability' ? 'selected' : '' }}>По свободным местам</option>
					<option value="name" {{ request('sort_by') === 'name' ? 'selected' : '' }}>По названию</option>
				</select>
			</div>
			<div class="filter-actions">
				<button type="submit" class="btn btn-accent">Применить</button>
                <a href="{{ route('schedule') }}" class="btn btn-danger">Сброс</a>
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
                                                <button class="btn btn-accent btn-disabled" disabled>Необходим активный абонемент</button>
                                            @elseif($item->activities()->where('user_id', auth()->id())->exists())
                                                <button class="btn btn-accent btn-disabled" disabled>Вы уже записаны</button>
                                            @elseif($item->activities()->whereIn('status', ['recorded', 'attended'])->count() >= $item->capacity)
												<button class="btn btn-accent btn-disabled" disabled>Занятие полностью заполнено</button>
                                            @else
												<form action="{{ route('schedules.book', $item->id) }}" method="post" class="form-inline">
													@csrf
													<button type="submit" class="btn btn-accent">Записаться</button>
												</form>
											@endif
										@else
											<p class="text-muted">Неподходящая роль пользователя</p>
										@endif
									@else
										<p class="text-muted">Войдите, чтобы записаться</p>
									@endif
								</div>
							</div>
						</div>
					@endforeach
				</div>
			@else
				<div class="empty-state">
					<h3>Нет совпадений</h3>
					<p>Занятия не найдены по выбранным критериям</p>
				</div>
			@endif
		</div>
        <x-pagination :i="$schedule"/>
	</div>
</section>
@endsection
