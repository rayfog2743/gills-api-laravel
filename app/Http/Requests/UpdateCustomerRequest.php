<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // ✅ FIX

class UpdateCustomerRequest extends FormRequest
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

         $customerId = $this->route('customer') ?: $this->route('id');
        return [
              'client_name' => 'sometimes|required|string|max:255',
            'address'     => 'sometimes|required|string',
            'pincode'     => 'sometimes|required|digits:6',
            'mobile'      => 'sometimes|required|digits_between:7,15',
            'email'       => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('customers', 'email')->ignore($customerId),
            ],
            'retailer'    => 'nullable|string|max:255',
            'supplier'    => 'nullable|string|max:255',
            'depositor_name' => 'nullable|string|max:255',
            'pan'         => 'nullable|string|max:20',
            'tan'         => 'nullable|string|max:20',
            'gstin'       => 'nullable|string|max:32',
            'district'    => 'nullable|string|max:255',
            'state'       => 'nullable|string|max:255',
            'country'     => 'nullable|string|max:255',
        ];
    }

     protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
{
    $response = response()->json([
        'status'  => false,
        'message' => 'Validation error',
        'errors'  => $validator->errors()->first(),
    ], 422);

    throw new \Illuminate\Validation\ValidationException($validator, $response);
}

}
