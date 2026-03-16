<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CabinetController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TrainerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('index');});
Route::get('/contacts', function () {return view('pages.contacts');})->name('contacts');
Route::get('/trainers', function () {return view('pages.trainers');})->name('trainers');
Route::get('/abonements', [ClientController::class, 'abonements'])->name('abonements');
Route::get('/schedule', [ClientController::class, 'schedule'])->name('schedule');

Route::middleware('guest')->group(function() {
    Route::get('/login', [AuthController::class, 'index'])->name('s_login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});
Route::middleware('auth')->group(function() {
    Route::get('/cabinet/abonements', [CabinetController::class, 'cabinet_abonements'])->name('cabinet.abonements');
    Route::get('/cabinet/activities', [CabinetController::class, 'cabinet_activities'])->name('cabinet.activities');
    Route::get('/cabinet/personal', [CabinetController::class, 'cabinet_personal'])->name('cabinet.personal');
    Route::post('/logout', [AuthController::class,'logout'])->name('logout');
});
Route::middleware(['auth','client'])->group(function() {
    Route::post('/abonements/book/{abonement}', [ClientController::class, 'bookAbonement'])->name('abonements.book');
    Route::post('/schedules/book/{schedule}', [ClientController::class, 'bookSchedule'])->name('schedules.book');
    Route::delete('/cabinet/activities/delete/{userActivity}', [ClientController::class, 'cancel_activity'])->name('cabinet.activities.cancel');
    Route::delete('/cabinet/abonements/cancel/{userAbonement}', [CabinetController::class, 'cancel_abonement'])->name('cabinet.abonements.cancel');
});
Route::middleware(['auth','admin'])->group(function() {
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('user.edit');
    Route::put('/users/{user}/update', [AdminController::class, 'updateUser'])->name('user.update');
    Route::delete('/users/{user}/destroy', [AdminController::class, 'deleteUser'])->name('user.delete');
    Route::post('/register', [AdminController::class, 'register'])->name('admin.register');

    Route::get('/admin/abonements', [AdminController::class, 'abonementsManage'])->name('admin.abonements');
    Route::post('/admin/abonements', [AdminController::class, 'createAbonement'])->name('admin.create-abonement');
    Route::put('/admin/abonements/{abonement}', [AdminController::class, 'updateAbonement'])->name('admin.update-abonement');
    Route::delete('/admin/abonements/{abonement}', [AdminController::class, 'deleteAbonement'])->name('admin.delete-abonement');
    Route::get('/admin/abonements/bookings', [AdminController::class, 'abonements_bookings'])->name('admin.abonements.bookings');

    Route::post('/admin/abonements/bookings/{booking}/approve', [AdminController::class, 'approveBooking'])->name('admin.approve-booking');
    Route::post('/admin/abonements/bookings/{booking}/reject', [AdminController::class, 'rejectBooking'])->name('admin.reject-booking');

    Route::get('/admin/schedule', [AdminController::class, 'scheduleManage'])->name('admin.schedule');
    Route::post('/admin/schedule', [AdminController::class, 'createSchedule'])->name('admin.create-schedule');
    Route::put('/admin/schedule/{schedule}', [AdminController::class, 'updateSchedule'])->name('admin.update-schedule');
    Route::patch('/admin/schedule/{schedule}/status', [AdminController::class, 'updateScheduleStatus'])->name('admin.update-schedule-status');
    Route::delete('/admin/schedule/{schedule}', [AdminController::class, 'deleteSchedule'])->name('admin.delete-schedule');

});
Route::middleware(['auth','trainer'])->group(function() {
    Route::get('/trainer/schedule', [TrainerController::class, 'schedule'])->name('trainer.schedule');
    Route::get('/trainer/schedule/{schedule}', [TrainerController::class, 'activity'])->name('trainer.activity');
    Route::post('/trainer/activities/{activity}/mark', [TrainerController::class, 'markAttendance'])->name('trainer.mark-attendance');
    Route::post('/trainer/activities/{activity}/cancel', [TrainerController::class, 'cancelActivity'])->name('trainer.cancel-a');
});
