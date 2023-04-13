<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\CarbonInterval;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function accumulatedHours(User $user) {
        $collection = collect();

        foreach ($user->timeData as $data) {
            $collection->push($data->duration);
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

        return $hours . ' hours ' . $minutes . ' minutes ';
    }
}
