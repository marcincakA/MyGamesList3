<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGameListItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    protected function prepareForValidation() : void
    {
        $this->merge([
            'game_id' => strip_tags($this->input('game_id')),
            'user_id' => strip_tags($this->input('user_id')),
            'status' => strip_tags($this->input('status'))
        ]);
    }
    public function authorize(): bool
    {
        //todo zmen
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
            'game_id' => 'required',
            'user_id' => 'required',
            'status' => 'required|string'
        ];
    }
}
