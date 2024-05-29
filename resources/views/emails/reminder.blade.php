@component('mail::message')
# Your order reminder!

We would like to remind you of the products you have previously shown interest in. Below is a list of these products.

<x-rapidez-order-reminder::email.products :products="$orderReminder->products" />

Click the button below to quickly and easily order these products.

<x-rapidez::button class="add-to-cart" href="{{ config('app.url') }}/cart/?skus={{ $orderReminder->products->implode('sku', ',') }}">Add to cart'</x-rapidez::button>
<x-rapidez::button class="unsubscribe" href="{{ $unsubscribeUrl }}">Unsubscribe from order reminders</x-rapidez::button>
@endcomponent
