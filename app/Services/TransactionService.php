<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Category;
use App\Models\Account;
use App\Models\Debt;
use App\Models\DebtPayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class TransactionService
{
    public function createTransaction(array $data, User $user): Transaction
    {
        return DB::transaction(function () use ($data, $user) {
            // Validar se categoria e conta pertencem ao usuário
            $category = Category::where('id', $data['category_id'])
                ->where('user_id', $user->id)
                ->firstOrFail();

            $account = Account::where('id', $data['account_id'])
                ->where('user_id', $user->id)
                ->firstOrFail();

            // Validar conta de transferência se aplicável
            if (isset($data['transfer_account_id'])) {
                $transferAccount = Account::where('id', $data['transfer_account_id'])
                    ->where('user_id', $user->id)
                    ->firstOrFail();
            }

            // Criar transação
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'description' => $data['description'],
                'amount' => $data['amount'],
                'type' => $data['type'],
                'date' => $data['date'],
                'category_id' => $category->id,
                'account_id' => $account->id,
                'transfer_account_id' => $data['transfer_account_id'] ?? null,
                'notes' => $data['notes'] ?? null,
                'reference' => $data['reference'] ?? null,
                'is_recurring' => $data['is_recurring'] ?? false,
                'recurring_frequency' => $data['recurring_frequency'] ?? null,
                'recurring_end_date' => $data['recurring_end_date'] ?? null,
                'debt_id' => $data['debt_id'] ?? null,
            ]);

            // Processar pagamento de dívida se aplicável
            if (!empty($data['debt_id'])) {
                $this->processDebtPayment($transaction, $data);
            }

            // Limpar cache
            $this->clearUserCache($user->id);

            return $transaction;
        });
    }

    public function updateTransaction(Transaction $transaction, array $data, User $user): Transaction
    {
        return DB::transaction(function () use ($transaction, $data, $user) {
            // Verificar autorização
            if ($transaction->user_id !== $user->id) {
                abort(403, 'Não autorizado');
            }

            // Validar se categoria e conta pertencem ao usuário
            $category = Category::where('id', $data['category_id'])
                ->where('user_id', $user->id)
                ->firstOrFail();

            $account = Account::where('id', $data['account_id'])
                ->where('user_id', $user->id)
                ->firstOrFail();

            // Validar conta de transferência se aplicável
            if (isset($data['transfer_account_id'])) {
                $transferAccount = Account::where('id', $data['transfer_account_id'])
                    ->where('user_id', $user->id)
                    ->firstOrFail();
            }

            // Atualizar transação
            $transaction->update([
                'description' => $data['description'],
                'amount' => $data['amount'],
                'type' => $data['type'],
                'date' => $data['date'],
                'category_id' => $category->id,
                'account_id' => $account->id,
                'transfer_account_id' => $data['transfer_account_id'] ?? null,
                'notes' => $data['notes'] ?? null,
                'reference' => $data['reference'] ?? null,
                'is_recurring' => $data['is_recurring'] ?? false,
                'recurring_frequency' => $data['recurring_frequency'] ?? null,
                'recurring_end_date' => $data['recurring_end_date'] ?? null,
                'debt_id' => $data['debt_id'] ?? null,
            ]);

            // Limpar cache
            $this->clearUserCache($user->id);

            return $transaction;
        });
    }

    public function deleteTransaction(Transaction $transaction, User $user): bool
    {
        // Verificar autorização
        if ($transaction->user_id !== $user->id) {
            abort(403, 'Não autorizado');
        }

        $deleted = $transaction->delete();

        if ($deleted) {
            $this->clearUserCache($user->id);
        }

        return $deleted;
    }

    public function getMonthlyStats(User $user, int $year = null, int $month = null): array
    {
        $year = $year ?? now()->year;
        $month = $month ?? now()->month;

        $cacheKey = "user_{$user->id}_stats_{$year}_{$month}";

        return Cache::remember($cacheKey, 300, function () use ($user, $year, $month) {
            $income = Transaction::where('user_id', $user->id)
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->where('type', 'income')
                ->sum('amount');

            $expenses = Transaction::where('user_id', $user->id)
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->where('type', 'expense')
                ->sum('amount');

            return [
                'income' => $income,
                'expenses' => $expenses,
                'balance' => $income - $expenses,
            ];
        });
    }

    public function getRecentTransactions(User $user, int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        $cacheKey = "user_{$user->id}_recent_transactions_{$limit}";

        return Cache::remember($cacheKey, 300, function () use ($user, $limit) {
            return Transaction::with(['category', 'account'])
                ->where('user_id', $user->id)
                ->orderBy('date', 'desc')
                ->orderBy('id', 'desc')
                ->take($limit)
                ->get();
        });
    }

    private function processDebtPayment(Transaction $transaction, array $data): void
    {
        $debt = Debt::find($data['debt_id']);
        if (!$debt || $debt->user_id !== $transaction->user_id) {
            return;
        }

        $amount = $data['amount'];

        // Criar pagamento da dívida
        DebtPayment::create([
            'debt_id' => $debt->id,
            'amount' => $amount,
            'payment_date' => $data['date'],
            'account_id' => $data['account_id'],
            'notes' => $data['description'],
        ]);

        // Atualizar saldo da dívida
        $debt->update([
            'current_balance' => $debt->current_balance - $amount,
        ]);
    }

    private function clearUserCache(int $userId): void
    {
        $patterns = [
            "user_{$userId}_stats_*",
            "user_{$userId}_recent_transactions_*",
        ];

        foreach ($patterns as $pattern) {
            Cache::flush($pattern);
        }
    }
} 