@extends('layouts.app')

@section('title', 'Ю-Классик — абонементы')

@section('main')
<section class="main-section abonements-section padding-y-100">
	<div>
		<h1 class="title title-large">Абонементы</h1>

		<div class="abonements-grid">
			@if(isset($abonements) && count($abonements))
				<div class="cards-grid">
					@foreach($abonements as $abon)
						<div class="grid-item abon-card">
							<div class="abon-card-content">
								<div class="title title-small">{{ $abon->name ?? 'Абонемент' }}</div>
								<div class="text-large">Посещений: {{ $abon->visits ?? '—' }}</div>
								<div class="text-small">Цена: {{ $abon->price ?? '—' }} ₽</div>
								<div class="text-small">Срок действия: не ограничено</div>
								<div class="text-small">{{ $abon->description ?? '' }}</div>
								<div class="abon-card-actions">
									@if(auth()->check())
										@if(auth()->user()->role === 'client')
                                            @if(auth()->user()->abonements()->whereIn('status', ['pending','active'])->exists())
										<p class="text-muted">У вас уже есть абонемент</p>
                                            @else
										<form action="{{ route('abonements.book', $abon->id) }}" method="post" class="form-inline">
												@csrf
												<button type="submit" class="btn btn-accent">Приобрести</button>
											</form>
                                            @endif
										@else
											<p class="text-muted">Неподходящая роль пользователя</p>
										@endif
									@else
										<p class="text-muted">Войдите, чтобы приобрести</p>
									@endif
								</div>
							</div>
						</div>
					@endforeach
				</div>
			@else
				<div class="empty">Абонементы временно отсутствуют. Обратитесь к администратору для информации.</div>
			@endif
		</div>
	</div>
</section>
@endsection
