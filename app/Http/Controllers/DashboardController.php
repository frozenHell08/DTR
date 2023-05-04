<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TimeTable;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\View\Factory;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function display() {
        $tablerecord = TimeTable::where('user_id', auth()->user()->id)
                                ->whereDate('date', now()->toDateString())
                                ->first();

        if (is_null($tablerecord)) {
            $timeintoday = '--:--';
            $timeouttoday = '--:--';
        } else {
            $timeouttoday = (is_null($tablerecord->time_out)) ? '--:--' : Carbon::parse($tablerecord->time_out)->format('H:i.s');
            $timeintoday = (is_null($tablerecord)) ? '--:--' : Carbon::parse($tablerecord->time_in)->format('H:i.s');
        }

        $user = auth()->user();
        $rawTable = auth()->user()->timedata;
        $timetable = Timetable::where('user_id', auth()->user()->id)
            ->latest()
            ->paginate();
        
        $timeInRecordExists = $timeintoday !== '--:--';
        $imageExists = (File::exists(public_path(str_replace('public', 'storage', $user->profile_picture)))) ? true : false;
        $accHours = Controller::accumulatedHours($user);

        return view('dashboard', compact('user', 'imageExists' ,'timetable', 'rawTable', 'timeintoday', 'timeouttoday', 'timeInRecordExists', 'accHours'));
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

    public function getTableData(Request $request) {
        $collection = collect();

        $user = User::find($request->user);

        $from = Carbon::parse($request->from);
        $to = Carbon::parse($request->to);

        if ($request->from == null) {
            foreach ($user->timeData as $entry) {
                $collection->push(($entry));
            }

            $total = $this->totalTime($collection);

            return response()->json([
                'totaltime' => $total,
                'data' => $user->timedata
            ]);

        }

        if ($request->from !== null && $request->to == null) {
            foreach ($user->timeDataByRange($from, now())->get() as $entry) {
                $collection->push(($entry));

            }

            $total = $this->totalTime($collection);

            return response()->json([
                'request' => $request->all(),
                'totaltime' => $total,
                'data' => $collection
            ]);
        }

        if ($request->from !== null && $request->to !== null) {
            foreach ($user->timeDataByRange($from, $to)->get() as $entry) {
                $collection->push(($entry));
            }

            $total = $this->totalTime($collection);

            return response()->json([
                'request' => $request->all(),
                'totaltime' => $total,
                'data' => $collection
            ]);
        }
    }

    protected function totalTime($collection) {
        $hours = 0;
        $minutes = 0;

        foreach ($collection as $col) {
            $duration = CarbonInterval::fromString($col->duration);
            $hours += $duration->hours;
            $minutes += $duration->minutes;
        }

        $hours += floor($minutes / 60);
        $minutes %= 60;

        return $hours . ' hours ' . $minutes . ' minutes ';
    }
}