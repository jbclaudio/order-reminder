<?php

namespace Rapidez\OrderReminder\Actions;

use Rapidez\OrderReminder\Events\SendOrderRemindersEvent;
use Rapidez\OrderReminder\Mail\OrderReminder\SendMailable;
use Rapidez\OrderReminder\Models\OrderReminder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class SendOrderReminders
{
    public function execute(): void
    {
        $orderReminders = $this->getOrderReminders();

        foreach ($orderReminders as $orderReminder) {
            Mail::to($orderReminder->email)->send(new SendMailable($orderReminder, URL::signedRoute(
                'rapidez-order-reminder.unsubscribe',
                compact('orderReminder')
            )));

            $orderReminder->update([
                'renewal_date' => now()->next(config('rapidez-order-reminder.cron_day'))
            ]);
        }

        SendOrderRemindersEvent::dispatch();
    }

    public function getOrderReminders(): Collection
    {
        return OrderReminder::where('is_confirmed', true)
            ->with(['products' => fn ($query) => $query->select(
                'entity_id',
                'name',
                'sku',
                'url_key',
                'thumbnail',
                'price',
                'special_price'
            )])
            ->get()
            ->where('reminder_date', today());
    }
}
