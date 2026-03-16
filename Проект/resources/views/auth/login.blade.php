@extends('layouts.app', ['title' => 'вход'])

@section('main')
    <div class="container">
        <section class="main-section login-section padding-y-login">
            <div class="login-container">
                <div class="login-box">
                    <img src="{{ asset('icon/logo-unfilled.svg') }}" alt="логотип">
                    <form method="post">
                        @csrf
                        <div class="input-wrap">
                            <input type="text" @error('login') class="invalid" @enderror name="login" id="login" value="{{ old('login') }}" autofocus>
                            <label for="login">Логин</label>
                            @error('login')
                                <span class="invalid-text">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="input-wrap">
                            <div class="login-wrap">
                                <input type="password" @error('password') class="invalid" @enderror name="password" id="password" value="{{ old('login') }}">
                                <label for="password">Пароль</label>
                                <div class="eye-btn">
                                    <svg width="22" height="16" viewBox="0 0 22 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" class="open">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M21 8.0002C19.2531 11.5764 14.8775 15 10.9998 15C7.12201 15 2.74646 11.5764 1 7.99978"
                                            stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M21 8.0002C19.2531 4.42398 14.8782 1 11.0005 1C7.1227 1 2.74646 4.42314 1 7.99978"
                                            stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path
                                            d="M14 8C14 9.65685 12.6569 11 11 11C9.34315 11 8 9.65685 8 8C8 6.34315 9.34315 5 11 5C12.6569 5 14 6.34315 14 8Z"
                                            stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                    <svg width="22" height="18" viewBox="0 0 22 18" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" class="close" style="display: none;">
                                        <path
                                            d="M3 1L8.87868 6.87868M19 17L13.1213 11.1213M8.87868 6.87868C8.33579 7.42157 8 8.17157 8 9C8 10.6569 9.34315 12 11 12C11.8284 12 12.5784 11.6642 13.1213 11.1213M8.87868 6.87868L13.1213 11.1213M5.76821 3.76821C3.72843 5.09899 1.96378 7.02601 1 8.99978C2.74646 12.5764 7.12201 16 10.9998 16C12.7376 16 14.5753 15.3124 16.2317 14.2317M8.76138 2.34717C9.51144 2.12316 10.2649 2 11.0005 2C14.8782 2 19.2531 5.42398 21 9.0002C20.448 10.1302 19.6336 11.2449 18.6554 12.2412"
                                            stroke="white" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>
                            @error('password')
                                <span class="invalid-text">
                                    <strong class="text-danger">{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-accent">Войти<svg width="23" height="15"
                                viewBox="0 0 23 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M1 6.36395C0.447715 6.36395 0 6.81167 0 7.36395C0 7.91624 0.447715 8.36395 1 8.36395V7.36395V6.36395ZM22.7071 8.07106C23.0976 7.68054 23.0976 7.04737 22.7071 6.65685L16.3431 0.292885C15.9526 -0.0976396 15.3195 -0.0976396 14.9289 0.292885C14.5384 0.683409 14.5384 1.31657 14.9289 1.7071L20.5858 7.36395L14.9289 13.0208C14.5384 13.4113 14.5384 14.0445 14.9289 14.435C15.3195 14.8255 15.9526 14.8255 16.3431 14.435L22.7071 8.07106ZM1 7.36395V8.36395H22V7.36395V6.36395H1V7.36395Z"
                                    fill="#15161E" />
                            </svg>
                        </button>
                    </form>
                    <span class="under-text"><span>Нет аккаунта? Получите логин/пароль лично в фитнес-центре, либо обратитесь к</span> <a href="mailto:admin@uclassic.ru" class="link">администратору</a></span>
                    <div class="for-test">
                        <div class="test-item">
                            <h2 class="title title-test">Админ</h2>
                            <span>admin221</span>
                        </div>
                        <div class="test-item">
                            <h2 class="title title-test">Тренер</h2>
                            <span>trainer221</span>
                        </div>
                        <div class="test-item">
                            <h2 class="title title-test">Клиент</h2>
                            <span>client221</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    </div>
@endsection
