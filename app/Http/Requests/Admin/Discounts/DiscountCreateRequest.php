<?php

namespace App\Http\Requests\Admin\Discounts;

use App\Enums\DiscountTypeEnum;
use App\Http\Requests\BaseFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DiscountCreateRequest extends BaseFormRequest
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
            'description' => ['nullable', 'array'],
            'code' => ['nullable', 'string', 'max:125', Rule::unique('discounts', 'code')],
            'type' => ['required', Rule::enum(DiscountTypeEnum::class)],
            'value' => ['required', 'numeric', 'between:1,9999.99'],
            'start_date' => ['required', 'date', 'date_format:Y-m-d'],
            'end_date' => ['required', 'date', 'after:start_date', 'date_format:Y-m-d'],
            'active' => ['required', 'boolean'],
            'max_uses' => ['required', 'integer', 'min:1', 'max:1000000'],
            'max_uses_per_user' => ['required', 'integer', 'min:1', 'max:1000000'],
        ];

        foreach (config('app.locales') as $locale) {
            $rules["name.$locale"] = ['required', 'string', 'max:125'];
            $rules["description.$locale"] = ['nullable', 'string', 'max:255'];
        }

        return $rules;
    }
}
