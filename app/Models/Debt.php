<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Debt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_id',
        'credit_card_id',
        'name',
        'description',
        'original_amount',
        'current_balance',
        'interest_rate',
        'priority',
        'status',
        'due_date',
        'start_date',
        'creditor_name',
        'creditor_contact',
        'contract_number',
        'debt_type',
        'is_consolidated',
        'payment_history',
        'negotiated_amount',
        'installments',
        'installment_amount',
        'agreement_date',
        'is_negotiated',
        'first_payment_date',
        'iof_rate',
    ];

    protected $casts = [
        'original_amount' => 'decimal:2',
        'current_balance' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'due_date' => 'date',
        'start_date' => 'date',
        'is_consolidated' => 'boolean',
        'payment_history' => 'array',
        'negotiated_amount' => 'decimal:2',
        'installment_amount' => 'decimal:2',
        'agreement_date' => 'date',
        'is_negotiated' => 'boolean',
        'iof_rate' => 'decimal:4',
    ];

    // Relações
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public function creditCard(): BelongsTo
    {
        return $this->belongsTo(CreditCard::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(DebtPayment::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())->where('status', 'active');
    }

    // Métodos úteis
    public function getTotalPaidAttribute()
    {
        return $this->original_amount - $this->current_balance;
    }

    public function getProgressPercentageAttribute()
    {
        if ($this->original_amount <= 0) return 0;
        return min(100, ($this->getTotalPaidAttribute() / $this->original_amount) * 100);
    }

    public function getMonthlyInterestAttribute()
    {
        return $this->current_balance * ($this->interest_rate / 100);
    }

    public function getDaysUntilDueAttribute()
    {
        // Se for negociada e tiver data do primeiro pagamento, usar essa data como referência
        if ($this->is_negotiated && $this->first_payment_date) {
            $dataBase = $this->first_payment_date;
        } elseif ($this->is_negotiated && $this->agreement_date) {
            $dataBase = $this->agreement_date;
        } else {
            $dataBase = $this->due_date;
        }
        if (!$dataBase) return null;
        return \Carbon\Carbon::today()->diffInDays(\Carbon\Carbon::parse($dataBase), false);
    }

    public function getIsOverdueAttribute()
    {
        return $this->due_date && $this->due_date < now() && $this->status === 'active';
    }

    public function getRecommendedPaymentAttribute()
    {
        // Método da bola de neve: pagar o mínimo + extra para a dívida de maior prioridade
        $minimumPayment = $this->current_balance * 0.02; // 2% do saldo
        return max($minimumPayment, 100); // Mínimo de R$ 100
    }

    public function getTotalNegotiatedAmountAttribute()
    {
        if (!$this->is_negotiated || !$this->installments || !$this->installment_amount) {
            return $this->negotiated_amount ?? $this->original_amount;
        }
        
        return $this->installments * $this->installment_amount;
    }

    public function getNegotiationDiscountAttribute()
    {
        if (!$this->is_negotiated || !$this->negotiated_amount) {
            return 0;
        }
        
        return $this->original_amount - $this->negotiated_amount;
    }

    public function getNegotiationDiscountPercentageAttribute()
    {
        if (!$this->original_amount <= 0) return 0;
        return ($this->getNegotiationDiscountAttribute() / $this->original_amount) * 100;
    }

    public function getTotalCostIncreaseAttribute()
    {
        if (!$this->is_negotiated) return 0;
        
        $totalNegotiated = $this->getTotalNegotiatedAmountAttribute();
        return $totalNegotiated - $this->original_amount;
    }

    public function getDebtTypeLabelAttribute()
    {
        $types = [
            'credit_card' => 'Cartão de Crédito',
            'personal_loan' => 'Empréstimo Pessoal',
            'mortgage' => 'Financiamento Imobiliário',
            'car_loan' => 'Financiamento de Veículo',
            'student_loan' => 'Empréstimo Estudantil',
            'business_loan' => 'Empréstimo Empresarial',
            'other' => 'Outro',
        ];
        
        return $types[$this->debt_type] ?? 'Outro';
    }

    public function getPriorityLabelAttribute()
    {
        $priorities = [
            'low' => 'Baixa',
            'medium' => 'Média',
            'high' => 'Alta',
            'critical' => 'Crítica',
        ];
        
        return $priorities[$this->priority] ?? 'Média';
    }

    public function getPriorityColorAttribute()
    {
        $colors = [
            'low' => 'green',
            'medium' => 'yellow',
            'high' => 'orange',
            'critical' => 'red',
        ];
        
        return $colors[$this->priority] ?? 'yellow';
    }

    // Valor da parcela corrigida pelo atraso
    public function getCorrectedInstallmentAmountAttribute()
    {
        // Só faz sentido para dívidas negociadas e parceladas
        if (!$this->is_negotiated || !$this->installment_amount) {
            return null;
        }
        $valor = $this->installment_amount;
        $diasAtraso = 0;
        // Considera atraso apenas se já passou do vencimento da parcela atual
        if ($this->days_until_due < 0) {
            $diasAtraso = abs($this->days_until_due);
        }
        // Juros simples diário proporcional ao atraso
        if ($diasAtraso > 0 && $this->interest_rate > 0) {
            $jurosDiario = ($this->interest_rate / 100) / 30; // Aproximação de mês de 30 dias
            $valor += $valor * $jurosDiario * $diasAtraso;
        }
        // IOF diário (se configurado)
        if ($diasAtraso > 0 && $this->iof_rate > 0) {
            $valor += $valor * $this->iof_rate * $diasAtraso;
        }
        return $valor;
    }
}
