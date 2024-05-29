<?php

namespace Rapidez\OrderReminder\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Rapidez\Core\Models\Customer;
use Rapidez\Core\Models\Product;
use Rapidez\Core\Models\Scopes\Product\WithProductStockScope;

class OrderReminder extends Model
{
    protected $guarded = [];

    protected $appends = ['reminder_date'];

    protected $casts = [
        'renewal_date' => 'datetime'
    ];

    protected static function booted(): void
    {
        static::saving(function (OrderReminder $orderReminder) {
            $orderReminder->renewal_date = now()->is(config('rapidez-order-reminder.cron_day')) ? now() : now()->next(config('rapidez-order-reminder.cron_day'));
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withoutGlobalScopes()
            ->withGlobalScope(WithProductStockScope::class, new WithProductStockScope());
    }

    public function reminderDate(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->renewal_date->addWeeks($this->timespan)
        );
    }
}
