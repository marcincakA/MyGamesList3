<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    protected function prepareForValidation() : void
    {
        $this->merge([
            'game_id' => strip_tags($this->input('game_id')),
            'user_id' => strip_tags($this->input('user_id')),
            'rating' => strip_tags($this->input('rating')),
            'text' => strip_tags($this->input('text'))
        ]);
    }
    /**
     * Determine if the user is authorized to make this request.
     */
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
            'game_id' => 'required|exists:games,game_id',
            'user_id' => 'required|exists:users,user_id',
            'rating' => 'required|min:1|max:10|integer',
            'text' => 'string|required'
        ];
    }
}
