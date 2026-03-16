@extends('layouts.admin')

@section('title', 'Ю-Классик — управление пользователями')

@section('admin-content')
    <h1 class="title title-large">Пользователи</h1>
    <div class="admin-form">
        <h3>Создать нового пользователя</h3>
        <form action="{{ route('admin.register') }}" method="post" style="display:flex; flex-direction:column; gap:15px; max-width:500px;">
            @csrf
            <div>
                <input type="text" name="fio" placeholder="ФИО" value="{{ old('fio') }}">
                @error('fio') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            <div>
                <input type="tel" name="phone" placeholder="+7(000)-000-00-00" value="{{ old('phone') }}">
                @error('phone') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            <div>
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}">
                @error('email') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            <div>
                <input type="text" name="login" placeholder="Логин" value="{{ old('login') }}">
                @error('login') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            <div>
                <input type="password" name="password" placeholder="Пароль">
                @error('password') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            <div>
                <select name="role">
                    <option value="client" {{ old('role') === 'client' ? 'selected' : '' }}>Клиент</option>
                    <option value="trainer" {{ old('role') === 'trainer' ? 'selected' : '' }}>Тренер</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Администратор</option>
                </select>
                @error('role') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            <button type="submit" class="btn btn-accent">Зарегистрировать</button>
        </form>
    </div>

    <div class="users-list">
        <h3>Список пользователей</h3>
        <div class="filters" style="margin-bottom:20px; display:flex; gap:10px; align-items:center;">
            <form method="get" style="display:flex; gap:10px; align-items:center;">
                <select name="role" class="filter-input">
                    <option value="">Все роли</option>
                    <option value="client" @if(request('role') === 'client') selected @endif>Клиент</option>
                    <option value="trainer" @if(request('role') === 'trainer') selected @endif>Тренер</option>
                    <option value="admin" @if(request('role') === 'admin') selected @endif>Администратор</option>
                </select>
                <button type="submit" class="btn btn-outline" style="height:44px;">Фильтр</button>
                <a href="{{ route('admin.users') }}" class="btn btn-outline" style="height:44px; display:flex; align-items:center; text-decoration:none;">Сброс</a>
            </form>
        </div>
        <table style="width:100%; border-collapse:collapse; margin-top:20px;">
            <thead style="background:#252738;">
                <tr>
                    <th style="padding:12px; text-align:left; border:1px solid #444;">ID</th>
                    <th style="padding:12px; text-align:left; border:1px solid #444;">ФИО</th>
                    <th style="padding:12px; text-align:left; border:1px solid #444;">Email</th>
                    <th style="padding:12px; text-align:left; border:1px solid #444;">Телефон</th>
                    <th style="padding:12px; text-align:left; border:1px solid #444;">Роль</th>
                    <th style="padding:12px; text-align:left; border:1px solid #444;">Действие</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr style="background:#1E1E1E; border:1px solid #444;">
                        <td style="padding:12px; border:1px solid #444;">{{ $user->id }}</td>
                        <td style="padding:12px; border:1px solid #444;">{{ $user->fio }}</td>
                        <td style="padding:12px; border:1px solid #444;">{{ $user->email }}</td>
                        <td style="padding:12px; border:1px solid #444;">{{ $user->phone }}</td>
                        @php
                            $role = match($user->role) {
                                'client'  => 'Клиент',
                                'admin'   => 'Админ',
                                'trainer' => 'Тренер',
                                default   => '—',
                            };
                        @endphp
                        <td style="padding:12px; border:1px solid #444;">{{ $role }}</td>
                        <td style="padding:12px; text-align:center; border:1px solid #444;">
                            <button type="button" class="btn btn-outline js-open-edit"
                                data-id="{{ $user->id }}"
                                data-fio="{{ $user->fio }}"
                                data-phone="{{ $user->phone }}"
                                data-email="{{ $user->email }}"
                                data-login="{{ $user->login }}"
                                data-role="{{ $user->role }}"
                                style="margin-right:8px;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="margin-right:8px;"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1.003 1.003 0 0 0 0-1.42L18.37 3.29a1.003 1.003 0 0 0-1.42 0l-1.83 1.83 3.75 3.75 1.84-1.83z" fill="currentColor"/></svg>
                                Редактировать
                            </button>
                            <form action="{{ route('user.delete', $user->id) }}" method="post" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-danger" title="Удалить" style="margin-left:6px; display:inline-flex; align-items:center; gap:8px;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 6h18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M8 6v14a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 11v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M14 11v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                    Удалить
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <x-pagination :i="$users"/>
    </div>

    <!-- Modal markup -->
    <div id="editModal" class="modal hidden">
        <div class="modal-backdrop" onclick="closeModal()"></div>
        <div class="modal-panel" role="dialog" aria-modal="true" aria-labelledby="editModalTitle">
            <button class="close-btn" type="button" onclick="closeModal()" style="position:absolute; right:12px; top:12px;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
            <h3 id="editModalTitle">Редактировать пользователя</h3>
            <form id="editForm" method="post">
                @csrf
                @method('PUT')
                <label>ФИО</label>
                <input type="text" name="edit_fio" id="m_fio" required>
                @error('edit_fio') <span class="error-msg">{{ $message }}</span> @enderror
                <label>Телефон</label>
                <input type="text" name="edit_phone" id="m_phone" required>
                @error('edit_phone') <span class="error-msg">{{ $message }}</span> @enderror
                <label>E-mail</label>
                <input type="email" name="edit_email" id="m_email" required>
                @error('edit_email') <span class="error-msg">{{ $message }}</span> @enderror
                <label>Логин</label>
                <input type="text" name="edit_login" id="m_login" required>
                @error('edit_login') <span class="error-msg">{{ $message }}</span> @enderror
                <label>Роль</label>
                <select name="edit_role" id="m_role" required>
                    <option value="client">Клиент</option>
                    <option value="trainer">Тренер</option>
                    <option value="admin">Администратор</option>
                </select>
                @error('edit_role') <span class="error-msg">{{ $message }}</span> @enderror
                <hr style="margin:12px 0; opacity:.6;">
                <p style="opacity:.8; font-size:14px;">Оставьте пароль пустым, если не нужно менять</p>
                <label>Новый пароль</label>
                <input type="password" name="edit_password">
                @error('edit_password') <span class="error-msg">{{ $message }}</span> @enderror
                <label>Подтверждение пароля</label>
                <input type="password" name="edit_password_confirmation">
                @error('edit_password_confirmation') <span class="error-msg">{{ $message }}</span> @enderror

                <div style="margin-top:12px; display:flex; gap:10px; justify-content:flex-end;">
                    <button type="button" class="btn btn-outline" onclick="closeModal()">Отмена</button>
                    <button type="submit" class="btn btn-accent">Сохранить</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const updateUrlTemplate = "{{ route('user.update', ['user' => ':id']) }}";

        function openEditModal(data){
                console.log(data)
                document.getElementById('m_fio').value = data.fio || '';
                document.getElementById('m_phone').value = data.phone || '';
                document.getElementById('m_email').value = data.email || '';
                document.getElementById('m_login').value = data.login || '';
                document.getElementById('m_role').value = data.role || 'client';
                const form = document.getElementById('editForm');
                form.action = updateUrlTemplate.replace(':id', data.id);
                const modal = document.getElementById('editModal');
                modal.classList.remove('hidden');
                modal.classList.add('visible');
        }
        function closeModal(){
            const modal = document.getElementById('editModal');
            modal.classList.remove('visible');
            modal.classList.add('hidden');
        }
        document.addEventListener('click', function(e){
            if(e.target && e.target.classList.contains('js-open-edit')){
                const b = e.target.closest('.js-open-edit');
                console.log(b)
                openEditModal({
                    id: b.dataset.id,
                    fio: b.dataset.fio,
                    phone: b.dataset.phone,
                    email: b.dataset.email,
                    login: b.dataset.login,
                    role: b.dataset.role,
                });
            }
        });

        @if(session('show_edit_modal') && $errors->any())
            document.addEventListener('DOMContentLoaded', function() {
                openEditModal({
                    id: '{{ session("edit_user_id") }}',
                    fio: '{{ old("edit_fio") }}',
                    phone: '{{ old("edit_phone") }}',
                    email: '{{ old("edit_email") }}',
                    login: '{{ old("edit_login") }}',
                    role: '{{ old("edit_role", "client") }}'
                });
            });
        @endif
    </script>

@endsection
