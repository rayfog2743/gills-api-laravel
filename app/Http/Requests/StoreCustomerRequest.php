<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
            'client_name' => 'required|string|max:255',
            'address'     => 'required|string',
            'pincode'     => 'required|digits:6',
            'mobile'      => 'required|digits:10',
            'email'       => 'nullable|email|max:255|unique:customers,email',
            'retailer'    => 'nullable|string|max:255',
            'supplier'    => 'nullable|string|max:255',
            'depositor_name' => 'nullable|string|max:255',
            'pan'         => 'nullable|string|max:20',
            'tan'         => 'nullable|string|max:20',
            'gstin'       => 'nullable|string|max:32',
            // optional pincode auto-fill fields:
            'district'    => 'nullable|string|max:255',
            'state'       => 'nullable|string|max:255',
            'country'     => 'nullable|string|max:255',
        ];
    }

     public function messages()
    {
        return [
            'client_name.required' => 'Client Name is required.',
            'address.required'     => 'Client Address is required.',
            'pincode.required'     => 'Pincode is required.',
            'pincode.digits'       => 'Pincode must be 6 digits.',
            'mobile.required'      => 'Mobile number is required.',
            'mobile.digits_between'=> 'Mobile must be between 7 and 15 digits.',
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
