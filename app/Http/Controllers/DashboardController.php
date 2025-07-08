<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Buscar contas do usuário
        $accounts = Account::where('user_id', $user->id)->get();
        
        // Calcular saldo total
        $totalBalance = $accounts->sum('current_balance');
        
        // Buscar transações do mês atual
        $currentMonth = Carbon::now()->startOfMonth();
        $monthlyTransactions = Transaction::where('user_id', $user->id)
            ->whereMonth('date', $currentMonth->month)
            ->whereYear('date', $currentMonth->year)
            ->get();
        
        // Calcular receitas e despesas do mês diretamente no banco
        $monthlyIncome = Transaction::where('user_id', $user->id)
            ->whereMonth('date', $currentMonth->month)
            ->whereYear('date', $currentMonth->year)
            ->where('type', 'income')
            ->sum('amount');

        $monthlyExpenses = Transaction::where('user_id', $user->id)
            ->whereMonth('date', $currentMonth->month)
            ->whereYear('date', $currentMonth->year)
            ->where('type', 'expense')
            ->sum('amount');
        
        // Total de transações
        $totalTransactions = Transaction::where('user_id', $user->id)->count();
        
        // Transações recentes
        $recentTransactions = Transaction::where('user_id', $user->id)
            ->with('category', 'account')
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();
        
        return view('dashboard', compact(
            'accounts',
            'totalBalance',
            'monthlyIncome',
            'monthlyExpenses',
            'totalTransactions',
            'recentTransactions'
        ));
    }
} 