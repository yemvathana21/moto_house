<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CheckIn;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CheckInController extends Controller
{
    public function store(Request $request)
    {
        $customer = $request->user();
        $today = Carbon::today();

        $alreadyCheckedIn = CheckIn::where('customer_id', $customer->id)
            ->where('check_in_date', $today)
            ->exists();

        if ($alreadyCheckedIn) {
            return response()->json(['message' => 'Already checked in today!'], 422);
        }

        $yesterday = Carbon::yesterday();
        $lastCheckIn = CheckIn::where('customer_id', $customer->id)
            ->where('check_in_date', $yesterday)
            ->first();

        $streak = $lastCheckIn ? $lastCheckIn->streak + 1 : 1;
        $points = min(10 + ($streak - 1) * 5, 50);

        $checkIn = CheckIn::create([
            'customer_id' => $customer->id,
            'check_in_date' => $today,
            'streak' => $streak,
            'points' => $points,
        ]);

        return response()->json([
            'message' => 'Check-in successful!',
            'check_in' => [
                'streak' => $streak,
                'points' => $points,
                'date' => $today->toDateString(),
            ],
        ]);
    }

    public function status(Request $request)
    {
        $customer = $request->user();
        $today = Carbon::today();

        $todayCheckIn = CheckIn::where('customer_id', $customer->id)
            ->where('check_in_date', $today)
            ->first();

        $totalPoints = CheckIn::where('customer_id', $customer->id)->sum('points');

        $currentStreak = 0;
        $checkDate = $today;
        while (true) {
            $exists = CheckIn::where('customer_id', $customer->id)
                ->where('check_in_date', $checkDate)
                ->exists();
            if (!$exists) break;
            $currentStreak++;
            $checkDate = $checkDate->subDay();
        }

        $recentCheckIns = CheckIn::where('customer_id', $customer->id)
            ->orderByDesc('check_in_date')
            ->limit(30)
            ->pluck('check_in_date')
            ->map(fn ($d) => $d->toDateString());

        return response()->json([
            'checked_in_today' => $todayCheckIn !== null,
            'current_streak' => $currentStreak,
            'total_points' => (int) $totalPoints,
            'recent_check_ins' => $recentCheckIns,
        ]);
    }
}
