<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DebtController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $debts = Auth::user()->debts()->with('account')->orderBy('priority', 'desc')->orderBy('due_date')->get();
        return view('debts.index', compact('debts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $accounts = Auth::user()->accounts()->get();
        $creditCards = Auth::user()->creditCards()->active()->get();
        return view('debts.create', compact('accounts', 'creditCards'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'original_amount' => 'required|numeric|min:0',
            'interest_rate' => 'required|numeric|min:0|max:100',
            'priority' => 'required|in:low,medium,high,critical',
            'due_date' => 'nullable|date',
            'start_date' => 'required|date',
            'creditor_name' => 'nullable|string|max:255',
            'creditor_contact' => 'nullable|string|max:255',
            'contract_number' => 'nullable|string|max:255',
            'debt_type' => 'required|in:credit_card,personal_loan,mortgage,car_loan,student_loan,business_loan,other',
            'account_id' => 'nullable|exists:accounts,id',
            'negotiated_amount' => 'nullable|numeric|min:0',
            'installments' => 'nullable|integer|min:1|max:120',
            'installment_amount' => 'nullable|numeric|min:0',
            'agreement_date' => 'nullable|date',
            'first_payment_date' => 'nullable|date',
            'iof_rate' => 'nullable|numeric|min:0|max:1',
            'credit_card_id' => 'nullable|exists:credit_cards,id',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['current_balance'] = $validated['original_amount']; // Inicialmente igual ao valor original
        $validated['status'] = 'active'; // Status padrão
        
        // Marcar como negociada se houver valor negociado
        $validated['is_negotiated'] = !empty($validated['negotiated_amount']);
        
        // Processar campos de negociação
        if (empty($validated['agreement_date'])) {
            $validated['agreement_date'] = null;
        }
        if (empty($validated['negotiated_amount'])) {
            $validated['negotiated_amount'] = null;
        }
        if (empty($validated['installments'])) {
            $validated['installments'] = null;
        }
        if (empty($validated['installment_amount'])) {
            $validated['installment_amount'] = null;
        }

        $validated['credit_card_id'] = $request->input('credit_card_id');

        Debt::create($validated);

        return redirect()->route('debts.index')->with('success', 'Dívida criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Debt $debt)
    {
        $this->authorize('view', $debt);
        $debt->load(['account', 'payments']);
        return view('debts.show', compact('debt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Debt $debt)
    {
        $this->authorize('update', $debt);
        $accounts = Auth::user()->accounts()->get();
        $creditCards = Auth::user()->creditCards()->active()->get();
        return view('debts.edit', compact('debt', 'accounts', 'creditCards'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Debt $debt)
    {
        $this->authorize('update', $debt);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'original_amount' => 'required|numeric|min:0',
            'current_balance' => 'required|numeric|min:0',
            'interest_rate' => 'required|numeric|min:0|max:100',
            'priority' => 'required|in:low,medium,high,critical',
            'status' => 'required|in:active,paid,defaulted',
            'due_date' => 'nullable|date',
            'start_date' => 'required|date',
            'creditor_name' => 'nullable|string|max:255',
            'creditor_contact' => 'nullable|string|max:255',
            'contract_number' => 'nullable|string|max:255',
            'debt_type' => 'required|in:credit_card,personal_loan,mortgage,car_loan,student_loan,business_loan,other',
            'account_id' => 'nullable|exists:accounts,id',
            'first_payment_date' => 'nullable|date',
            'iof_rate' => 'nullable|numeric|min:0|max:1',
            'credit_card_id' => 'nullable|exists:credit_cards,id',
        ]);

        $validated['credit_card_id'] = $request->input('credit_card_id');
        $debt->update($validated);

        return redirect()->route('debts.index')->with('success', 'Dívida atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Debt $debt)
    {
        $this->authorize('delete', $debt);
        
        $debt->delete();

        return redirect()->route('debts.index')->with('success', 'Dívida excluída com sucesso!');
    }
}
