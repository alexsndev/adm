<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = Account::where('user_id', Auth::id())->get();
        
        // Buscar dívidas negociadas do usuário
        $negotiatedDebts = \App\Models\Debt::where('user_id', Auth::id())
            ->where('is_negotiated', true)
            ->with(['account'])
            ->orderBy('agreement_date', 'desc')
            ->get();
            
        return view('accounts.index', compact('accounts', 'negotiatedDebts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('accounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:checking,savings,credit,cash,investment',
            'initial_balance' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('accounts_logos', 'public');
        }

        $account = Account::create($data);
        $account->updateBalance();

        return redirect()->route('accounts.index')->with('success', 'Conta criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        // Verificar se a conta pertence ao usuário
        if ($account->user_id !== Auth::id()) {
            abort(403);
        }

        $transactions = Transaction::where('account_id', $account->id)
            ->where('user_id', Auth::id())
            ->where('is_recurring', false)
            ->orderBy('date', 'desc')
            ->take(10)
            ->get();

        // Dívidas vinculadas à conta
        $debts = $account->debts()->with('creditCard')->orderBy('due_date')->get();
        // Cartões de crédito vinculados à conta
        $creditCards = $account->creditCards()->with('debts')->get();

        return view('accounts.show', compact('account', 'transactions', 'debts', 'creditCards'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        // Verificar se a conta pertence ao usuário
        if ($account->user_id !== Auth::id()) {
            abort(403);
        }

        return view('accounts.edit', compact('account'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Account $account)
    {
        // Verificar se a conta pertence ao usuário
        if ($account->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:checking,savings,credit,cash,investment',
            'initial_balance' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('logo')) {
            // Remove logo antiga se existir
            if ($account->logo && \Storage::disk('public')->exists($account->logo)) {
                \Storage::disk('public')->delete($account->logo);
            }
            $data['logo'] = $request->file('logo')->store('accounts_logos', 'public');
        }

        $account->update($data);
        $account->updateBalance();

        return redirect()->route('accounts.index')->with('success', 'Conta atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        // Verificar se a conta pertence ao usuário
        if ($account->user_id !== Auth::id()) {
            abort(403);
        }

        // Verificar se há transações associadas
        $transactionCount = Transaction::where('account_id', $account->id)->count();
        if ($transactionCount > 0) {
            return redirect()->route('accounts.index')->with('error', "Não é possível excluir a conta '{$account->name}' porque ela possui {$transactionCount} transação(ões) associada(s). Para excluir esta conta, você precisa primeiro transferir ou excluir todas as transações relacionadas.");
        }

        $account->delete();

        return redirect()->route('accounts.index')->with('success', 'Conta excluída com sucesso!');
    }

    /**
     * Show transactions for a specific account
     */
    public function transactions(Account $account)
    {
        // Verificar se a conta pertence ao usuário
        if ($account->user_id !== Auth::id()) {
            abort(403);
        }

        $transactions = Transaction::where('account_id', $account->id)
            ->where('user_id', Auth::id())
            ->where('is_recurring', false)
            ->orderBy('date', 'desc')
            ->get();

        return view('accounts.transactions', compact('account', 'transactions'));
    }
}
