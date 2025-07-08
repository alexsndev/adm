<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class FinancialGoal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_id',
        'name',
        'description',
        'target_amount',
        'current_amount',
        'goal_type',
        'priority',
        'status',
        'target_date',
        'start_date',
        'monthly_contribution',
        'color',
        'icon',
        'milestones',
        'is_eco_friendly',
        'eco_impact_description',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'monthly_contribution' => 'decimal:2',
        'target_date' => 'date',
        'start_date' => 'date',
        'milestones' => 'array',
        'is_eco_friendly' => 'boolean',
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

    public function contributions()
    {
        return $this->hasMany(GoalContribution::class);
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

    public function scopeEcoFriendly($query)
    {
        return $query->where('is_eco_friendly', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('goal_type', $type);
    }

    // Métodos úteis
    public function getProgressPercentageAttribute()
    {
        if ($this->target_amount <= 0) return 0;
        return min(100, ($this->current_amount / $this->target_amount) * 100);
    }

    public function getRemainingAmountAttribute()
    {
        return $this->target_amount - $this->current_amount;
    }

    public function getTotalContributionsAttribute()
    {
        return $this->contributions()->sum('amount');
    }

    public function getLastContributionAttribute()
    {
        return $this->contributions()->latest('contribution_date')->first();
    }

    public function updateProgressFromContributions()
    {
        $totalContributions = $this->contributions()->sum('amount');
        $this->update(['current_amount' => $totalContributions]);
        
        // Verificar se a meta foi atingida
        if ($totalContributions >= $this->target_amount && $this->status === 'active') {
            $this->update(['status' => 'completed']);
        }
        
        return $this;
    }

    public function getDaysUntilTargetAttribute()
    {
        return Carbon::now()->diffInDays($this->target_date, false);
    }

    public function getIsOnTrackAttribute()
    {
        if ($this->target_date <= now()) return false;
        
        $daysElapsed = Carbon::now()->diffInDays($this->start_date);
        $totalDays = $this->start_date->diffInDays($this->target_date);
        
        if ($totalDays <= 0) return false;
        
        $expectedProgress = ($daysElapsed / $totalDays) * 100;
        return $this->getProgressPercentageAttribute() >= $expectedProgress;
    }

    public function getRecommendedMonthlyContributionAttribute()
    {
        $remainingAmount = $this->getRemainingAmountAttribute();
        $monthsRemaining = max(1, Carbon::now()->diffInMonths($this->target_date));
        
        return $remainingAmount / $monthsRemaining;
    }

    public function getGoalTypeLabelAttribute()
    {
        $types = [
            'emergency_fund' => 'Fundo de Emergência',
            'debt_free' => 'Livre de Dívidas',
            'savings' => 'Poupança',
            'investment' => 'Investimentos',
            'eco_friendly_home' => 'Casa Sustentável',
            'solar_panels' => 'Painéis Solares',
            'electric_vehicle' => 'Veículo Elétrico',
            'sustainable_business' => 'Negócio Sustentável',
            'green_investment' => 'Investimento Verde',
            'education' => 'Educação',
            'travel' => 'Viagem',
            'retirement' => 'Aposentadoria',
            'other' => 'Outro',
        ];
        
        return $types[$this->goal_type] ?? 'Outro';
    }

    public function getGoalTypeIconAttribute()
    {
        $icons = [
            'emergency_fund' => 'fa-shield-halved',
            'debt_free' => 'fa-hand-holding-dollar',
            'savings' => 'fa-piggy-bank',
            'investment' => 'fa-chart-line',
            'eco_friendly_home' => 'fa-house',
            'solar_panels' => 'fa-solar-panel',
            'electric_vehicle' => 'fa-car',
            'sustainable_business' => 'fa-briefcase',
            'green_investment' => 'fa-seedling',
            'education' => 'fa-graduation-cap',
            'travel' => 'fa-plane',
            'retirement' => 'fa-umbrella-beach',
            'other' => 'fa-target',
        ];
        
        return $icons[$this->goal_type] ?? 'fa-target';
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

    public function getStatusLabelAttribute()
    {
        $statuses = [
            'active' => 'Ativa',
            'completed' => 'Concluída',
            'paused' => 'Pausada',
            'cancelled' => 'Cancelada',
        ];
        
        return $statuses[$this->status] ?? 'Ativa';
    }

    public function getEcoImpactDescriptionAttribute($value)
    {
        if (!$this->is_eco_friendly) return null;
        
        $impacts = [
            'eco_friendly_home' => 'Reduz emissões de CO2 e consumo de energia',
            'solar_panels' => 'Energia renovável e redução na conta de luz',
            'electric_vehicle' => 'Zero emissões e economia de combustível',
            'sustainable_business' => 'Negócio com impacto ambiental positivo',
            'green_investment' => 'Investimento em empresas sustentáveis',
        ];
        
        return $impacts[$this->goal_type] ?? $value ?? 'Meta com impacto ambiental positivo';
    }
}
