@extends('layouts.admin')

@section('title', 'Ю-Классик — управление абонементами')

@section('admin-content')
    <h1 class="title title-large">Управление абонементами</h1>
    <div class="admin-form">
        <h3>Добавить новый абонемент</h3>
        <form action="{{ route('admin.create-abonement') }}" method="post">
            @csrf
            <div>
                <input type="text" name="name" placeholder="Название" value="{{ old('name') }}">
                @error('name') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            <div>
                <input type="number" name="visits" min="1" placeholder="Количество посещений" value="{{ old('visits') }}">
                @error('visits') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            <div>
                <input type="number" name="price" placeholder="Цена" value="{{ old('price') }}">
                @error('price') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            <div>
                <textarea name="description" placeholder="Описание">{{ old('description') }}</textarea>
                @error('description') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            <div>
                <button type="submit" class="btn btn-accent">Добавить абонемент</button>
            </div>
        </form>
    </div>

    <div class="admin-list">
        <h3>Список абонементов</h3>
        <form method="get" action="{{ route('admin.abonements') }}" class="filter-form">
            <input type="text" name="search" placeholder="Поиск по названию..." value="{{ request('search') }}" class="filter-input">
            <select name="sort_by" class="filter-input">
                <option value="latest" {{ request('sort_by', 'latest') === 'latest' ? 'selected' : '' }}>Сначала новые</option>
                <option value="oldest" {{ request('sort_by') === 'oldest' ? 'selected' : '' }}>Сначала старые</option>
                <option value="name_asc" {{ request('sort_by') === 'name_asc' ? 'selected' : '' }}>Название ↑</option>
                <option value="price_asc" {{ request('sort_by') === 'price_asc' ? 'selected' : '' }}>Цена ↑</option>
                <option value="price_desc" {{ request('sort_by') === 'price_desc' ? 'selected' : '' }}>Цена ↓</option>
            </select>
            <div class="filter-actions">
                <button type="submit" class="btn btn-accent">Поиск</button>
                <a href="{{ route('admin.abonements') }}" class="btn btn-danger">Сброс</a>
            </div>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Цена</th>
                    <th>Посещений</th>
                    <th>Описание</th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody>
                @if($abonements->count())
                    @foreach($abonements as $abonement)
                        <tr>
                            <td>{{ $abonement->name }}</td>
                            <td>{{ $abonement->price }} ₽</td>
                            <td>{{ $abonement->visits }}</td>
                            <td class="td-description">{{ $abonement->description ?? '—' }}</td>
                            <td>
                                <button type="button" class="btn btn-outline btn-icon-gap js-edit-abonement"
                                    data-id="{{ $abonement->id }}"
                                    data-name="{{ $abonement->name }}"
                                    data-visits="{{ $abonement->visits }}"
                                    data-price="{{ $abonement->price }}"
                                    data-description="{{ $abonement->description }}">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="btn-icon-gap"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1.003 1.003 0 0 0 0-1.42L18.37 3.29a1.003 1.003 0 0 0-1.42 0l-1.83 1.83 3.75 3.75 1.84-1.83z" fill="currentColor"/></svg>
                                    Редактировать
                                </button>
                                <form action="{{ route('admin.delete-abonement', $abonement->id) }}" method="post" class="form-inline">
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
                        <td colspan="5" class="td-empty">Нет совпадений по выбранным критериям</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div id="editAbonementModal" class="modal hidden">
        <div class="modal-backdrop" onclick="closeModal('editAbonementModal')"></div>
        <div class="modal-panel" role="dialog" aria-modal="true" aria-labelledby="editAbonementTitle">
            <button class="close-btn modal-close" type="button" onclick="closeModal('editAbonementModal')">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
            <h3 id="editAbonementTitle">Редактировать абонемент</h3>
            <form id="editAbonementForm" method="post">
                @csrf
                @method('PUT')
                <label for="a_name">Название</label>
                <input type="text" name="edit_name" id="a_name" value="{{ old('edit_name') }}">
                @error('edit_name') <span class="error-msg">{{ $message }}</span> @enderror
                <label for="a_visits">Количество посещений</label>
                <input type="number" name="edit_visits" id="a_visits" min="1" value="{{ old('edit_visits') }}">
                @error('edit_visits') <span class="error-msg">{{ $message }}</span> @enderror
                <label for="a_price">Цена</label>
                <input type="number" name="edit_price" id="a_price" step="0.01" min="0" value="{{ old('edit_price') }}">
                @error('edit_price') <span class="error-msg">{{ $message }}</span> @enderror
                <label for="a_description">Описание</label>
                <textarea name="edit_description" id="a_description">{{ old('edit_description') }}</textarea>
                @error('edit_description') <span class="error-msg">{{ $message }}</span> @enderror
                <div class="form-actions">
                    <button type="button" class="btn btn-outline" onclick="closeModal('editAbonementModal')">Отмена</button>
                    <button type="submit" class="btn btn-accent">Сохранить</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const abonementUpdateUrlTemplate = "{{ route('admin.update-abonement', ['abonement' => ':id']) }}";
            setupAbonementEditModal(abonementUpdateUrlTemplate);

            @if(session('show_abonement_modal') && $errors->any())
                openEditAbonementModal({
                    id: '{{ session("abonement_id") }}',
                    name: '{{ old("edit_name") }}',
                    visits: '{{ old("edit_visits") }}',
                    price: '{{ old("edit_price") }}',
                    description: '{{ old("edit_description") }}'
                }, abonementUpdateUrlTemplate);
            @endif
        });
    </script>
@endsection
