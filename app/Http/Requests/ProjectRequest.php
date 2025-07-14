<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'client_id' => 'required|exists:clients,id',
            'status' => ['required', Rule::in(['planning', 'in_progress', 'on_hold', 'completed', 'cancelled'])],
            'priority' => ['required', Rule::in(['low', 'medium', 'high', 'urgent'])],
            'start_date' => 'nullable|date',
            'due_date' => 'nullable|date|after_or_equal:start_date',
            'budget' => 'nullable|numeric|min:0|max:999999999.99',
            'hourly_rate' => 'nullable|numeric|min:0|max:999999.99',
            'estimated_hours' => 'nullable|numeric|min:0|max:999999',
            'notes' => 'nullable|string|max:5000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome do projeto é obrigatório.',
            'client_id.required' => 'O cliente é obrigatório.',
            'client_id.exists' => 'O cliente selecionado não existe.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status deve ser válido.',
            'priority.required' => 'A prioridade é obrigatória.',
            'priority.in' => 'A prioridade deve ser válida.',
            'due_date.after_or_equal' => 'A data de entrega deve ser posterior ou igual à data de início.',
            'budget.numeric' => 'O orçamento deve ser um número.',
            'budget.min' => 'O orçamento deve ser maior ou igual a zero.',
            'hourly_rate.numeric' => 'A taxa horária deve ser um número.',
            'hourly_rate.min' => 'A taxa horária deve ser maior ou igual a zero.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'user_id' => auth()->id(),
            'budget' => $this->input('budget', 0),
            'hourly_rate' => $this->input('hourly_rate', 0),
            'estimated_hours' => $this->input('estimated_hours', 0),
        ]);
    }
} 