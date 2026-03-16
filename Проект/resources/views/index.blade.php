@extends('layouts.app')

@section('title', 'Ю-Классик — главная')

@section('main')
<section class="slider">
    <div class="slider-list">
        @foreach (range(1, 5) as $n)
            <div class="slider-item" style="background-image: url('{{ asset("img/Слайд$n.svg") }}')"></div>
        @endforeach
    </div>
    <div class="slider-pagination">
        <div class="pagination-action prev">
            <svg width="43" height="23" viewBox="0 0 43 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M41.5 12.546C42.3284 12.546 43 11.8744 43 11.046C43 10.2175 42.3284 9.54596 41.5 9.54596V11.046V12.546ZM0.43934 9.9853C-0.146447 10.5711 -0.146447 11.5208 0.43934 12.1066L9.98528 21.6526C10.5711 22.2383 11.5208 22.2383 12.1066 21.6526C12.6924 21.0668 12.6924 20.117 12.1066 19.5312L3.62132 11.046L12.1066 2.56068C12.6924 1.97489 12.6924 1.02514 12.1066 0.439358C11.5208 -0.146429 10.5711 -0.146429 9.98528 0.439358L0.43934 9.9853ZM41.5 11.046V9.54596L1.5 9.54596V11.046V12.546L41.5 12.546V11.046Z"
                    fill="white" />
            </svg>
        </div>
        <div class="pagination-nums">
            <span class="from">01</span>
            <span class="divide">/</span>
            <span class="to">3</span>
        </div>
        <div class="pagination-action next">
            <svg width="43" height="23" viewBox="0 0 43 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M1.5 12.546C0.671573 12.546 0 11.8744 0 11.046C0 10.2175 0.671573 9.54596 1.5 9.54596L1.5 11.046L1.5 12.546ZM42.5607 9.9853C43.1464 10.5711 43.1464 11.5208 42.5607 12.1066L33.0147 21.6526C32.4289 22.2383 31.4792 22.2383 30.8934 21.6526C30.3076 21.0668 30.3076 20.117 30.8934 19.5312L39.3787 11.046L30.8934 2.56068C30.3076 1.97489 30.3076 1.02514 30.8934 0.439358C31.4792 -0.146429 32.4289 -0.146429 33.0147 0.439358L42.5607 9.9853ZM1.5 11.046L1.5 9.54596L41.5 9.54596V11.046V12.546L1.5 12.546L1.5 11.046Z"
                    fill="white" />
            </svg>
        </div>
    </div>
</section>
<section class="main-section home-section padding-y-100">
    <div>
        <h1 class="title title-large">Акции и предложения клуба</h1>
        <div class="cards-grid">
            @foreach (range(1, 3) as $n)
                <div class="grid-item glow" style="background-image: url('{{ asset("img/Предложение$n.svg") }}')"></div>
            @endforeach
        </div>
    </div>
    <div>
        <h1 class="title title-large">Интерьер нашего клуба</h1>
        <div class="cards-grid">
            @foreach (range(1, 2) as $n)
                <div class="grid-item glow" style="background-image: url('{{ asset("img/Интерьер$n.png") }}');"></div>
            @endforeach
        </div>
    </div>
    <div class="uslugi-container">
        <h1 class="title title-large">Воспользуйтесь услугами нашего клуба</h1>
        <div>
            @foreach (range(1,4) as $i)
                <div>
                    <div class="uslugi-img glow" style="background-image: url('{{ asset("img/Услуга.svg") }}');"></div>
                    <div class="uslugi-text">
                        <h2 class="title title-normal">Заголовок</h2>
                        <p class="text-large">Высокий уровень вовлечения представителей целевой аудитории является четким доказательством простого факта: перспективное планирование создаёт предпосылки для позиций, занимаемых участниками в отношении поставленных задач. Имеется спорная точка.</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div>
        <h1 class="title title-large">Почему клиенты выбирают нас</h1>
        <div class="cards-grid">
            @foreach (range(1,3) as $n)
                <div class="grid-item glow" style="background-image: url('{{ asset("img/Почему$n.svg") }}')"></div>
            @endforeach
        </div>
    </div>
    <div class="zapis-container">
        <div class="wrap">
            <h1 class="title title-large">Запишитесь на гостевой визит</h1>
            <div>
                <p class="text-large">Если планируете заниматься у нас, вы можете зарегистрироваться у стойки администратора, для доступа к личному кабинету сайта</p>
                <span class="btn btn-accent">Записаться на гостевой визит <svg width="43" height="23" viewBox="0 0 43 23" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M1.5 12.5459C0.671573 12.5459 0 11.8743 0 11.0459C0 10.2175 0.671573 9.5459 1.5 9.5459L1.5 11.0459L1.5 12.5459ZM42.5607 9.98524C43.1464 10.571 43.1464 11.5208 42.5607 12.1066L33.0147 21.6525C32.4289 22.2383 31.4792 22.2383 30.8934 21.6525C30.3076 21.0667 30.3076 20.117 30.8934 19.5312L39.3787 11.0459L30.8934 2.56062C30.3076 1.97483 30.3076 1.02508 30.8934 0.439297C31.4792 -0.14649 32.4289 -0.14649 33.0147 0.439297L42.5607 9.98524ZM1.5 11.0459L1.5 9.5459L41.5 9.5459V11.0459V12.5459L1.5 12.5459L1.5 11.0459Z" fill="#15161E"/>
</svg>
</span>
                <span class="light-text">*Приглашение действительно на одно посещение клуба</span>
            </div>
        </div>
    </div>
</section>
@endsection
