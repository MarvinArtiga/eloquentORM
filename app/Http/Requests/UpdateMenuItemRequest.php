<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isPatch = $this->isMethod('patch');

        return [
            'name' => $isPatch ? 'sometimes|required|string|max:255' : 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => $isPatch ? 'sometimes|required|numeric|min:0' : 'required|numeric|min:0',
            'category' => $isPatch ? 'sometimes|required|string|max:255' : 'required|string|max:255',
            'available' => 'boolean',
        ];
    }
}
