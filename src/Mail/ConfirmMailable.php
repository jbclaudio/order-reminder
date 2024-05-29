<?php

namespace Rapidez\OrderReminder\Mail;

use Rapidez\OrderReminder\Models\OrderReminder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmMailable extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public OrderReminder $orderReminder,
        public string $confirmUrl
    ) {
    }

    public function build(): ConfirmMailable
    {
        return $this
            ->subject(__('Confirm your order reminder'))
            ->markdown('rapidez-order-reminder::emails.confirm');
    }
}
