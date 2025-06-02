<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:255'],
            'orderBy' => ['nullable', 'in:title,publish_date'],
            'direction' => ['nullable', 'in:asc,desc'],
        ];
    }
}
