<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGestureRequest extends FormRequest
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
        $gestureId = $this->route('gesture')->id;

        return [
            'slug' => [
                'required',
                'string',
                'max:128',
                'alpha_dash',
                Rule::unique('gestures','slug')->ignore($gestureId),
            ],
            'canonical_language_code' => [
                'required',
                'string',
                'max:2',
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
            'translation.delete_video' => [
                'nullable',
                'boolean',
            ],
        ];
    }
}
