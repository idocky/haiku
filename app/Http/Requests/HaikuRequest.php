<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HaikuRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'is_hidden' => 'required|boolean',
            'theme_id' => 'required|exists:themes,id',
            'user_id' => 'required|exists:users,id',
            'content' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $lines = explode("\n", $value);
                    if (count($lines) > 4) {
                        $fail('Не более 4 строк');
                    }
                },
            ],
        ];
    }
}
