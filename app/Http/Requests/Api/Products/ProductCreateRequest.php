<?php

namespace App\Http\Requests\Api\Products;

use CodeZero\UniqueTranslation\UniqueTranslationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductCreateRequest extends FormRequest
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
        $rules = [
            'name' => ['required', 'array'],
            'images' => ['required', 'array'],
            'images.*' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'description' => ['nullable', 'array'],
            'price' => ['required', 'numeric', 'between:1,9999.99'],
            'category_id' => ['required', Rule::exists('categories', 'id')->whereNotNull('parent_id')]
        ];

        foreach (config('app.locales') as $locale) {
            $rules["name.$locale"] = ['required', 'string', 'max:125', UniqueTranslationRule::for('products', 'name')];
            $rules["description.$locale"] = ['nullable', 'string', 'max:255'];
        }

        return $rules;
    }
}
