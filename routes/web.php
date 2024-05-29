<?php

use Rapidez\OrderReminder\Http\Controllers\OrderReminderController;

Route::middleware('web')->group(function () {
    Route::view('account/order-reminders', 'account.order-reminders');
    Route::controller(OrderReminderController::class)->group(function () {
        Route::get('order_reminders/confirm/{orderReminder}', 'confirm')->name('rapidez-order-reminder.confirm')->middleware('signed');
        Route::get('order_reminders/unsubscribe/{orderReminder}', 'unsubscribe')->name('rapidez-order-reminder.unsubscribe')->middleware('signed');
    });
});
