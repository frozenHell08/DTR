<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TimeTable;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class AdminDashboard extends Controller
{
    public function showDash() {
        $users = User::whereNotIn('lastName', ['qwe', 'admin'])
                ->orderBy('lastName')->get();

        return view ('admin.admindash', compact('users'));
    }

    public function getUserDetails($user) {
        try {
            $user = User::findOrFail($user);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'User not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        $latest = $user->timedata()->latest()->get();

        $tablerecord = TimeTable::where('user_id', $user->id)
                                ->whereDate('date', now()->toDateString())
                                ->first();

        if (is_null($tablerecord)) {
            $timeintoday = '--:--';
            $timeouttoday = '--:--';
        } else {
            $timeouttoday = (is_null($tablerecord->time_out)) ? '--:--' : Carbon::parse($tablerecord->time_out)->format('H:i.s');
            $timeintoday = (is_null($tablerecord)) ? '--:--' : Carbon::parse($tablerecord->time_in)->format('H:i.s');
        }

        $accHours = Controller::accumulatedHours($user);

        return response()->json([
            'user' => $user,
            'time' => [
                'in' => $timeintoday, 
                'out' => $timeouttoday,
                'total' => $accHours
            ],
            'latest' => $latest
        ]);
    }
}
