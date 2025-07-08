<?php

namespace App\Http\Controllers;

use App\Models\GoalContribution;
use App\Models\FinancialGoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GoalContributionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FinancialGoal $financialGoal)
    {
        $contributions = $financialGoal->contributions()
            ->with('account')
            ->orderBy('contribution_date', 'desc')
            ->paginate(15);
        
        return view('goal-contributions.index', compact('financialGoal', 'contributions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(FinancialGoal $financialGoal)
    {
        $accounts = Auth::user()->accounts()->get();
        return view('goal-contributions.create', compact('financialGoal', 'accounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, FinancialGoal $financialGoal)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'contribution_date' => 'required|date',
            'description' => 'nullable|string|max:255',
            'account_id' => 'nullable|exists:accounts,id',
            'type' => 'required|in:manual,automatic,bonus',
            'reference' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request, $financialGoal) {
            // Criar transação correspondente primeiro
            $transactionData = [
                'user_id' => Auth::id(),
                'description' => $request->description ?: "Contribuição para meta: {$financialGoal->name}",
                'amount' => $request->amount,
                'type' => 'expense',
                'date' => $request->contribution_date,
                'category_id' => $this->getGoalCategoryId($financialGoal->goal_type),
                'account_id' => $request->account_id ?: $financialGoal->account_id,
                'notes' => "Contribuição para meta: {$financialGoal->name}",
                'reference' => $request->reference,
            ];
            $transactionData = array_filter($transactionData, function($value) {
                return $value !== null;
            });
            $transaction = \App\Models\Transaction::create($transactionData);

            // Criar a contribuição já vinculando o transaction_id
            $contribution = $financialGoal->contributions()->create([
                'user_id' => Auth::id(),
                'amount' => $request->amount,
                'contribution_date' => $request->contribution_date,
                'description' => $request->description,
                'account_id' => $request->account_id ?: null,
                'type' => $request->type,
                'reference' => $request->reference,
                'transaction_id' => $transaction->id,
            ]);

            // Atualizar o progresso da meta
            $financialGoal->updateProgressFromContributions();
        });

        return redirect()->route('financial-goals.show', $financialGoal)
            ->with('success', 'Contribuição registrada com sucesso! Progresso atualizado e transação criada.');
    }

    /**
     * Obter categoria apropriada baseada no tipo da meta
     */
    private function getGoalCategoryId($goalType)
    {
        $categoryMap = [
            'emergency_fund' => 'Poupança',
            'savings' => 'Poupança',
            'investment' => 'Investimentos',
            'retirement' => 'Aposentadoria',
            'education' => 'Educação',
            'travel' => 'Viagem',
            'eco_friendly_home' => 'Casa',
            'solar_panels' => 'Energia',
            'electric_vehicle' => 'Transporte',
            'sustainable_business' => 'Negócios',
            'green_investment' => 'Investimentos',
            'debt_free' => 'Dívidas',
        ];

        $categoryName = $categoryMap[$goalType] ?? 'Outros';
        
        // Buscar categoria existente ou criar uma nova
        $category = \App\Models\Category::where('user_id', Auth::id())
            ->where('name', 'like', "%{$categoryName}%")
            ->first();

        if (!$category) {
            // Criar categoria padrão para metas
            $category = \App\Models\Category::create([
                'user_id' => Auth::id(),
                'name' => 'Metas Financeiras',
                'type' => 'expense',
                'color' => '#10B981',
                'icon' => 'fa-target',
            ]);
        }

        return $category->id;
    }

    /**
     * Display the specified resource.
     */
    public function show(FinancialGoal $financialGoal, GoalContribution $contribution)
    {
        if ($contribution->financial_goal_id !== $financialGoal->id) {
            abort(404);
        }
        
        return view('goal-contributions.show', compact('financialGoal', 'contribution'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FinancialGoal $financialGoal, GoalContribution $contribution)
    {
        if ($contribution->financial_goal_id !== $financialGoal->id) {
            abort(404);
        }
        
        $accounts = Auth::user()->accounts()->get();
        return view('goal-contributions.edit', compact('financialGoal', 'contribution', 'accounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FinancialGoal $financialGoal, GoalContribution $contribution)
    {
        if ($contribution->financial_goal_id !== $financialGoal->id) {
            abort(404);
        }

        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'contribution_date' => 'required|date',
            'description' => 'nullable|string|max:255',
            'account_id' => 'nullable|exists:accounts,id',
            'type' => 'required|in:manual,automatic,bonus',
            'reference' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request, $financialGoal, $contribution) {
            // Atualizar a contribuição
            $contribution->update([
                'amount' => $request->amount,
                'contribution_date' => $request->contribution_date,
                'description' => $request->description,
                'account_id' => $request->account_id ?: null,
                'type' => $request->type,
                'reference' => $request->reference,
            ]);

            // Atualizar o progresso da meta
            $financialGoal->updateProgressFromContributions();
        });

        return redirect()->route('financial-goals.show', $financialGoal)
            ->with('success', 'Contribuição atualizada com sucesso! Progresso atualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FinancialGoal $financialGoal, GoalContribution $contribution)
    {
        if ($contribution->financial_goal_id !== $financialGoal->id) {
            abort(404);
        }

        DB::transaction(function () use ($financialGoal, $contribution) {
            // Excluir a transação vinculada, se houver
            if ($contribution->transaction_id) {
                \App\Models\Transaction::where('id', $contribution->transaction_id)->delete();
            }
            // Excluir a contribuição
            $contribution->delete();
            // Atualizar o progresso da meta
            $financialGoal->updateProgressFromContributions();
        });

        return redirect()->route('financial-goals.show', $financialGoal)
            ->with('success', 'Contribuição excluída com sucesso! Progresso atualizado.');
    }

    /**
     * Registrar contribuição rápida
     */
    public function quickContribution(Request $request, FinancialGoal $financialGoal)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request, $financialGoal) {
            // Criar a contribuição
            $contribution = $financialGoal->contributions()->create([
                'user_id' => Auth::id(),
                'amount' => $request->amount,
                'contribution_date' => now()->toDateString(),
                'description' => $request->description ?: 'Contribuição rápida',
                'type' => 'manual',
            ]);

            // Criar transação correspondente
            $transactionData = [
                'user_id' => Auth::id(),
                'description' => $request->description ?: "Contribuição rápida para meta: {$financialGoal->name}",
                'amount' => $request->amount,
                'type' => 'expense',
                'date' => now()->toDateString(),
                'category_id' => $this->getGoalCategoryId($financialGoal->goal_type),
                'account_id' => $financialGoal->account_id,
                'notes' => "Contribuição rápida para meta: {$financialGoal->name} (ID: {$contribution->id})",
            ];

            // Remover campos nulos
            $transactionData = array_filter($transactionData, function($value) {
                return $value !== null;
            });

            \App\Models\Transaction::create($transactionData);

            // Atualizar o progresso da meta
            $financialGoal->updateProgressFromContributions();
        });

        return redirect()->back()
            ->with('success', 'Contribuição de R$ ' . number_format($request->amount, 2, ',', '.') . ' registrada com sucesso! Transação criada automaticamente.');
    }
}
