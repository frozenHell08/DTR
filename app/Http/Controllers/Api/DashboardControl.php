<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TimeTable;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DashboardControl extends Controller
{
    public function timein() {
        $date = Carbon::now()->toDateString();

        $exists = TimeTable::where('user_id', auth()->user()->id)
                            ->whereDate('date', $date)
                            ->exists();

        if ($exists) {
            return response()->json([
                'error' => 'Already timed in!'
            ], Response::HTTP_CONFLICT);
        }

        $timein = TimeTable::create([
            'user_id' => auth()->user()->id,
            'date' => date('Y-m-d'),
            'time_in' => now()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Time in success!',
            'time-in' => $timein
        ], Response::HTTP_CREATED);
    }

    public function timeout() {
        $date = Carbon::now()->toDateString();

        $exists = TimeTable::where('user_id', auth()->user()->id)
                            ->whereDate('date', $date)
                            ->exists();

        if (! $exists) {
            return response()->json([
                'error' => 'You haven\'t timed in yet!'
            ], Response::HTTP_NOT_FOUND);
        }

        $userTime = TimeTable::where('user_id', auth()->user()->id)
                        ->whereDate('date', $date)->first();

        if (! is_null($userTime->time_out)) {
            return response()->json([
                'error' => 'Already timed out!'
            ], Response::HTTP_CONFLICT);
        }

        $userTime->update(['time_out' => now()]);

        $start = Carbon::parse($userTime->time_in);
        $end = Carbon::parse($userTime->time_out);

        $duration = $start->diff($end);
        $durationFormatted = $duration->format('%h hours %i minutes');

        $userTime->update(['duration' => $durationFormatted]);

        return response()->json([
            'status' => 'success',
            'message' => 'Time out success!',
            'duration' => $durationFormatted,
            'dayrecord' => $userTime
        ], Response::HTTP_OK);
    }

    public function selftable() {
        $user = auth()->user();

        return response()->json([
            'time data' => $user->timedata->sortDesc()->values()->all()
        ]);
    }

    public function timeduration(Request $request) {
        $collection = collect();

        $user = User::find($request->user);

        $from = Carbon::parse($request->from);
        $to = Carbon::parse($request->to);
        
        if ($request->from == null) {
            return 'null';
        } else {
            return 'value';
        }

        if ($from !== null && $to !== null) {
            foreach ($user->timeDataByRange($from, $to)->get() as $entry) {

                $collection->push(($entry->duration));
            }

            $hours = 0;
            $minutes = 0;

            foreach ($collection as $col) {
                $duration = CarbonInterval::fromString($col);
                $hours += $duration->hours;
                $minutes += $duration->minutes;
            }

            $hours += floor($minutes / 60);
            $minutes %= 60;

            return response()->json([
                'data' => $collection,
                'total' => $hours . ' hours ' . $minutes . ' minutes '
            ]);
        } else {
            return 'hello';
        }
        
        if ($user == null) {
            foreach (TimeTable::all() as $entry) {
                $collection->push($this->timeformat($entry));
            }

            return response()->json([
                'col' => $collection
            ]);
        } else {
            foreach ($user->timedata as $data) {
                $collection->push($this->timeformat($data));
            }

            return response()->json([
                'user' => $user,
                'data' => $collection,
            ]);
        }
    }

    protected function timeformat ($entry) {
        $start = Carbon::parse($entry->time_in);
        $end = Carbon::parse($entry->time_out);

        $duration = $start->diff($end);

        $durationFormatted = $duration->format('%h hours %i minutes');

        return [$entry->user_id, $entry->date, $start, $end, $durationFormatted];
    }
}
