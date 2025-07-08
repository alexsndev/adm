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
        $totalReceitas = Transaction::where('type', 'income')->sum('amount');
        $totalDespesas = Transaction::where('type', 'expense')->sum('amount');
        $saldoTotal = $totalReceitas - $totalDespesas;
        $totalContas = Account::count();
        $totalCartoes = CreditCard::count();
        $totalDividas = Debt::count();
        $totalMetas = FinancialGoal::count();

        return view('finance.dashboard', [
            'saldoTotal' => $saldoTotal,
            'totalReceitas' => $totalReceitas,
            'totalDespesas' => $totalDespesas,
            'totalContas' => $totalContas,
            'totalCartoes' => $totalCartoes,
            'totalDividas' => $totalDividas,
            'totalMetas' => $totalMetas,
        ]);
    }
} 