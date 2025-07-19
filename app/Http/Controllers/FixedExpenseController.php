<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FixedExpenseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $despesasFixas = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->where('is_recurring', true)
            ->orderBy('date')
            ->get();
        return view('finance.fixed-expenses.index', compact('despesasFixas'));
    }

    public function create()
    {
        $categorias = Category::where('user_id', Auth::id())->where('type', 'expense')->get();
        $contas = Account::where('user_id', Auth::id())->get();
        return view('finance.fixed-expenses.create', compact('categorias', 'contas'));
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
        $validated['type'] = 'expense';
        $validated['is_recurring'] = true;
        Transaction::create($validated);
        return redirect()->route('finance.fixed-expenses.index')->with('success', 'Despesa fixa cadastrada!');
    }

    public function edit($id)
    {
        $despesa = Transaction::where('id', $id)->where('user_id', Auth::id())->where('type', 'expense')->where('is_recurring', true)->firstOrFail();
        $categorias = Category::where('user_id', Auth::id())->where('type', 'expense')->get();
        $contas = Account::where('user_id', Auth::id())->get();
        return view('finance.fixed-expenses.edit', compact('despesa', 'categorias', 'contas'));
    }

    public function update(Request $request, $id)
    {
        $despesa = Transaction::where('id', $id)->where('user_id', Auth::id())->where('type', 'expense')->where('is_recurring', true)->firstOrFail();
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
        $despesa->update($validated);
        return redirect()->route('finance.fixed-expenses.index')->with('success', 'Despesa fixa atualizada!');
    }

    public function destroy($id)
    {
        $despesa = Transaction::where('id', $id)->where('user_id', Auth::id())->where('type', 'expense')->where('is_recurring', true)->firstOrFail();
        $despesa->delete();
        return redirect()->route('finance.fixed-expenses.index')->with('success', 'Despesa fixa removida!');
    }

    public function pay(Request $request, $id)
    {
        $despesa = Transaction::where('id', $id)->where('user_id', Auth::id())->where('type', 'expense')->where('is_recurring', true)->firstOrFail();
        $mes = $request->input('mes', now()->format('Y-m'));
        [$ano, $mesNum] = explode('-', $mes);
        $dataPagamento = \Carbon\Carbon::create($ano, $mesNum, \Carbon\Carbon::parse($despesa->date)->day);
        // Evita duplicidade
        $existe = Transaction::where('user_id', $despesa->user_id)
            ->where('type', 'expense')
            ->where('is_recurring', false)
            ->where('description', 'like', $despesa->description.'%')
            ->whereYear('date', $ano)
            ->whereMonth('date', $mesNum)
            ->exists();
        if (!$existe) {
            Transaction::create([
                'description' => $despesa->description . ' (Paga)',
                'amount' => $despesa->amount,
                'type' => 'expense',
                'date' => $dataPagamento->toDateString(),
                'category_id' => $despesa->category_id,
                'account_id' => $despesa->account_id,
                'user_id' => $despesa->user_id,
                'is_recurring' => false,
                'notes' => 'Paga automaticamente da despesa fixa',
            ]);
        }
        return redirect()->back()->with('success', 'Despesa paga e lançada nas transações!');
    }

    public function unpay(Request $request, $id)
    {
        $despesa = Transaction::where('id', $id)->where('user_id', Auth::id())->where('type', 'expense')->where('is_recurring', true)->firstOrFail();
        $mes = $request->input('mes', now()->format('Y-m'));
        [$ano, $mesNum] = explode('-', $mes);
        $dataPagamento = \Carbon\Carbon::create($ano, $mesNum, \Carbon\Carbon::parse($despesa->date)->day);
        // Remove a transação paga desse mês
        $transacao = Transaction::where('user_id', $despesa->user_id)
            ->where('type', 'expense')
            ->where('is_recurring', false)
            ->where('description', 'like', $despesa->description.'%')
            ->whereYear('date', $ano)
            ->whereMonth('date', $mesNum)
            ->first();
        if ($transacao) {
            $transacao->delete();
        }
        return redirect()->back()->with('success', 'Pagamento desfeito e removido das transações!');
    }
} 