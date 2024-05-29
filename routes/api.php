<?php

use Rapidez\OrderReminder\Http\Controllers\OrderReminderController;

Route::middleware('api')->prefix('api')->group(function () {
    Route::apiResource('order-reminders', OrderReminderController::class);
});
