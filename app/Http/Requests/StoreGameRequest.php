<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGameRequest extends FormRequest
{
    protected function prepareForValidation() : void
    {
        $this->merge([
            'name' => strip_tags($this->input('name')),
            'pubisher' => strip_tags($this->input('publisher')),
            'developer' => strip_tags($this->input('developer')),
            'category1' => strip_tags($this->input('category1')),
            'category2' => strip_tags($this->input('category2')),
            'category3' => strip_tags($this->input('category3')),
            'about' => strip_tags($this->input('about')),
            'image' => strip_tags($this->input('image')),
        ]);
    }
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        //TODO zmen potom aby sa nedalo len tak vkladat nove hry
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
            'name' => 'required|string|max:255'
        ];
    }
}
