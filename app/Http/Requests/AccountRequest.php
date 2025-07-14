<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'required|in:checking,savings,investment,credit,other',
            'current_balance' => 'required|numeric|min:-999999999.99|max:999999999.99',
            'currency' => 'required|string|max:3|default:BRL',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome da conta é obrigatório.',
            'type.required' => 'O tipo da conta é obrigatório.',
            'type.in' => 'O tipo da conta deve ser válido.',
            'current_balance.required' => 'O saldo atual é obrigatório.',
            'current_balance.numeric' => 'O saldo deve ser um número.',
            'currency.required' => 'A moeda é obrigatória.',
            'logo.image' => 'O arquivo deve ser uma imagem.',
            'logo.mimes' => 'A imagem deve ser JPEG, PNG, JPG ou GIF.',
            'logo.max' => 'A imagem não pode ter mais que 2MB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => auth()->id(),
            'is_active' => $this->boolean('is_active', true),
        ]);
    }
} 