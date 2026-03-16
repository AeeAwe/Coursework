@extends('layouts.app')

@section('title', 'Ю-Классик — контакты')

@section('main')
    <section class="main-section contact-section padding-y-100">
        <div>
            <h1 class="title title-large">Контакты</h1>
            <div class="contact-grid">
                <div class="grid-item">
                    <h2 class="title title-normal">Адрес</h2>
                    <div class="text">
                        <p><a href="https://yandex.ru/maps/-/CLcSbZ2B" class="link">3-й Некрасовский пр., 3, корпус 1, Пушкино, Московская обл., 141207</a></p>
                        <p>Ежедневно 10:00 - 22:00</p>
                    </div>
                </div>
                <div class="grid-item">
                    <h2 class="title title-normal">Почта</h2>
                    <div class="contact-flex">
                        <div class="text">
                            <p>Информация</p>
                            <p>Админчик</p>
                        </div>
                        <div class="text">
                            <p><a href="mailto:info@uclassic.ru" class="link">info@uclassic.ru</a></p>
                            <p><a href="mailto:admin@uclassic.ru" class="link">admin@uclassic.ru</a></p>
                        </div>
                    </div>
                </div>
                <div class="grid-item">
                    <h2 class="title title-normal">Телефон</h2>
                    <div class="contact-flex">
                        <div class="text">
                            <p>Приемная фитнес-клуба</p>
                            <p>Админчик</p>
                        </div>
                        <div class="text">
                            <p><a href="tel:+7 (495) 123-45-67" class="link">+7 (495) 123-45-67</a></p>
                            <p><a href="tel:+7 (495) 123-45-67" class="link">+7 (495) 123-45-67</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <h1 class="title title-large">О нас</h1>
            <div class="contact-about">
                <div>
                    <h2 class="title title-normal">Былые времена</h2>
                    <p>Высокий уровень вовлечения представителей целевой аудитории является четким доказательством простого факта: перспективное планирование создаёт предпосылки для позиций, занимаемых участниками в отношении поставленных задач. Имеется спорная точка.</p>
                </div>
                <div>
                    <h2 class="title title-normal">Цели</h2>
                    <p>Высокий уровень вовлечения представителей целевой аудитории является четким доказательством простого факта: перспективное планирование создаёт предпосылки для позиций, занимаемых участниками в отношении поставленных задач. Имеется спорная точка.</p>
                </div>
                <div>
                    <h2 class="title title-normal">Достижения</h2>
                    <p>Высокий уровень вовлечения представителей целевой аудитории является четким доказательством простого факта: перспективное планирование создаёт предпосылки для позиций, занимаемых участниками в отношении поставленных задач. Имеется спорная точка.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
