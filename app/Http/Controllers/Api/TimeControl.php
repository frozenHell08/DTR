<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TimeTable;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class TimeControl extends Controller
{
    public function updateDuration(Request $request) {
        $validation = Validator::make($request->all(), [
            'user' => ['required', 'exists:users,id'],
            'from' => ['required', 'date'],
            'to' => ['required', 'date'],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'error' => $validation->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $collection = collect();
        $user = User::find($request->user);

        $from = Carbon::parse($request->from);
        $to = Carbon::parse($request->to);

        foreach ($user->timeDataByRange($from, $to)->get() as $entry) {
            $start = Carbon::parse($entry->time_in);
            $end = Carbon::parse($entry->time_out);
    
            $duration = $start->diff($end);
            $durationFormatted = $duration->format('%h hours %i minutes');
    
            if ($entry->duration !== $durationFormatted) {
                $entry->update(['duration' => $durationFormatted]);

                $entry->created_at = $entry->time_in;
                $entry->save();

                $entry->updated_at = $entry->time_out;
                $entry->save();

                $collection->push([$entry, $durationFormatted]);
            } else {
                $entry->created_at = $entry->time_in;
                $entry->save();

                $entry->updated_at = $entry->time_out;
                $entry->save();

                $collection->push([$entry->time_out, $entry->updated_at, $entry->time_in, $entry->created_at]);
            }
        }

        return response()->json([
            'data' => $collection->count(),
            'col' => $collection
        ]);
    }

    public function timeduration(Request $request) {
        $collection = collect();

        $user = User::find($request->user);

        $from = Carbon::parse($request->from);
        $to = Carbon::parse($request->to);

        if ($request->from == null) {
            foreach ($user->timedata as $data) {
                $collection->push($this->timeformat($data));
            }

            return response()->json([
                'data' => $collection,
            ]);
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
        }
        
        if ($user == null) {
            foreach (TimeTable::all() as $entry) {
                $collection->push($this->timeformat($entry));
            }

            return response()->json([
                'col' => $collection
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
