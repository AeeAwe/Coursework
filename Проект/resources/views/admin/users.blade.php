@extends('layouts.admin')

@section('title', 'Ю-Классик — управление пользователями')

@section('admin-content')
    <h1 class="title title-large">Пользователи</h1>
    <div class="admin-form">
        <h3>Создать нового пользователя</h3>
        <form action="{{ route('admin.register') }}" method="post" class="admin-form-inner">
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

    <div class="admin-list">
        <h3>Список пользователей</h3>
        <div class="filters">
            <form method="get" action="{{ route('admin.users') }}" class="filter-form">
                <input type="text" name="search" placeholder="Поиск (ФИО, логин, email)" value="{{ request('search') }}" class="filter-input">
                <select name="role" class="filter-input">
                    <option value="">Все роли</option>
                    <option value="client" @if(request('role') === 'client') selected @endif>Клиент</option>
                    <option value="trainer" @if(request('role') === 'trainer') selected @endif>Тренер</option>
                    <option value="admin" @if(request('role') === 'admin') selected @endif>Администратор</option>
                </select>
                <select name="sort_by" class="filter-input">
                    <option value="id_desc" {{ request('sort_by', 'id_desc') === 'id_desc' ? 'selected' : '' }}>Сначала новые</option>
                    <option value="id_asc" {{ request('sort_by') === 'id_asc' ? 'selected' : '' }}>Сначала старые</option>
                    <option value="fio_asc" {{ request('sort_by') === 'fio_asc' ? 'selected' : '' }}>ФИО ↑</option>
                    <option value="login_asc" {{ request('sort_by') === 'login_asc' ? 'selected' : '' }}>Логин ↑</option>
                </select>
                <div class="filter-actions">
                    <button type="submit" class="btn btn-accent">Фильтр</button>
                    <a href="{{ route('admin.users') }}" class="btn btn-danger">Сброс</a>
                </div>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ФИО</th>
                    <th>Email</th>
                    <th>Телефон</th>
                    <th>Роль</th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody>
                @if($users->count())
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->fio }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            @php
                                $role = match($user->role) {
                                    'client'  => 'Клиент',
                                    'admin'   => 'Админ',
                                    'trainer' => 'Тренер',
                                    default   => '—',
                                };
                            @endphp
                            <td>{{ $role }}</td>
                            <td>
                                <button type="button" class="btn btn-outline btn-icon-gap js-open-edit"
                                    data-id="{{ $user->id }}"
                                    data-fio="{{ $user->fio }}"
                                    data-phone="{{ $user->phone }}"
                                    data-email="{{ $user->email }}"
                                    data-login="{{ $user->login }}"
                                    data-role="{{ $user->role }}">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="btn-icon-gap"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1.003 1.003 0 0 0 0-1.42L18.37 3.29a1.003 1.003 0 0 0-1.42 0l-1.83 1.83 3.75 3.75 1.84-1.83z" fill="currentColor"/></svg>
                                    Редактировать
                                </button>
                                <form action="{{ route('user.delete', $user->id) }}" method="post" class="form-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-icon-gap" title="Удалить">
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
        <x-pagination :i="$users"/>
    </div>

    <div id="editModal" class="modal hidden">
        <div class="modal-backdrop" onclick="closeModal('editModal')"></div>
        <div class="modal-panel" role="dialog" aria-modal="true" aria-labelledby="editModalTitle">
            <button class="close-btn modal-close" type="button" onclick="closeModal('editModal')">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
            <h3 id="editModalTitle">Редактировать пользователя</h3>
            <form id="editForm" method="post">
                @csrf
                @method('PUT')
                <label for="m_fio">ФИО</label>
                <input type="text" name="edit_fio" id="m_fio" required>
                @error('edit_fio') <span class="error-msg">{{ $message }}</span> @enderror
                <label for="m_phone">Телефон</label>
                <input type="text" name="edit_phone" id="m_phone" required>
                @error('edit_phone') <span class="error-msg">{{ $message }}</span> @enderror
                <label for="m_email">E-mail</label>
                <input type="email" name="edit_email" id="m_email" required>
                @error('edit_email') <span class="error-msg">{{ $message }}</span> @enderror
                <label for="m_login">Логин</label>
                <input type="text" name="edit_login" id="m_login" required>
                @error('edit_login') <span class="error-msg">{{ $message }}</span> @enderror
                <label for="m_role">Роль</label>
                <select name="edit_role" id="m_role" required>
                    <option value="client">Клиент</option>
                    <option value="trainer">Тренер</option>
                    <option value="admin">Администратор</option>
                </select>
                @error('edit_role') <span class="error-msg">{{ $message }}</span> @enderror
                <hr class="modal-hr">
                <p class="modal-hint">Оставьте пароль пустым, если не нужно менять</p>
                <label for="m_edit_password">Новый пароль</label>
                <input type="password" name="edit_password" id="m_edit_password">
                @error('edit_password') <span class="error-msg">{{ $message }}</span> @enderror
                <label for="m_edit_password_confirmation">Подтверждение пароля</label>
                <input type="password" name="edit_password_confirmation" id="m_edit_password_confirmation">
                @error('edit_password_confirmation') <span class="error-msg">{{ $message }}</span> @enderror

                <div class="form-actions">
                    <button type="button" class="btn btn-outline" onclick="closeModal('editModal')">Отмена</button>
                    <button type="submit" class="btn btn-accent">Сохранить</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const updateUrlTemplate = "{{ route('user.update', ['user' => ':id']) }}";
            setupUserEditModal(updateUrlTemplate);

            @if(session('show_edit_modal') && $errors->any())
                openEditModal({
                    id: '{{ session("edit_user_id") }}',
                    fio: '{{ old("edit_fio") }}',
                    phone: '{{ old("edit_phone") }}',
                    email: '{{ old("edit_email") }}',
                    login: '{{ old("edit_login") }}',
                    role: '{{ old("edit_role", "client") }}'
                }, updateUrlTemplate);
            @endif
        });
    </script>

@endsection
