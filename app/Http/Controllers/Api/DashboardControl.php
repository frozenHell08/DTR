<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TimeTable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DashboardControl extends Controller
{
    public function timein(Request $request) {
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

        return redirect()->json([
            'status' => 'success',
            'message' => 'Time in success!',
            'time-in' => $timein
        ], Response::HTTP_CREATED);
    }

    public function timeout(Request $request) {
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

        return response()->json([
            'status' => 'success',
            'message' => 'Time out success!'
        ], Response::HTTP_OK);
    }

    public function selftable() {
        $user = auth()->user();

        return response()->json([
            'time data' => $user->timedata
        ]);
    }
}
