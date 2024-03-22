<?php

namespace App\Helpers;

use App\Mail\DailyVoteSummary;
use Illuminate\Support\Facades\Mail;

if (!function_exists('sendDailyVoteSummary')) {
    function sendDailyVoteSummary($dailyTotals, $overallTotals) {
        Mail::to('dev@steadfastcollective.com')->send(new DailyVoteSummary($dailyTotals, $overallTotals));
    }
}