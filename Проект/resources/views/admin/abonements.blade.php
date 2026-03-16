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
                @foreach($abonements as $abonement)
                    <tr>
                        <td>{{ $abonement->name }}</td>
                        <td>{{ $abonement->price }} ₽</td>
                        <td>{{ $abonement->visits }}</td>
                        <td style="max-width:250px; font-size:12px; opacity:0.8;">{{ $abonement->description ?? '—' }}</td>
                        <td>
                            <button type="button" class="btn btn-outline js-edit-abonement"
                                data-id="{{ $abonement->id }}"
                                data-name="{{ $abonement->name }}"
                                data-visits="{{ $abonement->visits }}"
                                data-price="{{ $abonement->price }}"
                                data-description="{{ $abonement->description }}"
                                style="margin-right:8px;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right:8px;"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1.003 1.003 0 0 0 0-1.42L18.37 3.29a1.003 1.003 0 0 0-1.42 0l-1.83 1.83 3.75 3.75 1.84-1.83z" fill="currentColor"/></svg>
                                Редактировать
                            </button>
                            <form action="{{ route('admin.delete-abonement', $abonement->id) }}" method="post" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger" style="display:inline-flex; align-items:center; gap:8px;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 6h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M8 6v14a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 11v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M14 11v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                    Удалить
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Edit Abonement Modal -->
    <div id="editAbonementModal" class="modal hidden">
        <div class="modal-backdrop" onclick="closeAbonementModal()"></div>
        <div class="modal-panel" role="dialog" aria-modal="true" aria-labelledby="editAbonementTitle">
            <button class="close-btn" type="button" onclick="closeAbonementModal()" style="position:absolute; right:12px; top:12px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
            <h3 id="editAbonementTitle">Редактировать абонемент</h3>
            <form id="editAbonementForm" method="post">
                @csrf
                @method('PUT')
                <label>Название</label>
                <input type="text" name="edit_name" id="a_name" value="{{ old('edit_name') }}">
                @error('edit_name') <span class="error-msg">{{ $message }}</span> @enderror
                <label>Количество посещений</label>
                <input type="number" name="edit_visits" id="a_visits" min="1" value="{{ old('edit_visits') }}">
                @error('edit_visits') <span class="error-msg">{{ $message }}</span> @enderror
                <label>Цена</label>
                <input type="number" name="edit_price" id="a_price" step="0.01" min="0" value="{{ old('edit_price') }}">
                @error('edit_price') <span class="error-msg">{{ $message }}</span> @enderror
                <label>Описание</label>
                <textarea name="edit_description" id="a_description">{{ old('edit_description') }}</textarea>
                @error('edit_description') <span class="error-msg">{{ $message }}</span> @enderror
                <div style="margin-top:12px; display:flex; gap:10px; justify-content:flex-end;">
                    <button type="button" class="btn btn-outline" onclick="closeAbonementModal()">Отмена</button>
                    <button type="submit" class="btn btn-accent">Сохранить</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const abonementUpdateUrlTemplate = "{{ route('admin.update-abonement', ['abonement' => ':id']) }}";

        function openEditAbonementModal(data){
            document.getElementById('a_name').value = data.name || '';
            document.getElementById('a_visits').value = data.visits || '';
            document.getElementById('a_price').value = data.price || '';
            document.getElementById('a_description').value = data.description || '';
            const form = document.getElementById('editAbonementForm');
            form.action = abonementUpdateUrlTemplate.replace(':id', data.id);
            const modal = document.getElementById('editAbonementModal');
            modal.classList.remove('hidden');
            modal.classList.add('visible');
        }
        function closeAbonementModal(){
            const modal = document.getElementById('editAbonementModal');
            modal.classList.remove('visible');
            modal.classList.add('hidden');
        }
        document.addEventListener('click', function(e){
            if(e.target && e.target.classList.contains('js-edit-abonement')){
                const b = e.target.closest('.js-edit-abonement');
                openEditAbonementModal({
                    id: b.dataset.id,
                    name: b.dataset.name,
                    visits: b.dataset.visits,
                    price: b.dataset.price,
                    description: b.dataset.description,
                });
            }
        });

        @if(session('show_abonement_modal') && $errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                openEditAbonementModal({
                    id: '{{ session("abonement_id") }}',
                    name: '{{ old("edit_name") }}',
                    visits: '{{ old("edit_visits") }}',
                    price: '{{ old("edit_price") }}',
                    description: '{{ old("edit_description") }}'
                });
            });
        @endif
    </script>
@endsection
