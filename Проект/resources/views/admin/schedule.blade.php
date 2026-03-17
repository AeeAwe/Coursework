@extends('layouts.admin')

@section('title', 'Ю-Классик — управление расписанием')

@section('admin-content')
    <h1 class="title title-large">Управление расписанием</h1>
    <div class="admin-form">
        <h3>Добавить новое занятие</h3>
        <form action="{{ route('admin.create-schedule') }}" method="post">
            @csrf
            <div>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Название занятия">
                @error('name') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            <div>
                <input type="datetime-local" value="{{ old('date') }}" name="date">
                @error('date') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            <div>
                <select name="trainer_id">
                    <option value="">Выберите тренера</option>
                    @foreach($trainers as $trainer)
                        <option value="{{ $trainer->id }}" {{ old('trainer_id') === $trainer->id ? 'selected' : '' }}>{{ $trainer->fio }}</option>
                    @endforeach
                </select>
                @error('trainer_id') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            <div>
                <input type="number" name="capacity" value="{{ old('capacity') }}" placeholder="Вместимость" min="1">
                @error('capacity') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="btn btn-accent">Добавить занятие</button>
        </form>
    </div>

    <div class="admin-list">
        <h3>Список занятий</h3>
        <form method="get" action="{{ route('admin.schedule') }}" class="filter-form">
            <input type="text" name="search" placeholder="Поиск по названию..." value="{{ request('search') }}" class="filter-input">
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="filter-input">
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="filter-input">
            <select name="trainer_id" class="filter-input">
                <option value="">Все тренеры</option>
                @foreach($trainers as $t)
                    <option value="{{ $t->id }}" {{ request('trainer_id') == $t->id ? 'selected' : '' }}>{{ $t->fio }}</option>
                @endforeach
            </select>
            <select name="status" class="filter-input">
                <option value="">Все статусы</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Активно</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Завершено</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Отменено</option>
            </select>
            <select name="sort_by" class="filter-input">
                <option value="id_desc" {{ request('sort_by', 'id_desc') === 'id_desc' ? 'selected' : '' }}>Сначала новые</option>
                <option value="id_asc" {{ request('sort_by') === 'id_asc' ? 'selected' : '' }}>Сначала старые</option>
                <option value="date_asc" {{ request('sort_by') === 'date_asc' ? 'selected' : '' }}>Дата ↑</option>
                <option value="date_desc" {{ request('sort_by') === 'date_desc' ? 'selected' : '' }}>Дата ↓</option>
                <option value="name_asc" {{ request('sort_by') === 'name_asc' ? 'selected' : '' }}>Название ↑</option>
            </select>
            <div class="filter-actions">
                <button type="submit" class="btn btn-accent">Фильтр</button>
                <a href="{{ route('admin.schedule') }}" class="btn btn-danger">Сброс</a>
            </div>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Занятие</th>
                    <th>Дата</th>
                    <th>Тренер</th>
                    <th>Вместимость</th>
                    <th>Статус</th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody>
                @if($schedule->count())
                    @foreach($schedule as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->date)->format('d.m.Y H:i') }}</td>
                            <td>{{ $item->trainer->fio ?? '-' }}</td>
                            <td>{{ $item->activities->count() . ' / ' . $item->capacity }}</td>
                            @php
                                $status_text = match($item->status) {
                                    'active'    => 'Активно',
                                    'completed' => 'Завершено',
                                    'cancelled' => 'Отменено',
                                    default     => $item->status,
                                };
                            @endphp
                            <td><span class="status-pill">{{ $status_text }}</span></td>
                            <td>
                                <button type="button" class="btn btn-outline btn-icon-gap js-edit-schedule"
                                    data-id="{{ $item->id }}"
                                    data-name="{{ $item->name }}"
                                    data-date="{{ $item->date }}"
                                    data-trainer_id="{{ $item->trainer_id }}"
                                    data-capacity="{{ $item->capacity }}">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="btn-icon-gap"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1.003 1.003 0 0 0 0-1.42L18.37 3.29a1.003 1.003 0 0 0-1.42 0l-1.83 1.83 3.75 3.75 1.84-1.83z" fill="currentColor"/></svg>
                                    Редактировать
                                </button>

                                <button type="button" class="btn btn-outline btn-icon-gap js-change-status"
                                    data-id="{{ $item->id }}"
                                    data-status="{{ $item->status }}">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="btn-icon-gap"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1.003 1.003 0 0 0 0-1.42L18.37 3.29a1.003 1.003 0 0 0-1.42 0l-1.83 1.83 3.75 3.75 1.84-1.83z" fill="currentColor"/></svg>
                                    Статус
                                </button>

                                <form action="{{ route('admin.delete-schedule', $item->id) }}" method="post" class="form-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-icon-gap">
                                        <svg width="21" height="24" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2 5V16C2 17.1046 2.89543 18 4 18H12C13.1046 18 14 17.1046 14 16V5M2 5H1M2 5H4M14 5H15M14 5H12M6 9V14M10 9V14M4 5V3C4 1.89543 4.89543 1 6 1H10C11.1046 1 12 1.89543 12 3V5M4 5H12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        Удалить
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="td-empty">Нет совпадений по выбранным критериям</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div id="editScheduleModal" class="modal hidden">
        <div class="modal-backdrop" onclick="closeModal('editScheduleModal')"></div>
        <div class="modal-panel" role="dialog" aria-modal="true" aria-labelledby="editScheduleTitle">
            <button class="close-btn modal-close" type="button" onclick="closeModal('editScheduleModal')">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
            <h3 id="editScheduleTitle">Редактировать занятие</h3>
            <form id="editScheduleForm" method="post">
                @csrf
                @method('PUT')
                <label for="s_name">Название занятия</label>
                <input type="text" name="edit_name" id="s_name" required>
                @error('edit_name') <span class="error-msg">{{ $message }}</span> @enderror
                <label for="s_date">Дата и время</label>
                <input type="datetime-local" name="edit_date" id="s_date" required>
                @error('edit_date') <span class="error-msg">{{ $message }}</span> @enderror
                <label for="s_trainer_id">Тренер</label>
                <select name="edit_trainer_id" id="s_trainer_id">
                    <option value="">Не выбран</option>
                    @foreach($trainers as $t)
                        <option value="{{ $t->id }}">{{ $t->fio }}</option>
                    @endforeach
                </select>
                @error('edit_trainer_id') <span class="error-msg">{{ $message }}</span> @enderror
                <label for="s_capacity">Вместимость</label>
                <input type="number" name="edit_capacity" id="s_capacity" min="1" value="15">
                @error('edit_capacity') <span class="error-msg">{{ $message }}</span> @enderror
                <div class="form-actions">
                    <button type="button" class="btn btn-outline" onclick="closeModal('editScheduleModal')">Отмена</button>
                    <button type="submit" class="btn btn-accent">Сохранить</button>
                </div>
            </form>
        </div>
    </div>

    <div id="statusScheduleModal" class="modal hidden">
        <div class="modal-backdrop" onclick="closeModal('statusScheduleModal')"></div>
        <div class="modal-panel" role="dialog" aria-modal="true" aria-labelledby="statusScheduleTitle">
            <button class="close-btn modal-close" type="button" onclick="closeModal('statusScheduleModal')">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
            <h3 id="statusScheduleTitle">Изменить статус занятия</h3>
            <form id="statusScheduleForm" method="post">
                @csrf
                @method('PATCH')
                <label for="status_select">Выберите новый статус</label>
                <select name="status" id="status_select" required>
                    <option value="active">Активно</option>
                    <option value="completed">Завершено</option>
                    <option value="cancelled">Отменено</option>
                </select>
                <div class="form-actions">
                    <button type="button" class="btn btn-outline" onclick="closeModal('statusScheduleModal')">Отмена</button>
                    <button type="submit" class="btn btn-accent">Сохранить</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editUrlTemplate = "{{ route('admin.update-schedule', ['schedule' => ':id']) }}";
            const statusUrlTemplate = "{{ route('admin.update-schedule-status', ['schedule' => ':id']) }}";
            setupScheduleEditModal(editUrlTemplate, statusUrlTemplate);

            @if(session('show_schedule_modal') && $errors->any())
                openEditScheduleModal({
                    id: '{{ session("schedule_id") }}',
                    name: '{{ old("edit_name") }}',
                    date: '{{ old("edit_date") }}',
                    trainer_id: '{{ old("edit_trainer_id") }}',
                    capacity: '{{ old("edit_capacity", 15) }}'
                }, editUrlTemplate);
            @endif
        });
    </script>
@endsection
