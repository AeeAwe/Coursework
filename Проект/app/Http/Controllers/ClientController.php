<?php

namespace App\Http\Controllers;

use App\Models\Abonement;
use App\Models\Schedule;
use App\Models\User;
use App\Models\UserAbonement;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ClientController extends Controller
{
    public function abonements () {
        $abonements = Abonement::with('userAbonements')->get();
        return view('pages.abonements', compact('abonements'));
    }
    public function bookAbonement (Abonement $abonement) {
        $user = Auth::user();
        $abonementIsExist = UserAbonement::where('user_id', $user->id)
            ->whereIn('status', ['pending','active'])
            ->exists();
        if ($abonementIsExist) {
            return redirect()->route('cabinet.abonements')->with('error', 'У вас уже есть абонемент');
        }
        UserAbonement::create([
            'user_id' => $user->id,
            'abonement_id' => $abonement->id,
            'visits_left' => $abonement->visits,
        ]);
        return redirect()->route('cabinet.abonements')->with('success', 'Заявка направлена администратору');
    }
    public function schedule (Request $request)
    {
        $query = Schedule::with(['trainer', 'activities']);
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $trainerId = $request->input('trainer');
        $search = $request->input('search');
        $sortBy = $request->input('sort_by', 'date');

        $query->where('status', 'active')->where('date', '>=', Carbon::now());

        if ($dateFrom) {
            $query->where('date', '>=', date('Y-m-d 00:00:00', strtotime($dateFrom)));
        }
        if ($dateTo) {
            $query->where('date', '<=', date('Y-m-d 23:59:59', strtotime($dateTo)));
        }
        if ($trainerId) {
            $query->where('trainer_id', $trainerId);
        }
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($sortBy === 'date') {
            $query->orderBy('date', 'asc');
        } elseif ($sortBy === 'availability') {
            $query->orderByRaw('(capacity - (SELECT COUNT(*) FROM user_activities WHERE schedule_id = schedules.id AND status IN ("recorded", "attended"))) ASC');
        } elseif ($sortBy === 'name') {
            $query->orderBy('name', 'asc');
        }

        $schedule = $query->paginate(10);
        $trainers = User::where('role', 'trainer')->get();
        return view('pages.schedule', compact(['schedule','trainers']));
    }
    public function bookSchedule (Schedule $schedule) {
        $user = Auth::user();
        $scheduleIsExist = $schedule->activities()
            ->where('user_id', $user->id)
            ->exists();
        if ($scheduleIsExist) {
            return redirect()->route('cabinet.activities')->with('error', 'Вы уже были записаны');
        }
        $participantsCount = $schedule->activities()
            ->whereIn('status', ['recorded', 'attended'])
            ->count();
        if ($participantsCount >= $schedule->capacity) {
            return redirect()->route('schedule')->with('error', 'Занятие полностью заполнено');
        }

        UserActivity::create([
            'user_id' => $user->id,
            'schedule_id' => $schedule->id,
        ]);
        return redirect()->route('cabinet.activities')->with('success', 'Вы успешно записались');
    }

    public function cancel_activity (UserActivity $userActivity) {
        $user = Auth::user();
        if ($userActivity->user_id !== $user->id) {
            return back()->with('error', 'Вы не можете отменить чужую запись');
        }
        if (!\Carbon\Carbon::parse($userActivity->schedule->date)->isFuture()) {
            return back()->with('error', 'Нельзя отменить запись, если дата уже прошла');
        }
        $userActivity->delete();
        return redirect()->route('cabinet.activities')->with('success', 'Запись отменена');
    }
}
