<?php

namespace App\Http\Requests\BorrowDevice;

use Illuminate\Foundation\Http\FormRequest;

class StoreBorrowDeviceRequest extends FormRequest
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
            'device_name' => ['required'],
            'serial_number' => [],
            'return_status' => ['boolean'],
            'borrow_id' => ['required', 'numeric']
        ];
    }
}
