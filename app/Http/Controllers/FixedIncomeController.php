<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class FixedIncomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $receitasFixas = Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->where('is_recurring', true)
            ->orderBy('date')
            ->get();
        return view('finance.fixed-incomes.index', compact('receitasFixas'));
    }

    public function create()
    {
        $categorias = Category::where('user_id', Auth::id())->where('type', 'income')->get();
        $contas = Account::where('user_id', Auth::id())->get();
        return view('finance.fixed-incomes.create', compact('categorias', 'contas'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'account_id' => 'required|exists:accounts,id',
            'recurring_frequency' => 'required|in:weekly,monthly,yearly',
            'recurring_end_date' => 'nullable|date|after:date',
            'notes' => 'nullable|string|max:1000',
        ]);
        $validated['user_id'] = $user->id;
        $validated['type'] = 'income';
        $validated['is_recurring'] = true;
        Transaction::create($validated);
        return redirect()->route('finance.fixed-incomes.index')->with('success', 'Receita fixa cadastrada!');
    }

    public function edit($id)
    {
        $receita = Transaction::where('id', $id)->where('user_id', Auth::id())->where('type', 'income')->where('is_recurring', true)->firstOrFail();
        $categorias = Category::where('user_id', Auth::id())->where('type', 'income')->get();
        $contas = Account::where('user_id', Auth::id())->get();
        return view('finance.fixed-incomes.edit', compact('receita', 'categorias', 'contas'));
    }

    public function update(Request $request, $id)
    {
        $receita = Transaction::where('id', $id)->where('user_id', Auth::id())->where('type', 'income')->where('is_recurring', true)->firstOrFail();
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'account_id' => 'required|exists:accounts,id',
            'recurring_frequency' => 'required|in:weekly,monthly,yearly',
            'recurring_end_date' => 'nullable|date|after:date',
            'notes' => 'nullable|string|max:1000',
        ]);
        $validated['is_recurring'] = true;
        $receita->update($validated);
        return redirect()->route('finance.fixed-incomes.index')->with('success', 'Receita fixa atualizada!');
    }

    public function destroy($id)
    {
        $receita = Transaction::where('id', $id)->where('user_id', Auth::id())->where('type', 'income')->where('is_recurring', true)->firstOrFail();
        $receita->delete();
        return redirect()->route('finance.fixed-incomes.index')->with('success', 'Receita fixa removida!');
    }

    public function receive($id)
    {
        $receita = Transaction::where('id', $id)->where('user_id', Auth::id())->where('type', 'income')->where('is_recurring', true)->firstOrFail();
        // Cria uma transação de income para o mês atual
        Transaction::create([
            'description' => $receita->description . ' (Recebido)',
            'amount' => $receita->amount,
            'type' => 'income',
            'date' => Carbon::now()->toDateString(),
            'category_id' => $receita->category_id,
            'account_id' => $receita->account_id,
            'user_id' => $receita->user_id,
            'is_recurring' => false,
            'notes' => 'Recebido automaticamente da receita fixa',
        ]);
        return redirect()->route('finance.fixed-incomes.index')->with('success', 'Receita recebida e lançada nas transações!');
    }
} 