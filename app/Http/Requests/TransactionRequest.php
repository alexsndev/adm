<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01|max:999999999.99',
            'type' => ['required', Rule::in(['income', 'expense', 'transfer'])],
            'date' => 'required|date|before_or_equal:today',
            'category_id' => 'required|exists:categories,id',
            'account_id' => 'required|exists:accounts,id',
            'notes' => 'nullable|string|max:1000',
            'reference' => 'nullable|string|max:255',
            'is_recurring' => 'boolean',
            'recurring_frequency' => 'nullable|string|in:daily,weekly,monthly,yearly',
            'recurring_end_date' => 'nullable|date|after:date',
            'debt_id' => 'nullable|exists:debts,id',
        ];

        // Regras específicas para transferências
        if ($this->input('type') === 'transfer') {
            $rules['transfer_account_id'] = 'required|exists:accounts,id|different:account_id';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'description.required' => 'A descrição é obrigatória.',
            'amount.required' => 'O valor é obrigatório.',
            'amount.numeric' => 'O valor deve ser um número.',
            'amount.min' => 'O valor deve ser maior que zero.',
            'type.required' => 'O tipo é obrigatório.',
            'type.in' => 'O tipo deve ser receita, despesa ou transferência.',
            'date.required' => 'A data é obrigatória.',
            'date.before_or_equal' => 'A data não pode ser futura.',
            'category_id.required' => 'A categoria é obrigatória.',
            'category_id.exists' => 'A categoria selecionada não existe.',
            'account_id.required' => 'A conta é obrigatória.',
            'account_id.exists' => 'A conta selecionada não existe.',
            'transfer_account_id.required' => 'A conta de destino é obrigatória para transferências.',
            'transfer_account_id.different' => 'A conta de destino deve ser diferente da conta de origem.',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Garantir que o user_id seja sempre do usuário autenticado
        $this->merge([
            'user_id' => auth()->id(),
        ]);
    }
} 