<?php

namespace App\Jobs;

use App\Models\Estate;
use App\Models\UserShift;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HandleEstateSupervisorShifts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $today = Carbon::today();

        $startingShifts = UserShift::where('date_from', $today)->get();

        foreach ($startingShifts as $shift) {
            $estates = Estate::where('supervisor_user_id', $shift->user_id)->get();
            $changedEstates = [];

            foreach ($estates as $estate) {
                $estate->supervisor_user_id = $shift->substitute_user_id;
                $estate->save();
                $changedEstates[] = $estate->id;
            }

            $shift->temp_changes = $changedEstates;
            $shift->save();
        }

        $endingShifts = UserShift::where('date_to', $today)->get();
        foreach ($endingShifts as $shift) {
            $estates = Estate::where('supervisor_user_id', $shift->substitute_user_id)
                ->whereIn('id', $shift->temp_changes)
                ->get();

            foreach ($estates as $estate) {
                $estate->supervisor_user_id = $shift->user_id;
                $estate->save();
            }
        }
    }
}
