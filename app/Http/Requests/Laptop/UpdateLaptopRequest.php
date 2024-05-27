<?php

namespace App\Http\Requests\Laptop;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLaptopRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'serial_number' => ['required'],
            'brand' => ['required'],
            'warrantyexpirationdate' => ['required', 'date', 'date_format:Y-m-d'],
            'fullbatterycapacity' => ['required'],
            'currentbatterycapacity' => ['required'],
            'diskperformance' => ['required'],
            'spec' => ['required'],
            'status' => ['required'],
        ];
    }
}
