<?php

namespace App\Http\Requests\Borrow;

use Illuminate\Foundation\Http\FormRequest;

class StoreBorrowRequest extends FormRequest
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
            'date' => ['required', 'date', 'date_format:Y-m-d'],
            'employee_id' => ['required', 'numeric'],
            'employee_name' => ['required'],
            'employee_phone' => ['required', 'numeric'],
            'employee_rank' => ['required'],
            'employee_dept' => ['required'],
            'branch_id' => ['required', 'numeric']
        ];
    }
}
