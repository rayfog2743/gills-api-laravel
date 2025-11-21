<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;
use App\Models\Variation;

class VariationUpdateRequest extends FormRequest
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
      $routeVar = $this->route('variation') ?? $this->route('id');
        $id = $routeVar instanceof Variation ? $routeVar->id : $routeVar;

        return [
            'name' => [
                'required','required','string','max:100',
                Rule::unique('variations', 'name')->ignore($id),
            ],
            'status' => ['sometimes','required','in:active,inactive'],
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
