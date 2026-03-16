<?php

namespace App\Http\Controllers;

use App\Models\UserActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CabinetController extends Controller
{
    public function cabinet_abonements () {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();
        $user->load(['abonements.abonement']);
        return view('pages.cabinet.abonements', compact('user'));
    }
    public function cabinet_activities () {
        /**
         * @var \App\Models\User $user
         */
        $user = Auth::user();
        $user->load(['activities.schedule.trainer']);
        return view('pages.cabinet.activities', compact('user'));
    }
    public function cabinet_personal () {
        $user = Auth::user();
        return view('pages.cabinet.personal', compact('user'));
    }
    public function cancel_activity (UserActivity $userActivity) {
        $user = Auth::user();
        if ($userActivity->user_id !== $user->id) {
            return back()->with('error', 'Вы не можете отменить чужую запись.');
        }
        if (!\Carbon\Carbon::parse($userActivity->schedule->date)->isFuture()) {
            return back()->with('error', 'Нельзя отменить запись, если дата уже прошла.');
        }
        $userActivity->delete();
        return redirect()->route('cabinet')->with('success', 'Запись отменена.');
    }
}
