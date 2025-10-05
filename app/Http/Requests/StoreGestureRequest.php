<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGestureRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'slug' => [
                'required',
                'string',
                'max:128',
                'unique:gestures,slug',
                'alpha_dash',
            ],
            'translation.language_code' => [
                'required',
                'string',
                'max:2',
            ],
            'translation.title' => [
                'required',
                'string',
                'max:255',
            ],
            'translation.description' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'translation.video' => [
                'nullable',
                'file',
                'mimetypes:video/mp4,video/webm,video/quicktime',
                'max:51200',
            ],
        ];
    }
}
