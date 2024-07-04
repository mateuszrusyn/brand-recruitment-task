<?php

use App\Jobs\HandleEstateSupervisorShifts;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new HandleEstateSupervisorShifts)->daily();
