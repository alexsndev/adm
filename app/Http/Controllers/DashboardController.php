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
        // Envia uma notificação de exemplo se o usuário não tiver nenhuma
        if ($user->notifications()->count() === 0) {
            $user->notify(new \App\Notifications\GenericDashboardNotification(
                'Bem-vindo ao sistema!',
                'Este é um exemplo de notificação. Aproveite para explorar o painel!',
                'info',
                url('/dashboard'),
                'bell',
                '#2563eb'
            ));
        }
        
        // Buscar contas do usuário
        $accounts = Account::where('user_id', $user->id)->get();
        
        // Calcular saldo total
        $totalBalance = $accounts->sum('current_balance');
        
        // Buscar transações do mês atual (apenas reais)
        $currentMonth = Carbon::now()->startOfMonth();
        $monthlyTransactions = Transaction::where('user_id', $user->id)
            ->where('is_recurring', false)
            ->whereMonth('date', $currentMonth->month)
            ->whereYear('date', $currentMonth->year)
            ->get();
        
        // Calcular receitas e despesas do mês diretamente no banco (apenas reais)
        $monthlyIncome = Transaction::where('user_id', $user->id)
            ->where('is_recurring', false)
            ->whereMonth('date', $currentMonth->month)
            ->whereYear('date', $currentMonth->year)
            ->where('type', 'income')
            ->sum('amount');

        $monthlyExpenses = Transaction::where('user_id', $user->id)
            ->where('is_recurring', false)
            ->whereMonth('date', $currentMonth->month)
            ->whereYear('date', $currentMonth->year)
            ->where('type', 'expense')
            ->sum('amount');
        
        // Total de transações (apenas reais)
        $totalTransactions = Transaction::where('user_id', $user->id)
            ->where('is_recurring', false)
            ->count();
        
        // Transações recentes (apenas reais)
        $recentTransactions = Transaction::where('user_id', $user->id)
            ->where('is_recurring', false)
            ->with('category', 'account')
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->take(10)
            ->get();
        
        // Buscar próximos 4 aniversariantes (usuários com birthdate nos próximos dias)
        $today = Carbon::today();
        $nextBirthdays = \App\Models\User::whereNotNull('birthdate')
            ->get()
            ->sortBy(function($u) use ($today) {
                $birth = Carbon::parse($u->birthdate)->setYear($today->year);
                if ($birth->lt($today)) {
                    $birth->addYear();
                }
                return $birth->diffInDays($today);
            })
            ->take(4);
        
        // Garantir que todos os eventos ativos (não aniversários) tenham ocorrências futuras
        $futureStart = $today;
        $futureEnd = $today->copy()->addDays(30);
        $eventos = \App\Models\Event::where('is_active', true)
            ->whereNotIn('type', ['birthday', 'anniversary'])
            ->get();
        foreach ($eventos as $evento) {
            $evento->generateOccurrences($futureStart, $futureEnd);
        }
        
        // Buscar próximos 4 eventos (que não sejam aniversários)
        $nextEvents = \App\Models\EventOccurrence::with('event')
            ->where('occurrence_date', '>=', $today->format('Y-m-d'))
            ->whereHas('event', function($q) {
                $q->whereNotIn('type', ['birthday', 'anniversary']);
            })
            ->orderBy('occurrence_date')
            ->orderBy('occurrence_time')
            ->take(4)
            ->get();
        
        // Buscar próximos 10 feriados (eventos do tipo 'holiday')
        $nextHolidays = \App\Models\EventOccurrence::with('event')
            ->where('occurrence_date', '>=', $today->format('Y-m-d'))
            ->whereHas('event', function($q) {
                $q->where('type', 'holiday');
            })
            ->orderBy('occurrence_date')
            ->take(10)
            ->get();
        
        // Buscar metas do usuário
        $goals = \App\Models\Goal::where('user_id', $user->id)->orderBy('created_at', 'desc')->take(4)->get();
        // Buscar dívidas do usuário
        $debts = \App\Models\Debt::where('user_id', $user->id)->orderBy('created_at', 'desc')->take(4)->get();
        
        // Buscar receitas fixas ordenadas por data do mês
        $fixedIncomes = Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->where('is_recurring', true)
            ->with('category', 'account')
            ->orderByRaw('DAY(date) ASC')
            ->take(6)
            ->get();
        
        // Buscar despesas fixas ordenadas por data do mês
        $fixedExpenses = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->where('is_recurring', true)
            ->with('category', 'account')
            ->orderByRaw('DAY(date) ASC')
            ->take(6)
            ->get();
        
        return view('dashboard', compact(
            'accounts',
            'totalBalance',
            'monthlyIncome',
            'monthlyExpenses',
            'totalTransactions',
            'recentTransactions',
            'nextBirthdays',
            'nextEvents',
            'nextHolidays',
            'goals',
            'debts',
            'fixedIncomes',
            'fixedExpenses'
        ));
    }
} 