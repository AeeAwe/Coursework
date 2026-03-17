<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Abonement;
use App\Models\Schedule;
use App\Models\UserAbonement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function register (Request $request) {
        $validated = $request->validate([
            'fio' => 'required|regex:/^[а-яА-Я\s]+$/u',
            'phone' => 'required|regex:/^\+7\(\d{3}\)-\d{3}\-\d{2}\-\d{2}$/',
            'email' => 'required|email|unique:users,email',
            'login' => 'required|min:6|unique:users,login|regex:/^[a-zA-Z\d]+$/',
            'password' => 'required|min:6|regex:/^[a-zA-Z\d]+$/',
            'role' => 'required|string|in:client,trainer,admin'
        ], [
            'required' => 'Поле обязательно для заполнения',
            'unique'   => 'Поле с таким значением уже используется',
            'min'      => 'Поле должно быть не меньше :min символов',
            'email'    => 'Введите корректный адрес электронной почты',
            'in'       => 'Выбрана недействительная роль',
            'regex'    => 'Поле имеет неверный формат',
            'fio.regex' => 'Поле должно содержать только кириллицу и пробелы',
            'login.regex' => 'Поле должно содержать только латиницу и цифры',
            'password.regex' => 'Поле должно содержать только латиницу и цифры',
            'phone.regex'     => 'Телефон должен быть в формате +7(XXX)-XXX-XX-XX',
        ]);
        User::create($validated);
        return redirect()
            ->back()
            ->with('success', 'Пользователь зарегистрирован');
    }

    public function users(Request $request)
    {
        $query = User::query();
        $sortBy = $request->input('sort_by', 'id_desc');

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('fio', 'like', '%' . $search . '%')
                  ->orWhere('login', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        match ($sortBy) {
            'id_asc' => $query->orderBy('id', 'asc'),
            'fio_asc' => $query->orderBy('fio', 'asc'),
            'login_asc' => $query->orderBy('login', 'asc'),
            default => $query->orderBy('id', 'desc'),
        };

        $users = $query->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function editUser($userId)
    {
        $user = User::findOrFail($userId);
        return view('admin.edit-user', compact('user'));
    }

    public function updateUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        try {
            $data = $request->validate([
                'edit_fio' => 'required|regex:/^[а-яА-Я\s]+$/u',
                'edit_phone' => 'required|regex:/^\+7\(\d{3}\)-\d{3}\-\d{2}\-\d{2}$/',
                'edit_email' => 'required|email|unique:users,email,'.$user->id,
                'edit_login' => 'required|min:6|unique:users,login,'.$user->id.'|regex:/^[a-zA-Z\d]+$/',
                'edit_password' => 'nullable|min:6|regex:/^[a-zA-Z\d]+$/',
                'edit_role' => 'required|string|in:client,trainer,admin'
            ], [
                'required' => 'Поле обязательно для заполнения',
                'unique' => 'Поле с таким значением уже используется',
                'min' => 'Поле должно быть не меньше :min символов',
                'email' => 'Введите корректный адрес электронной почты',
                'in' => 'Выбрана недействительная роль',
                'regex' => 'Поле имеет неверный формат',
                'edit_fio.regex' => 'Поле должно содержать только кириллицу и пробелы',
                'edit_login.regex' => 'Поле должно содержать только латиницу и цифры',
                'edit_password.regex' => 'Поле должно содержать только латиницу и цифры',
                'edit_phone.regex' => 'Телефон должен быть в формате +7(XXX)-XXX-XX-XX',
            ]);
        } catch (ValidationException $e) {
            return back()
                ->withInput()
                ->withErrors($e->errors())
                ->with('show_edit_modal', true)
                ->with('edit_user_id', $userId);
        }

        $user->fio = $data['edit_fio'];
        $user->phone = $data['edit_phone'];
        $user->email = $data['edit_email'];
        $user->login = $data['edit_login'];
        $user->role = $data['edit_role'];
        if (!empty($data['edit_password'])) {
            $user->password = Hash::make($data['edit_password']);
        }
        $user->save();

        return redirect()->route('admin.users')->with('success', 'Пользователь обновлён');
    }

    public function deleteUser($userId)
    {
        User::findOrFail($userId)->delete();
        return redirect()->back()->with('success', 'Пользователь удалён.');
    }

    public function abonements_bookings()
    {
        $bookings = UserAbonement::with(['user', 'abonement'])->where('status', 'pending')->get();
        return view('admin.abonements_bookings', compact('bookings'));
    }

    public function approveBooking($bookingId)
    {
        $booking = UserAbonement::findOrFail($bookingId);

        $booking->update(['status' => 'active']);
        return redirect()->back()->with('success', 'Бронь подтверждена, абонемент выдан клиенту');
    }

    public function rejectBooking($bookingId)
    {
        UserAbonement::findOrFail($bookingId)->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Бронь отклонена');
    }

    public function scheduleManage(Request $request)
    {
        Schedule::where('status', 'active')
            ->where('date', '<', \Carbon\Carbon::now())
            ->update(['status' => 'completed']);

        $query = Schedule::query();

        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $trainerId = $request->input('trainer_id') ?? $request->input('trainer');
        $status = $request->input('status');
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'id_desc');

        if ($dateFrom) {
            $query->where('date', '>=', date('Y-m-d 00:00:00', strtotime($dateFrom)));
        }
        if ($dateTo) {
            $query->where('date', '<=', date('Y-m-d 23:59:59', strtotime($dateTo)));
        }
        if ($trainerId) {
            $query->where('trainer_id', $trainerId);
        }
        if ($status) {
            $query->where('status', $status);
        }
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        match ($sortBy) {
            'id_asc' => $query->orderBy('id', 'asc'),
            'date_asc' => $query->orderBy('date', 'asc'),
            'date_desc' => $query->orderBy('date', 'desc'),
            'name_asc' => $query->orderBy('name', 'asc'),
            default => $query->orderBy('id', 'desc'),
        };

        $schedule = $query->paginate(15);
        $trainers = User::where('role', 'trainer')->get();
        return view('admin.schedule', compact('schedule', 'trainers'));
    }

    public function createSchedule(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'date' => 'required|after:today',
            'trainer_id' => 'required|exists:users,id',
            'capacity' => 'required|integer|min:1',
        ], [
            'required' => 'Поле обязательно для заполнения',
            'date_format' => 'Формат даты должен быть: ГГГГ-ММ-ДД ЧЧ:ММ (например, 2024-06-15 14:00)',
            'after' => 'Занятие можно назначить только на будущую дату',
            'exists' => 'Значения поля не существует в системе',
            'integer' => 'Поле должно быть числом',
            'min.numeric' => 'Количество мест должно быть не меньше :min',
        ]);

        Schedule::create($data);
        return redirect()->back()->with('success', 'Занятие добавлено');
    }

    public function updateSchedule(Request $request, $scheduleId)
    {
        try {
            $data = $request->validate([
                'edit_name' => 'required|string',
                'edit_date' => 'required|date_format:Y-m-d\TH:i',
                'edit_trainer_id' => 'required|exists:users,id',
                'edit_capacity' => 'required|integer|min:1',
            ], [
                'required' => 'Поле обязательно для заполнения',
                'date_format' => 'Формат даты должен быть: ГГГГ-ММ-ДД ЧЧ:ММ',
                'exists' => 'Значения поля не существует в системе',
                'integer' => 'Поле должно быть числом',
                'min.numeric' => 'Количество мест должно быть не меньше :min',
            ]);
        } catch (ValidationException $e) {
            return back()
                ->withInput()
                ->withErrors($e->errors())
                ->with('show_schedule_modal', true)
                ->with('schedule_id', $scheduleId);
        }

        Schedule::findOrFail($scheduleId)->update([
            'name' => $data['edit_name'],
            'date' => $data['edit_date'],
            'trainer_id' => $data['edit_trainer_id'],
            'capacity' => $data['edit_capacity']
        ]);
        return redirect()->back()->with('success', 'Занятие обновлено');
    }

    public function deleteSchedule($scheduleId)
    {
        Schedule::findOrFail($scheduleId)->delete();
        return redirect()->back()->with('success', 'Занятие удалено');
    }

    public function abonementsManage(Request $request)
    {
        $query = Abonement::query();
        $sortBy = $request->input('sort_by', 'latest');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }

        match ($sortBy) {
            'oldest' => $query->orderBy('id', 'asc'),
            'name_asc' => $query->orderBy('name', 'asc'),
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            default => $query->latest(),
        };

        $abonements = $query->get();
        return view('admin.abonements', compact('abonements'));
    }

    public function createAbonement(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'visits' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ], [
            'required' => 'Поле обязательно для заполнения',
            'integer' => 'Поле должно быть числом',
            'numeric' => 'Поле должно быть числом',
            'min.numeric' => 'Значение должно быть не меньше :min',
        ]);

        Abonement::create($data);
        return redirect()->back()->with('success', 'Абонемент добавлен');
    }

    public function updateAbonement(Request $request, $abonementId)
    {
        try {
            $data = $request->validate([
                'edit_name' => 'required|string',
                'edit_visits' => 'required|integer|min:1',
                'edit_price' => 'required|numeric|min:0',
                'edit_description' => 'nullable|string',
            ]);
        } catch (ValidationException $e) {
            return back()
                ->withInput()
                ->withErrors($e->errors())
                ->with('show_abonement_modal', true)
                ->with('abonement_id', $abonementId);
        }

        Abonement::findOrFail($abonementId)->update([
            'name' => $data['edit_name'],
            'visits' => $data['edit_visits'],
            'price' => $data['edit_price'],
            'description' => $data['edit_description']
        ]);
        return redirect()->back()->with('success', 'Абонемент обновлён');
    }

    public function deleteAbonement($abonementId)
    {
        Abonement::findOrFail($abonementId)->delete();
        return redirect()->back()->with('success', 'Абонемент удалён');
    }

    public function updateScheduleStatus(Request $request, $scheduleId)
    {
        $schedule = Schedule::findOrFail($scheduleId);
        $status = $request->input('status');

        if (!in_array($status, ['active', 'completed', 'cancelled'])) {
            return redirect()->back()->with('error', 'Невалидный статус');
        }

        $schedule->update(['status' => $status]);
        return redirect()->back()->with('success', 'Статус занятия изменен на: ' . ($status === 'active' ? 'Активно' : ($status === 'completed' ? 'Завершено' : 'Отменено')));
    }
}
