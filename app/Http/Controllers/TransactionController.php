<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = Transaction::with(['category', 'account', 'transferAccount'])
            ->where('user_id', $user->id);
        
        // Filtros
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        if ($request->filled('account_id')) {
            $query->where('account_id', $request->account_id);
        }
        
        $transactions = $query->orderBy('date', 'desc')->orderBy('id', 'desc')->paginate(15);
        
        // Dados para filtros
        $categories = Category::where('user_id', $user->id)->orderBy('name')->get();
        $accounts = Account::where('user_id', $user->id)->where('is_active', true)->orderBy('name')->get();
        
        return view('transactions.index', compact('transactions', 'categories', 'accounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('transactions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense,transfer',
            'date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'account_id' => 'required|exists:accounts,id',
            'transfer_account_id' => 'nullable|exists:accounts,id|different:account_id',
            'notes' => 'nullable|string|max:1000',
            'reference' => 'nullable|string|max:255',
            'is_recurring' => 'boolean',
            'recurring_frequency' => 'nullable|in:weekly,monthly,yearly',
            'recurring_end_date' => 'nullable|date|after:date',
            'debt_id' => 'nullable|exists:debts,id',
        ]);
        
        // Verificar se as categorias e contas pertencem ao usuário
        $category = Category::where('id', $validated['category_id'])->where('user_id', $user->id)->first();
        $account = Account::where('id', $validated['account_id'])->where('user_id', $user->id)->first();
        
        if (!$category || !$account) {
            return back()->withErrors(['error' => 'Categoria ou conta inválida.']);
        }
        
        if (isset($validated['transfer_account_id'])) {
            $transferAccount = Account::where('id', $validated['transfer_account_id'])->where('user_id', $user->id)->first();
            if (!$transferAccount) {
                return back()->withErrors(['error' => 'Conta de destino inválida.']);
            }
        }
        
        $validated['user_id'] = $user->id;
        $validated['is_recurring'] = $request->has('is_recurring');
        
        $transaction = Transaction::create($validated);
        
        // Se a transação estiver vinculada a uma dívida negociada, registrar pagamento
        if (!empty($validated['debt_id'])) {
            $debt = \App\Models\Debt::find($validated['debt_id']);
            if ($debt) {
                $balanceBefore = $debt->current_balance;
                $amount = $validated['amount'];
                $debtPayment = \App\Models\DebtPayment::create([
                    'debt_id' => $debt->id,
                    'user_id' => $user->id,
                    'account_id' => $validated['account_id'],
                    'amount' => $amount,
                    'payment_date' => $validated['date'],
                    'payment_type' => 'regular',
                    'notes' => $validated['description'],
                    'balance_before' => $balanceBefore,
                    'balance_after' => $balanceBefore - $amount,
                    'interest_paid' => 0,
                    'principal_paid' => $amount,
                    'is_scheduled' => false,
                ]);
                // Atualizar saldo da dívida
                $debt->current_balance = max(0, $balanceBefore - $amount);
                $debt->save();
            }
        }
        
        return redirect()->route('transactions.index')
            ->with('success', 'Transação criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $user = Auth::user();
        
        // Verificar se a transação pertence ao usuário
        if ($transaction->user_id !== $user->id) {
            abort(403);
        }
        
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        $user = Auth::user();
        
        // Verificar se a transação pertence ao usuário
        if ($transaction->user_id !== $user->id) {
            abort(403);
        }
        
        return view('transactions.edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $user = Auth::user();
        
        // Verificar se a transação pertence ao usuário
        if ($transaction->user_id !== $user->id) {
            abort(403);
        }
        
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense,transfer',
            'date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'account_id' => 'required|exists:accounts,id',
            'transfer_account_id' => 'nullable|exists:accounts,id|different:account_id',
            'notes' => 'nullable|string|max:1000',
            'reference' => 'nullable|string|max:255',
            'is_recurring' => 'boolean',
            'recurring_frequency' => 'nullable|in:weekly,monthly,yearly',
            'recurring_end_date' => 'nullable|date|after:date',
            'debt_id' => 'nullable|exists:debts,id',
        ]);
        
        // Verificar se as categorias e contas pertencem ao usuário
        $category = Category::where('id', $validated['category_id'])->where('user_id', $user->id)->first();
        $account = Account::where('id', $validated['account_id'])->where('user_id', $user->id)->first();
        
        if (!$category || !$account) {
            return back()->withErrors(['error' => 'Categoria ou conta inválida.']);
        }
        
        if (isset($validated['transfer_account_id'])) {
            $transferAccount = Account::where('id', $validated['transfer_account_id'])->where('user_id', $user->id)->first();
            if (!$transferAccount) {
                return back()->withErrors(['error' => 'Conta de destino inválida.']);
            }
        }
        
        $validated['is_recurring'] = $request->has('is_recurring');
        
        $transaction->update($validated);
        
        // Se a transação estiver vinculada a uma dívida negociada, registrar pagamento
        if (!empty($validated['debt_id'])) {
            $debt = \App\Models\Debt::find($validated['debt_id']);
            if ($debt) {
                $balanceBefore = $debt->current_balance;
                $amount = $validated['amount'];
                $debtPayment = \App\Models\DebtPayment::create([
                    'debt_id' => $debt->id,
                    'user_id' => $user->id,
                    'account_id' => $validated['account_id'],
                    'amount' => $amount,
                    'payment_date' => $validated['date'],
                    'payment_type' => 'regular',
                    'notes' => $validated['description'],
                    'balance_before' => $balanceBefore,
                    'balance_after' => $balanceBefore - $amount,
                    'interest_paid' => 0,
                    'principal_paid' => $amount,
                    'is_scheduled' => false,
                ]);
                // Atualizar saldo da dívida
                $debt->current_balance = max(0, $balanceBefore - $amount);
                $debt->save();
            }
        }
        
        return redirect()->route('transactions.index')
            ->with('success', 'Transação atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $user = Auth::user();
        
        // Verificar se a transação pertence ao usuário
        if ($transaction->user_id !== $user->id) {
            abort(403);
        }
        
        // Excluir contribuição vinculada (se houver)
        \App\Models\GoalContribution::where('transaction_id', $transaction->id)->delete();

        $transaction->delete();
        
        return redirect()->route('transactions.index')
            ->with('success', 'Transação excluída com sucesso!');
    }
}
