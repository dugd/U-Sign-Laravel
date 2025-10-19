<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SwitchSubscriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'plan' => ['required', 'string', Rule::in(['free', 'vip', 'pro'])],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'plan.required' => 'Please select a subscription plan.',
            'plan.in' => 'The selected plan is invalid. Choose from Free, VIP, or Pro.',
        ];
    }
}
