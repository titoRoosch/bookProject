<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DashboardFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'from_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:' . now()->year,
                'lte:to_year', // ✅ must be <= to_year
            ],
            'to_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:' . now()->year,
                'gte:from_year', // ✅ must be >= from_year
            ],
            'top_authors' => [
                'nullable',
                'integer',
                'min:1',
                'max:100',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'from_year.lte' => 'The start year must be less than or equal to the end year.',
            'to_year.gte' => 'The end year must be greater than or equal to the start year.',
            'from_year.integer' => 'The start year must be a number.',
            'to_year.integer' => 'The end year must be a number.',
            'top_authors.integer' => 'The top authors value must be a number.',
        ];
    }
}
