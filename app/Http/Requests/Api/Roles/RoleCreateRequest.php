<?php

namespace App\Http\Requests\Api\Roles;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RoleCreateRequest extends FormRequest
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
            'title' => [
                'required',
                'string',
                'max:50',
                function ($attribute, $value, $fail) {
                    $slug = Str::slug($value);
                    $exists = DB::table('roles')->where('name', $slug)->exists();

                    if ($exists)
                        $fail('The :attribute already exists');
                }
            ],
            'permission_names' => ['required', 'array', Rule::exists('permissions', 'name')]
        ];
    }
}
