<?php

namespace App\Services;

use App\Models\User;
use App\Models\Account;
use App\Models\Transaction;
use App\Models\Event;
use App\Models\EventOccurrence;
use App\Models\Goal;
use App\Models\Debt;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class DashboardService
{
    public function getDashboardData(User $user): array
    {
        $cacheKey = "dashboard_data_user_{$user->id}";
        
        return Cache::remember($cacheKey, 300, function () use ($user) {
            return [
                'accounts' => $this->getAccounts($user),
                'totalBalance' => $this->getTotalBalance($user),
                'monthlyStats' => $this->getMonthlyStats($user),
                'totalTransactions' => $this->getTotalTransactions($user),
                'recentTransactions' => $this->getRecentTransactions($user),
                'nextBirthdays' => $this->getNextBirthdays($user),
                'nextEvents' => $this->getNextEvents($user),
                'nextHolidays' => $this->getNextHolidays($user),
                'goals' => $this->getGoals($user),
                'debts' => $this->getDebts($user),
            ];
        });
    }

    private function getAccounts(User $user): \Illuminate\Database\Eloquent\Collection
    {
        return Cache::remember("user_{$user->id}_accounts", 600, function () use ($user) {
            return Account::where('user_id', $user->id)->get();
        });
    }

    private function getTotalBalance(User $user): float
    {
        return Cache::remember("user_{$user->id}_total_balance", 300, function () use ($user) {
            return Account::where('user_id', $user->id)
                ->where('is_active', true)
                ->sum('current_balance');
        });
    }

    private function getMonthlyStats(User $user): array
    {
        $currentMonth = Carbon::now()->startOfMonth();
        $cacheKey = "user_{$user->id}_monthly_stats_{$currentMonth->format('Y_m')}";
        
        return Cache::remember($cacheKey, 300, function () use ($user, $currentMonth) {
            $income = Transaction::where('user_id', $user->id)
                ->whereYear('date', $currentMonth->year)
                ->whereMonth('date', $currentMonth->month)
                ->where('type', 'income')
                ->sum('amount');

            $expenses = Transaction::where('user_id', $user->id)
                ->whereYear('date', $currentMonth->year)
                ->whereMonth('date', $currentMonth->month)
                ->where('type', 'expense')
                ->sum('amount');

            return [
                'income' => $income,
                'expenses' => $expenses,
                'balance' => $income - $expenses,
            ];
        });
    }

    private function getTotalTransactions(User $user): int
    {
        return Cache::remember("user_{$user->id}_total_transactions", 600, function () use ($user) {
            return Transaction::where('user_id', $user->id)->count();
        });
    }

    private function getRecentTransactions(User $user): \Illuminate\Database\Eloquent\Collection
    {
        return Cache::remember("user_{$user->id}_recent_transactions", 300, function () use ($user) {
            return Transaction::with(['category', 'account'])
                ->where('user_id', $user->id)
                ->orderBy('date', 'desc')
                ->orderBy('id', 'desc')
                ->take(10)
                ->get();
        });
    }

    private function getNextBirthdays(User $user): \Illuminate\Database\Eloquent\Collection
    {
        return Cache::remember("user_{$user->id}_next_birthdays", 3600, function () use ($user) {
            $today = Carbon::today();
            
            return User::whereNotNull('birthdate')
                ->get()
                ->sortBy(function($u) use ($today) {
                    $birth = Carbon::parse($u->birthdate)->setYear($today->year);
                    if ($birth->lt($today)) {
                        $birth->addYear();
                    }
                    return $birth->diffInDays($today);
                })
                ->take(4);
        });
    }

    private function getNextEvents(User $user): \Illuminate\Database\Eloquent\Collection
    {
        return Cache::remember("user_{$user->id}_next_events", 1800, function () use ($user) {
            $today = Carbon::today();
            $futureStart = $today;
            $futureEnd = $today->copy()->addDays(30);
            
            // Garantir que eventos ativos tenham ocorrências futuras
            $eventos = Event::where('is_active', true)
                ->whereNotIn('type', ['birthday', 'anniversary'])
                ->get();
                
            foreach ($eventos as $evento) {
                $evento->generateOccurrences($futureStart, $futureEnd);
            }
            
            return EventOccurrence::with('event')
                ->where('occurrence_date', '>=', $today->format('Y-m-d'))
                ->whereHas('event', function($q) {
                    $q->whereNotIn('type', ['birthday', 'anniversary']);
                })
                ->orderBy('occurrence_date')
                ->orderBy('occurrence_time')
                ->take(4)
                ->get();
        });
    }

    private function getNextHolidays(User $user): \Illuminate\Database\Eloquent\Collection
    {
        return Cache::remember("user_{$user->id}_next_holidays", 3600, function () use ($user) {
            $today = Carbon::today();
            
            return EventOccurrence::with('event')
                ->where('occurrence_date', '>=', $today->format('Y-m-d'))
                ->whereHas('event', function($q) {
                    $q->where('type', 'holiday');
                })
                ->orderBy('occurrence_date')
                ->take(10)
                ->get();
        });
    }

    private function getGoals(User $user): \Illuminate\Database\Eloquent\Collection
    {
        return Cache::remember("user_{$user->id}_goals", 1800, function () use ($user) {
            return Goal::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->take(4)
                ->get();
        });
    }

    private function getDebts(User $user): \Illuminate\Database\Eloquent\Collection
    {
        return Cache::remember("user_{$user->id}_debts", 1800, function () use ($user) {
            return Debt::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->take(4)
                ->get();
        });
    }

    public function clearUserCache(int $userId): void
    {
        $patterns = [
            "dashboard_data_user_{$userId}",
            "user_{$userId}_accounts",
            "user_{$userId}_total_balance",
            "user_{$userId}_monthly_stats_*",
            "user_{$userId}_total_transactions",
            "user_{$userId}_recent_transactions",
            "user_{$userId}_next_birthdays",
            "user_{$userId}_next_events",
            "user_{$userId}_next_holidays",
            "user_{$userId}_goals",
            "user_{$userId}_debts",
        ];

        foreach ($patterns as $pattern) {
            Cache::flush($pattern);
        }
    }
} 