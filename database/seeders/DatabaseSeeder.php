<?php

namespace Database\Seeders;

use App\Models\Estate;
use App\Models\User;
use App\Models\UserShift;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user1 = User::factory()->create(['firstname' => 'Jan', 'lastname' => 'Kowalski']);
        $user2 = User::factory()->create(['firstname' => 'Adam', 'lastname' => 'Nowak']);
        $user3 = User::factory()->create(['firstname' => 'Radosław', 'lastname' => 'P']);
        $user4 = User::factory()->create(['firstname' => 'Maciek', 'lastname' => 'M']);
        $user5 = User::factory()->create(['firstname' => 'Antoni', 'lastname' => 'A']);

        $estate1 = Estate::create([
            'supervisor_user_id' => $user3->id,
            'street' => 'Koszykowa',
            'building_number' => '123',
            'city' => 'Warszawa',
            'zip' => '00-200'
        ]);

        $estate2 = Estate::create([
            'supervisor_user_id' => $user4->id,
            'street' => 'Mariacka',
            'building_number' => '123',
            'city' => 'Warszawa',
            'zip' => '00-200'
        ]);

        $estate3 = Estate::create([
            'supervisor_user_id' => $user4->id,
            'street' => 'Nowogrodzka',
            'building_number' => '123',
            'city' => 'Warszawa',
            'zip' => '00-200'
        ]);

        $estate4 = Estate::factory()->create([
            'supervisor_user_id' => $user1->id,
            'street' => 'Jabłonna',
            'building_number' => '23',
            'city' => 'Kraków',
            'zip' => '31-060'
        ]);

        $estate5 = Estate::factory()->create([
            'supervisor_user_id' => $user1->id,
            'street' => 'Grzybowska',
            'building_number' => '12',
            'city' => 'Kraków',
            'zip' => '00-001'
        ]);

        $estate6 = Estate::factory()->create([
            'supervisor_user_id' => $user2->id,
            'street' => 'Testowa',
            'building_number' => '3',
            'city' => 'Łódź',
            'zip' => '31-060'
        ]);

        $estate7 = Estate::factory()->create([
            'supervisor_user_id' => $user2->id,
            'street' => 'Herbaciana',
            'building_number' => '43',
            'city' => 'Kraków',
            'zip' => '81-718'
        ]);

        $estate8 = Estate::factory()->create([
            'supervisor_user_id' => $user1->id,
            'street' => 'Kwiatowa',
            'building_number' => '23',
            'city' => 'Kraków',
            'zip' => '31-223'
        ]);


        UserShift::factory()->create([
            'user_id' => $user1->id,
            'substitute_user_id' => $user2->id,
            'date_from' => Carbon::today()->format('Y-m-d'),
            'date_to' => Carbon::today()->addWeeks(2)->format('Y-m-d'),
            'temp_changes' => [],
        ]);

        UserShift::factory()->create([
            'user_id' => $user3->id,
            'substitute_user_id' => $user4->id,
            'date_from' => Carbon::today()->format('Y-m-d'),
            'date_to' => Carbon::today()->addWeeks(2)->format('Y-m-d'),
            'temp_changes' => [],
        ]);

        UserShift::factory()->create([
            'user_id' => $user5->id,
            'substitute_user_id' => $user4->id,
            'date_from' => Carbon::today()->subDays(10)->format('Y-m-d'),
            'date_to' => Carbon::today()->format('Y-m-d'),
            'temp_changes' => [$estate3->id],
        ]);
    }
}
