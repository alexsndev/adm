<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relações financeiras
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function accounts(): HasMany
    {
        return $this->hasMany(Account::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }

    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class);
    }

    public function debts(): HasMany
    {
        return $this->hasMany(Debt::class);
    }

    public function financialGoals(): HasMany
    {
        return $this->hasMany(FinancialGoal::class);
    }

    public function debtPayments(): HasMany
    {
        return $this->hasMany(DebtPayment::class);
    }

    public function creditCards(): HasMany
    {
        return $this->hasMany(CreditCard::class);
    }

    public function goalContributions(): HasMany
    {
        return $this->hasMany(GoalContribution::class);
    }

    // Métodos úteis para dashboard
    public function getTotalBalanceAttribute()
    {
        return $this->accounts()->active()->sum('current_balance');
    }

    /**
     * Retorna a soma das receitas do usuário para um mês/ano, opcionalmente filtrando por conta.
     *
     * @param int|null $year Ano desejado (padrão: atual)
     * @param int|null $month Mês desejado (padrão: atual)
     * @param int|null $accountId ID da conta para filtrar (opcional)
     * @return float
     */
    public function getMonthlyIncome($year = null, $month = null, $accountId = null)
    {
        $date = now();
        $year = $year ?? (int) $date->format('Y');
        $month = $month ?? (int) $date->format('m');
        $month = max(1, min(12, (int) $month));

        $query = $this->transactions()->income()->forMonth($year, $month);
        if ($accountId) {
            $query->where('account_id', $accountId);
        }
        return (float) $query->sum('amount');
    }

    /**
     * Retorna a soma das despesas do usuário para um mês/ano, opcionalmente filtrando por conta.
     *
     * @param int|null $year Ano desejado (padrão: atual)
     * @param int|null $month Mês desejado (padrão: atual)
     * @param int|null $accountId ID da conta para filtrar (opcional)
     * @return float
     */
    public function getMonthlyExpenses($year = null, $month = null, $accountId = null)
    {
        $date = now();
        $year = $year ?? (int) $date->format('Y');
        $month = $month ?? (int) $date->format('m');
        $month = max(1, min(12, (int) $month));

        $query = $this->transactions()->expense()->forMonth($year, $month);
        if ($accountId) {
            $query->where('account_id', $accountId);
        }
        return (float) $query->sum('amount');
    }

    /**
     * Retorna o saldo mensal (receitas - despesas) para um mês/ano, opcionalmente filtrando por conta.
     *
     * @param int|null $year
     * @param int|null $month
     * @param int|null $accountId
     * @return float
     */
    public function getMonthlyBalance($year = null, $month = null, $accountId = null)
    {
        return $this->getMonthlyIncome($year, $month, $accountId) - $this->getMonthlyExpenses($year, $month, $accountId);
    }
}
