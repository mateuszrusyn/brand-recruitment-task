<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserShift;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class UserShiftFactory extends Factory
{
    protected $model = UserShift::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'substitute_user_id' => User::factory(),
            'date_from' => Carbon::today()->format('Y-m-d'),
            'date_to' => Carbon::today()->addWeeks(2)->format('Y-m-d'),
            'temp_changes' => [],
        ];
    }
}
