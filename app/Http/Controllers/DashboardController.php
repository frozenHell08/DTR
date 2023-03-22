<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TimeTable;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function timein() {

        $date = Carbon::now()->toDateString();

        $exists = TimeTable::where('user_id', auth()->user()->id)
                            ->whereDate('date', $date)
                            ->exists();

        if ($exists) {
            Session::flash('status', 'Already timed in!');
            return back();
        }

        TimeTable::create([
            'user_id' => auth()->user()->id,
            'date' => date('Y-m-d'),
            'time_in' => now()
        ]);

        return redirect()->back()->with('status', 'Time in success!');
    }

    public function timeout() {
        $date = Carbon::now()->toDateString();

        $exists = TimeTable::where('user_id', auth()->user()->id)
                            ->whereDate('date', $date)
                            ->exists();

        if (! $exists) {
            Session::flash('status', 'You haven\'t timed in yet!');
            return back();
        }

        $userTime = TimeTable::where('user_id', auth()->user()->id)
                        ->whereDate('date', $date)->first();

        if (! is_null($userTime->time_out)) {
            return redirect()->back()->with('status', 'Already timed out!');
        }

        $userTime->update(['time_out' => now()]);

        return redirect()->back()->with('status', 'Time out success!');
    }
}