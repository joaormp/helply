<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('tenants:run queue:work --sleep=3 --tries=3 --max-time=3600')
    ->everyMinute()
    ->withoutOverlapping();
