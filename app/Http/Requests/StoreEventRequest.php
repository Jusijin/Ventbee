<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
            'category_id' => ['required', 'exists:categories,id'],
            'event_name' => ['required','string','max:150'],
            'description' => ['required','string'],
            'location' => ['required','string','max:200'],
            'date' => ['required','date'],
            'total_quota' => ['required','integer','min:1'],
            'registration_open' => ['required','date'],
            'registration_close' => ['required','date','after:registration_open'],  
        ];
    }
}
