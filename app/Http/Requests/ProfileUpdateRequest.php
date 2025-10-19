<?php

namespace App\Http\Requests;

use App\Models\Gesture;
use App\Models\User;
use App\Services\FeatureGate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $featureGate = new FeatureGate();
        $user = $this->user();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
        ];

        if ($featureGate->allow($user, 'profile.vanity_slug')) {
            $rules['vanity_slug'] = [
                'nullable',
                'string',
                'alpha_dash',
                'max:50',
                Rule::unique(User::class)->ignore($user->id),
            ];
        }

        if ($featureGate->allow($user, 'profile.fingerspelling')) {
            $rules['fingerspelling_gesture_id'] = [
                'nullable',
                'integer',
                Rule::exists(Gesture::class, 'id')->where('created_by', $user->id),
            ];
        }

        return $rules;
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'vanity_slug.unique' => 'This vanity slug is already taken.',
            'vanity_slug.alpha_dash' => 'The vanity slug may only contain letters, numbers, dashes and underscores.',
            'fingerspelling_gesture_id.exists' => 'The selected gesture must be one of your own gestures.',
        ];
    }
}
