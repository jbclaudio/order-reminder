@props(['productId', 'defaultTimespan' => 1])

<order-reminder-form :product-ids="[{{ $productId }}]" :default-timespan="{{ $defaultTimespan }}" v-cloak>
    <div id="order-reminder" slot-scope="{ variables, submitForm }">
        <div class="text-neutral text-16 font-medium mb-4">
            @lang('Set your order reminder:')
            <template v-if="variables.timespan > 1">
                <span class="text-inactive font-normal">(@{{ variables.timespan }} @lang('weeks'))</span>
            </template>
            <template v-else>
                <span class="text-inactive font-normal">(@lang('Every week'))</span>
            </template>
        </div>
        <form class="grid grid-cols-2 sm:grid-cols-3 gap-4" v-on:submit.prevent="submitForm">
            @foreach(config('rapidez-order-reminder.timespans') as $index)
                <x-rapidez::radio name="reminder" id="{{ $index }}" value="{{ $index }}" v-model="variables.timespan">
                    <div class="flex flex-col items-center justify-center">
                        <span class="text-14 text-inactive">@lang('Every')</span>
                        <span class="text-15 text-neutral font-medium -mt-0.5">@choice('week|:count weeks', $index)</span>
                    </div>
                </x-rapidez::radio>
            @endforeach
            <x-rapidez::input
                v-model="variables.email"
                id="email"
                name="email"
                type="text"
                wrapperClass="col-span-2 sm:col-span-3"
                labelClass="sr-only"
                class="shadow-gray pr-11 mt-1"
                :placeholder="__('Enter your email address here')"
            >
                <x-heroicon-o-bell class="absolute mt-0.5 right-6 top-1/2 -translate-y-1/2 size-5" />
            </x-rapidez::input>
            <x-rapidez::button.primary class="col-span-2 sm:col-span-3 mt-1">@lang('Set order reminder')</x-rapidez::button.primary>
        </form>
    </div>
</order-reminder-form>
