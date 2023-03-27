<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TimeTable;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\Factory;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function display() {
        $tablerecord = TimeTable::where('user_id', auth()->user()->id)
                                ->whereDate('date', now()->toDateString())
                                ->first();

        // $timeintoday = (is_null($tablerecord)) ? '--:--' : Carbon::parse($tablerecord->time_in)->format('H:i.s');

        if (is_null($tablerecord)) {
            $timeintoday = '--:--';
            $timeouttoday = '--:--';
        } else {
            $timeouttoday = (is_null($tablerecord->time_out)) ? '--:--' : Carbon::parse($tablerecord->time_out)->format('H:i.s');
            $timeintoday = (is_null($tablerecord)) ? '--:--' : Carbon::parse($tablerecord->time_in)->format('H:i.s');
        }

        $user = auth()->user();
        $timetable = auth()->user()->timeData;

        return view('dashboard', compact('user', 'timetable', 'timeintoday', 'timeouttoday'));
    }

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

        $start = Carbon::parse($userTime->time_in);
        $end = Carbon::parse($userTime->time_out);

        $duration = $start->diff($end);
        $durationFormatted = $duration->format('%h hours %i minutes');

        $userTime->update(['duration' => $durationFormatted]);

        return redirect()->back()->with('status', 'Time out success!');
    }
}