<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\CreditCard;
use App\Models\Debt;
use App\Models\FinancialGoal;

class FinanceDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Buscar dados filtrados por usuário
        $totalReceitas = Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->sum('amount');
            
        $totalDespesas = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->sum('amount');
            
        $saldoTotal = $totalReceitas - $totalDespesas;
        $totalContas = Account::where('user_id', $user->id)->count();
        $totalCartoes = CreditCard::where('user_id', $user->id)->count();
        $totalDividas = Debt::where('user_id', $user->id)->count();
        $totalMetas = FinancialGoal::where('user_id', $user->id)->count();

        // Top 5 categorias de maior gasto
        $gastosPorCategoria = Transaction::selectRaw('category_id, SUM(amount) as total')
            ->where('user_id', $user->id)
            ->where('type', 'expense')
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->with('category')
            ->take(5)
            ->get();

        return view('finance.dashboard', [
            'saldoTotal' => number_format($saldoTotal, 2, ',', '.'),
            'totalReceitas' => number_format($totalReceitas, 2, ',', '.'),
            'totalDespesas' => number_format($totalDespesas, 2, ',', '.'),
            'totalReceitasNum' => $totalReceitas,
            'totalDespesasNum' => $totalDespesas,
            'totalContas' => $totalContas,
            'totalCartoes' => $totalCartoes,
            'totalDividas' => $totalDividas,
            'totalMetas' => $totalMetas,
            'gastosPorCategoria' => $gastosPorCategoria,
        ]);
    }
} 