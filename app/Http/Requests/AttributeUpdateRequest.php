<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use App\Model\Attribute;

class AttributeUpdateRequest extends FormRequest
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
        $attribute = $this->route('attribute'); // model
        $id = $attribute?->id;

        return [
            'attribute_name' => 'required|required|string|max:150',
            'price'          => 'required|required|numeric|min:0',
            'variation_id'   => 'required|required|exists:variations,id',
            'image'          => 'nullable|image|max:2048',
        ];
    }


       protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                //'errors' => $validator->errors()
            ], 201)
        );
    }
}
