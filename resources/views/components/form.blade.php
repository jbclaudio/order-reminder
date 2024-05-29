@props([
    'products',
    'key' => 'entity_id',
    'edit' => false,
    'noEmail' => false
])
<order-reminder-form
    :product-ids="{{ $products.'.'.$key.' ? ['.$products.'.'.$key.'] : Object.values('.$products.').map(item => item.'.$key.')' }}"
    @if($edit)
        :order-reminder="orderReminder"
    @endif
    v-cloak
>
    <div slot-scope="{ toggleForm, show, variables, submitForm, submitDelete }">
        <div v-if="show">
            <div class="fixed inset-0 z-[101] pointer-events-auto bg-neutral/30 transition-opacity"></div>
            <div class="fixed inset-0 flex items-center z-[102] mx-4 sm:mx-auto">
                <div class="relative bg-white flex flex-col mx-auto my-8 align-middle shadow-black rounded-6 overflow-hidden" v-on-click-away="toggleForm">
                    <div class="flex w-full sm:w-[500px]">
                        <div class="w-[calc(100vw-30px)] sm:w-full">
                            <div class="flex items-center justify-between bg-primary pt-7 pb-7 pl-3.5 pr-3 sm:pl-10 sm:pr-9">
                                <h2 class="text-white text-18 font-medium">
                                    @lang('Order reminder')
                                </h2>
                                <button class="text-white" v-on:click="toggleForm">
                                    <x-heroicon-o-x-mark class="w-6" />
                                </button>
                            </div>
                            <div class="mt-7">
                                <form class="flex flex-col flex-1" v-on:submit.prevent="submitForm()">
                                    <div class="px-4 sm:px-10">
                                        @if(!$edit && !$noEmail)
                                            <div class="mb-6">
                                                <x-rapidez::input v-model="variables.email" name="email" type="email" label="Email" required />
                                            </div>
                                        @endif
                                        <x-rapidez::select name="timespan" v-model="variables.timespan" label="Timespan" required>
                                            @foreach(config('rapidez-order-reminder.timespans') as $index)
                                                <option :value="{{ $index }}">
                                                    <span>@lang('Every')</span>
                                                    <span>@choice('week|:count weeks', $index)</span>
                                                </option>
                                            @endforeach
                                        </x-rapidez::select>
                                        <ul class="max-h-[155px] overflow-x-auto no-scrollbar pl-1 pt-1 mt-5 pb-7 space-y-3">
                                            <li v-for="product in ({{ $products }}.{{ $key }} ? [{{ $products }}] : {{ $products }})">
                                                <x-rapidez::checkbox
                                                    v-model="variables.products"
                                                    ::value="product.{{ $key }}"
                                                    ::disabled="{{ $products }}.{{ $key }} || Object.keys({{ $products }}).length == 1"
                                                >
                                                    @{{ product.name }}
                                                </x-rapidez::checkbox>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="flex flex-wrap-reverse items-center gap-y-4 border-t py-7 px-4 justify-end sm:px-10">
                                        @if($edit)
                                            <x-rapidez::button
                                                v-on:click="submitDelete"
                                                variant="none"
                                                class="font-bold text-neutral mr-1.5 px-0 sm:mr-4"
                                            >
                                                @lang('Delete')
                                            </x-rapidez::button>
                                        @endif
                                        <x-rapidez::button.outline v-on:click="toggleForm">
                                            @lang('Close')
                                        </x-rapidez::button.outline>
                                        <x-rapidez::button.primary
                                            type="submit"
                                            class="flex group ml-4 md:ml-7"
                                            ::disabled="window.app.$data.loading"
                                        >
                                            <span v-if="!window.app.$data.loading" class="flex items-center gap-x-2.5">
                                                <x-heroicon-o-bell class="h-3.5 w-3.5 group-hover:animate-wiggle origin-[50%_25%]" />
                                                @lang('Save reminder')
                                            </span>
                                            <span v-else class="flex items-center gap-x-2.5">
                                                <x-heroicon-o-arrow-path class="h-3.5 w-3.5 animate-spin" />
                                                @lang('Saving')...
                                            </span>
                                        </x-rapidez::button.primary>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div
            class="flex items-center font-medium text-inactive cursor-pointer group gap-x-2"
            aria-label="{{ __('Order reminder') }}"
            v-on:click="if (!window.app.$data.loading) { toggleForm() }"
        >
            @if($edit)
                <x-heroicon-o-ellipsis-horizontal class="absolute top-6 right-6" />
            @else
                <x-heroicon-o-bell class="w-4 h-4 group-hover:animate-wiggle origin-[50%_25%]" />
                <span class="text-15">@lang('Order reminder')</span>
            @endif
        </div>
    </div>
</order-reminder-form>
