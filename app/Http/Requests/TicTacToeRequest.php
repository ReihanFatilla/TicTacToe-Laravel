<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TicTacToeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message'   => $validator->errors(),
        ]));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:32',
            'type' => 'required',
            'game_state' => 'required|array',
            'game_state.*.*' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'type.required' => 'Type is required!',
            'type.nullable' => 'Name Cannot be Null!',
            'game_state.required' => 'Game State is required!',
        ];
    }
}
