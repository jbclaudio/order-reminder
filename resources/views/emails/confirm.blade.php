@component('mail::message')
# Your order reminder!

Thank you for creating your order reminder. We have received your request and would like to let you know that we have registered your request. To activate the order reminder, simply click on the button below:

<x-rapidez::button class="add-to-cart" href="{{ $confirmUrl }}">Confirm Order Reminder</x-rapidez::button>

After confirmation, you will receive a reminder every') <strong>@choice('week|:count weeks', $orderReminder->timespan)</strong> with the following products:

<x-rapidez-order-reminder::email.products :products="$orderReminder->products" />

You will receive the first email on <strong>{{ $orderReminder->reminder_date->isoFormat('dddd D MMMM YYYY') }}</strong>.
@endcomponent
