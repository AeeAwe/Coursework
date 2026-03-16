@extends('layouts.app')

@section('title', 'Ю-Классик — личный кабинет')

@section('main')
    <section class="cabinet-section padding-y-100">
        <div class="cabinet-flex">
            <div class="action-list">
                <div class="action-1">
                    <a href="{{ route('cabinet.abonements') }}" id="tab-abonements"  class="tab-item {{ Route::is('cabinet.abonements') ? 'active' : '' }}" data-target="content-abonements">
                        <div class="action-icon"><svg width="18" height="20" viewBox="0 0 18 20" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M17 7H1M4 1V3M14 1V3M13 13.5C13 14.3284 12.3284 15 11.5 15C10.6716 15 10 14.3284 10 13.5C10 12.6716 10.6716 12 11.5 12C12.3284 12 13 12.6716 13 13.5ZM3 19H15C16.1046 19 17 18.1046 17 17V5C17 3.89543 16.1046 3 15 3H3C1.89543 3 1 3.89543 1 5V17C1 18.1046 1.89543 19 3 19Z"
                                    stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <span>Абонементы</span>
                    </a>
                    <a href="{{ route('cabinet.activities') }}" id="tab-records" class="tab-item {{ Route::is('cabinet.activities') ? 'active' : '' }}" data-target="content-records">
                        <div class="action-icon"><svg width="21" height="14" viewBox="0 0 21 14" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M1 5H11M1 1H11M1 9H7M10.9315 9.33143L13.4929 11.8929C13.8834 12.2834 14.5166 12.2834 14.9071 11.8929L19.641 7.15903"
                                    stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <span>Записи</span>
                    </a>
                    <a href="{{ route('cabinet.personal') }}" id="tab-personal"  class="tab-item {{ Route::is('cabinet.personal') ? 'active' : '' }}" data-target="content-personal">
                        <div class="action-icon"><svg width="16" height="21" viewBox="0 0 16 21" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M8 13V15M4 8V5C4 2.79086 5.79086 1 8 1C10.2091 1 12 2.79086 12 5V8M3 20H13C14.1046 20 15 19.1046 15 18V10C15 8.89543 14.1046 8 13 8H3C1.89543 8 1 8.89543 1 10V18C1 19.1046 1.89543 20 3 20Z"
                                    stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <span>Личные данные</span>
                    </a>
                </div>
                <div class="action-2">
                    <div class="posxalko" onclick="startEasterEgg()">
                        <div class="action-icon"><svg width="19" height="22" viewBox="0 0 19 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.7393 2.5V10V3.5C11.7393 2.67157 12.4108 2 13.2393 2C14.0677 2 14.7393 2.67157 14.7393 3.5V10V6.5C14.7393 5.67157 15.4108 5 16.2393 5C17.0677 5 17.7393 5.67157 17.7393 6.5V15C17.7393 18.3137 15.053 21 11.7393 21H10.6119C9.08759 21 7.62038 20.4198 6.5083 19.3772L1.54971 14.7285C0.832909 14.0565 0.814655 12.9246 1.50942 12.2298C2.18864 11.5506 3.28988 11.5506 3.96911 12.2298L5.73926 14V5.5C5.73926 4.67157 6.41084 4 7.23926 4C8.06769 4 8.73926 4.67157 8.73926 5.5V10V2.5C8.73926 1.67157 9.41084 1 10.2393 1C11.0677 1 11.7393 1.67157 11.7393 2.5Z" stroke="#FF8B77" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <span>Посхалко</span>
                    </div>
                    <form action="{{ route('logout') }}" method="post" class="exit" onclick="this.submit()">
                        @csrf
                        <div class="action-icon"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15 17V3C15 1.89543 14.1046 1 13 1H5C3.89543 1 3 1.89543 3 3V17M15 17H3M15 17H17M3 17H1M11 9H11.01" stroke="#D00000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <span>Выйти</span>
                    </form>
                </div>
            </div>
            <div class="cabinet-content">
                @yield('cabinet-content')
            </div>
        </div>
    </section>
    <div id="gojo-easter-egg" class="easter-container gojo-container">
        <img src="{{ asset('img/gojo_dance.gif') }}" alt="Gojo Dance">
    </div>
    <div id="gwvuq-easter-egg" class="easter-container gwvuq-container">
        <img src="{{ asset('img/gwvuq.gif') }}" alt="Gwvuq Move">
    </div>
    <style>
        .easter-container {
            position: fixed;
            bottom: -150px; right: -150px;
            z-index: 9999;
            pointer-events: none;
            display: none;
            width: 300px;
            transition: opacity 0.8s ease;
        }
        .easter-container img { width: 100%; height: auto; }
        .easter-container.active {
            display: block;
            bottom: -50px; right: 30px;
            animation:
                easter-appear 0.8s ease-out forwards,
                easter-infinity 4s ease-in-out infinite,
                aura-cycle 3s infinite alternate;
        }
        .easter-container.leaving {
            animation: easter-exit 1s ease-in forwards !important;
            filter: drop-shadow(0 0 90px #8000ff) !important;
        }
        .gwvuq-container { left: -150px }
        .gwvuq-container.active { left: 30px }
        .gwvuq-container img { transform: scaleX(-1) }
        @keyframes easter-appear {
            0% { transform: scale(0) rotate(30deg); opacity: 0; }
            100% { transform: scale(1) rotate(0deg); opacity: 1; }
        }
        @keyframes aura-cycle {
            0%   { filter: drop-shadow(0 0 30px rgba(0, 212, 255, 0.9)); }
            100% { filter: drop-shadow(0 0 30px rgba(255, 0, 0, 0.9)); }
        }
        @keyframes easter-infinity {
            0%, 100% { transform: translate(0, 0); }
            25%  { transform: translate(-30px, -15px); }
            50%  { transform: translate(0, -30px); }
            75%  { transform: translate(30px, -15px); }
        }
        @keyframes easter-exit {
            0%   { transform: scale(1); opacity: 1; }
            100% { transform: scale(0) translate(100px, 100px); opacity: 0; }
        }
    </style>
    <script>
        function startEasterEgg() {
            const gojo = document.getElementById('gojo-easter-egg');
            const gwvuq = document.getElementById('gwvuq-easter-egg');
            if (gojo.classList.contains('active') || gwvuq.classList.contains('active')) return;
            gojo.style.display = 'block';
            gwvuq.style.display = 'block';
            gojo.classList.remove('leaving');
            gwvuq.classList.remove('leaving');
            gojo.classList.add('active');
            gwvuq.classList.add('active');
            setTimeout(() => {
                gojo.classList.add('leaving');
                gwvuq.classList.add('leaving');
                setTimeout(() => {
                    gojo.classList.remove('active', 'leaving');
                    gwvuq.classList.remove('active', 'leaving');
                    gojo.style.display = 'none';
                    gwvuq.style.display = 'none';
                }, 1000);
            }, 8000);
        }
    </script>
@endsection
