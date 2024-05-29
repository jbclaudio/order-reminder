<?php

namespace Rapidez\OrderReminder\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Rapidez\OrderReminder\Actions\SendOrderReminders;

class SendOrderRemindersJob
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;

    public function handle(SendOrderReminders $sendOrderReminders): void
    {
        $sendOrderReminders->execute();
    }
}
