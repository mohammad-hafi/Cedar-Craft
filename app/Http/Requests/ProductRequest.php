<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>['required','string','max:255'],
            'description'=>['required','string','min:3','max:1000'],
            'material'=>['required'],
            'dimentions'=>['required','string'],
            'price'=>['required','numeric','min:5'],
            'image' => ['required', 'array'],
            'image.*' => ['image', 'mimes:jpg,png,jpeg,gif,svg']
        ];
    }
}
