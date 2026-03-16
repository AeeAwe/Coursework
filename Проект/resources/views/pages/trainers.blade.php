@extends('layouts.app')

@section('title', 'Ю-Классик — тренеры')

@section('main')
    <section class="main-section trainer-section padding-y-100">
        <div>
            <h1 class="title title-large">Наши замечательные тренеры</h1>
            <div class="cards-grid trainer-container">
                <div>
                    <div class="grid-item glow" style="background-image: url('{{ asset("img/Тренер2.jpg") }}');"></div>
                    <div class="text">
                        <h2 class="title title-normal">Андреа Чукотский</h2>
                        <p class="text-large">Гимнаст и выдающаяся личность, не часто встретишь такого добряка</p>
                    </div>
                </div>
                <div>
                    <div class="grid-item glow" style="background-image: url('{{ asset("img/Тренер1.jpg") }}');"></div>
                    <div class="text">
                        <h2 class="title title-normal">Роман Васильчук</h2>
                        <p class="text-large">Роль его не проста, подготовить выдающихся атлетов, ну либо заставить вас похудеть и бросить котлеты</p>
                    </div>
                </div>
                <div>
                    <div class="grid-item glow" style="background-image: url('{{ asset("img/Тренер3.jpg") }}');"></div>
                    <div class="text">
                        <h2 class="title title-normal">Дмитрий Колесников</h2>
                        <p class="text-large">Бодибилдер, делится советами, помогает с тренировками, в общем, хороший такой парень</p>
                    </div>
                </div>
                <div>
                    <div class="grid-item glow" style="background-image: url('{{ asset("img/Тренер4.jpg") }}');"></div>
                    <div class="text">
                        <h2 class="title title-normal">Алина Ремешкова</h2>
                        <p class="text-large">Растянет вам все мышцы, будете левитировать в позе лотоса и научитесь расслабляться (любит розы)</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
