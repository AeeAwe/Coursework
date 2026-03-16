<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\UserActivity;
use App\Models\UserAbonement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainerController extends Controller
{
    public function schedule (Request $request) {
        $trainer = Auth::user();
        $query = Schedule::with('trainer', 'activities')->where('trainer_id', $trainer->id);
        $schedule = $query->orderBy('date','desc')->paginate(10);
        return view('trainer.schedule', compact('schedule'));
    }

    public function activity (Request $request, Schedule $schedule) {
        $schedule->load('activities.user');
        return view('trainer.activity', compact('schedule'));
    }

    public function markAttendance(Request $request, UserActivity $activity)
    {
        $activity->status = 'attended';
        $activity->save();

        $userAbonement = UserAbonement::where('user_id', $activity->user_id)
            ->where('status', 'active')
            ->first();

        if ($userAbonement) {
            if ($userAbonement->visits_left > 0) {
                $userAbonement->visits_left -= 1;

                if ($userAbonement->visits_left === 0) {
                    $userAbonement->status = 'ended';
                }

                $userAbonement->save();
            }
        }

        return redirect()->back()->with('success', 'Посещение отмечено, одно занятие списано с абонемента');
    }

    public function cancelActivity(Request $request, UserActivity $activity)
    {
        $activity->delete();

        return redirect()->back()->with('success', 'Запись отменена');
    }
}
