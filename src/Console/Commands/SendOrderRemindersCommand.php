<?php

namespace Rapidez\OrderReminder\Console\Commands;

use Illuminate\Console\Command;
use Rapidez\OrderReminder\Jobs\SendOrderRemindersJob;

class SendOrderRemindersCommand extends Command
{
    protected $signature = 'order-reminders:send';

    protected $description = 'Send order reminder mailings';

    public function handle(): int
    {
        SendOrderRemindersJob::dispatch();

        return static::SUCCESS;
    }
}
