@extends('rapidez::account.partials.layout')

@section('title', __('My orders reminders'))

@section('robots', 'NOINDEX,NOFOLLOW')

@section('account-content')
    <div class="container">
        <order-reminder-list>
            <div slot-scope="{ orderReminders, getOrderReminders }">
                <div class="w-full relative mb-6 mt-12 sm:mt-4">
                    <a href="/account" class="absolute -top-1 sm:hidden">
                        <x-heroicon-o-arrow-small-left class="w-8 h-8 text-neutral" />
                    </a>
                    <x-title.lg tag="h1" class="ml-9 sm:ml-0">@lang('My orders reminders') (@{{ orderReminders.length }})</x-title.lg>
                </div>
                <div v-if="orderReminders.length == 0" class="text-inactive">
                    <p class="italic mt-4">@lang('How it works')?<p>
                    <ol class="list-decimal list-outside ml-4 space-y-2">
                        <li>@lang('Go to your favorite product').</li>
                        <li>@lang('Click on "Set order reminder"').</li>
                        <li>@lang('Choose how often you want to receive a reminder').</li>
                        <li>@lang('Confirm your email address and you are done')!</li>
                    </ol>
                </div>
                <div v-else v-cloak>
                    <x-card.gray class="lg:pb-5 lg:pt-9 lg:first:pt-0">
                        <x-card.address v-for="orderReminder in orderReminders" class="overflow-hidden rounded-xl relative border shadow-gray mb-5 pt-5 pb-6 pl-8 pr-6 md:pr-16 not:first-child:mt-5">
                            <div class="absolute bg-primary w-1 h-full top-0 left-0"></div>
                            <div class="flex flex-col sm:flex-row">
                                <div class="w-full sm:w-[202px] text-inactive font-medium text-16">
                                    @{{ window.config.translations.product[+(orderReminder.products.length !== 1)] }}:
                                </div>
                                <div class="flex flex-col md:flex-1">
                                    <a class="text-primary font-medium text-16" v-for="product in orderReminder.products" :href="product.url">
                                        @{{ product.name }}
                                    </a>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row mt-2.5">
                                <div class="w-full sm:w-[202px] text-inactive font-medium text-16">@lang('Next reminder'):</div>
                                <div class="md:flex-1 text-neutral font-medium text-16 first-letter:uppercase">
                                    @{{ new Date(orderReminder.reminder_date).toLocaleDateString('nl-NL', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row mt-2.5">
                                <div class="w-full sm:w-[202px] text-inactive font-medium text-16">@lang('Reminder every'):</div>
                                <div class="md:flex-1 text-neutral font-medium text-16">
                                    @{{ orderReminder.timespan }} @{{ window.config.translations.week[+(orderReminder.timespan !== 1)] }}
                                </div>
                            </div>
                            <x-order-reminder.form products="orderReminder.products" edit />
                        </x-card.address>
                    </x-card.gray>
                </div>
            </div>
        </order-reminder-list>
    </div>
@endsection
