<?php

namespace Rapidez\OrderReminder\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Rapidez\Core\Models\Customer;

class OrderReminderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $bearerToken = $this->bearerToken();

        $customer = Customer::firstWhere('email', $this->email);

        if (!$customer) {
            return true;
        }

        return $customer
                ->oAuthTokens()
                ->where('token', $bearerToken)
                ->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'timespan' => [
                'required',
                'integer',
                Rule::in(config('rapidez-order-reminder.timespans'))
            ],
            'products' => 'required|array|min:1',
            'products.*' => 'required|exists:catalog_product_entity,entity_id'
        ];
    }
}
