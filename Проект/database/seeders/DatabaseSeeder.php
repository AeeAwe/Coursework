<?php

namespace Database\Seeders;

use App\Models\Abonement;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'fio' => 'admin221',
            'phone' => '+7(999)-121-12-12',
            'email' => 'admin@example.com',
            'login' => 'admin221',
            'password' => 'admin221',
            'role' => 'admin'
        ]);
        User::create([
            'fio' => 'trainer221',
            'phone' => '+7(999)-122-12-12',
            'email' => 'trainer@example.com',
            'login' => 'trainer221',
            'password' => 'trainer221',
            'role' => 'trainer'
        ]);
        User::create([
            'fio' => 'client221',
            'phone' => '+7(999)-123-12-12',
            'email' => 'client@example.com',
            'login' => 'client221',
            'password' => 'client221',
            'role' => 'client'
        ]);
        Abonement::create([
            'name' => 'Абонемент 10 занятий',
            'visits' => 10,
            'price' => 1700,
            'description' => 'Абонемент на 10 занятий, действующий неограничено по времени',
        ]);
        Abonement::create([
            'name' => 'Абонемент 20 занятий',
            'visits' => 20,
            'price' => 3500,
            'description' => 'Абонемент на 20 занятий, действующий неограничено по времени',
        ]);
        Abonement::create([
            'name' => 'Безлимитный месяц',
            'visits' => 9999,
            'price' => 9999,
            'description' => 'Безлимитные занятия неограничено по времени',
        ]);
        foreach (range(1, 5) as $i) {
            Schedule::create([
                'trainer_id' => User::where('role', 'trainer')->firstOrFail()->id,
                'name' => collect(['Пилатес','Йога','Групповая тренировка','Тяжелый вес'])->random(),
                'date' => now()->addDays(rand(3,9))->setTime(rand(9, 18), 0, 0),
                'capacity' => rand(2, 6) * 5,
                'status' => 'active',
            ]);
        }
    }
}
