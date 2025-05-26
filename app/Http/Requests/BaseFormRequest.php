<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseFormRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $input = $this->all();
        $normalized = $this->normalizeBooleans($input);
        $this->replace($normalized);
    }

    /**
     * Recursively normalize boolean values in the request data.
     *
     * @param array $input
     * @return array
     */
    protected function normalizeBooleans(array $input): array
    {
        foreach ($input as $key => $value) {
            // Handle nested arrays recursively
            if (is_array($value)) {
                $input[$key] = $this->normalizeBooleans($value);
                continue;
            }

            // Convert string boolean representations to actual booleans
            if (is_string($value) && in_array(strtolower($value), ['true', 'false', 'yes', 'no', 'on', 'off'], true)) {
                $input[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            }
        }

        return $input;
    }
}