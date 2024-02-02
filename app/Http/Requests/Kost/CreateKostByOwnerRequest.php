<?php

namespace App\Http\Requests\Kost;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateKostByOwnerRequest extends FormRequest
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
            'kost_name' => ['required', 'string', 'min:4', 'max:100'],
            'address' => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string', 'max:200'],
            'room_total' => ['required', 'integer'],
            'room_available' => ['required', 'integer', 'between:0,' . $this->input('room_total')],
            'price' => ['required', 'numeric'],

            // relation
            'gender_id' => ['required', 'in:1,2,3'],
            'area_id' => ['required', 'integer'],

            // facility array
            'facilities' => ['nullable', 'array'],
            'facilities.*' => ['integer', 'distinct']
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response([
            "error" => $validator->getMessageBag()
        ], 422));
    }
}
