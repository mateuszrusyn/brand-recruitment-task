<?php

namespace Tests\Unit;

use App\Jobs\HandleEstateSupervisorShifts;
use App\Models\Estate;
use App\Models\User;
use App\Models\UserShift;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HandleEstateSupervisorShiftsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user1 = User::factory()->create();
        $this->user2 = User::factory()->create();

        $this->estate1 = Estate::factory()->create([
            'supervisor_user_id' => $this->user1->id,
            'street' => 'Nowogrodzka',
            'building_number' => '123',
            'city' => 'Warszawa',
            'zip' => '00-200'
        ]);

        $this->estate2 = Estate::factory()->create([
            'supervisor_user_id' => $this->user1->id,
            'street' => 'Wiejska',
            'building_number' => '123',
            'city' => 'Warszawa',
            'zip' => '00-000'
        ]);

        $this->shift = UserShift::factory()->create([
            'user_id' => $this->user1->id,
            'substitute_user_id' => $this->user2->id,
            'date_from' => Carbon::today()->format('Y-m-d'),
            'date_to' => Carbon::today()->addWeeks(2)->format('Y-m-d'),
            'temp_changes' => []
        ]);
    }

    public function test_estate_supervisors_change_to_the_new_ones(): void
    {
        HandleEstateSupervisorShifts::dispatchSync();

        $this->estate1->refresh();
        $this->estate2->refresh();

        $this->assertEquals($this->user2->id, $this->estate1->supervisor_user_id);
        $this->assertEquals($this->user2->id, $this->estate2->supervisor_user_id);

        $this->shift->refresh();
        $this->assertEquals([$this->estate1->id, $this->estate2->id], $this->shift->temp_changes);
    }

    public function test_estate_supervisors_revert_to_original_ones(): void
    {
        $this->test_estate_supervisors_change_to_the_new_ones();

        Carbon::setTestNow(Carbon::today()->addWeeks(2));

        HandleEstateSupervisorShifts::dispatchSync();

        $this->estate1->refresh();
        $this->estate2->refresh();

        $this->assertEquals($this->user1->id, $this->estate1->supervisor_user_id);
        $this->assertEquals($this->user1->id, $this->estate2->supervisor_user_id);
    }
}
