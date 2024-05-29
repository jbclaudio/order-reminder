<?php

namespace Rapidez\OrderReminder\Mail\OrderReminder;

use Rapidez\OrderReminder\Models\OrderReminder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailable extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public OrderReminder $orderReminder,
        public string $unsubscribeUrl
    ) {
    }

    public function build(): SendMailable
    {
        return $this
            ->subject(__('Your order reminder!'))
            ->markdown('rapidez-order-reminder::emails.reminder');
    }
}
