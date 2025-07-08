<?php

namespace App\Http\Controllers;

use App\Models\FinancialGoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FinancialGoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $financialGoals = Auth::user()->financialGoals()->orderBy('created_at', 'desc')->get();
        
        return view('financial-goals.index', compact('financialGoals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $accounts = Auth::user()->accounts()->get();
        return view('financial-goals.create', compact('accounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_amount' => 'required|numeric|min:0.01',
            'current_amount' => 'required|numeric|min:0',
            'target_date' => 'required|date|after:today',
            'start_date' => 'required|date',
            'goal_type' => 'required|in:emergency_fund,debt_free,savings,investment,eco_friendly_home,solar_panels,electric_vehicle,sustainable_business,green_investment,education,travel,retirement,other',
            'priority' => 'required|in:low,medium,high,critical',
            'monthly_contribution' => 'nullable|numeric|min:0',
            'account_id' => 'nullable|exists:accounts,id',
            'is_eco_friendly' => 'boolean',
            'eco_impact_description' => 'nullable|string|max:500',
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'target_amount' => $request->target_amount,
            'current_amount' => $request->current_amount,
            'target_date' => $request->target_date,
            'start_date' => $request->start_date,
            'goal_type' => $request->goal_type,
            'priority' => $request->priority,
            'monthly_contribution' => $request->monthly_contribution ?? 0,
            'account_id' => $request->account_id ?: null,
            'is_eco_friendly' => $request->has('is_eco_friendly'),
            'eco_impact_description' => $request->eco_impact_description,
        ];

        $financialGoal = Auth::user()->financialGoals()->create($data);

        return redirect()->route('financial-goals.index')
            ->with('success', 'Meta verde criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(FinancialGoal $financialGoal)
    {
        return view('financial-goals.show', compact('financialGoal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FinancialGoal $financialGoal)
    {
        $accounts = Auth::user()->accounts()->get();
        return view('financial-goals.edit', compact('financialGoal', 'accounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FinancialGoal $financialGoal)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'target_amount' => 'required|numeric|min:0.01',
            'current_amount' => 'required|numeric|min:0',
            'target_date' => 'required|date',
            'start_date' => 'required|date',
            'goal_type' => 'required|in:emergency_fund,debt_free,savings,investment,eco_friendly_home,solar_panels,electric_vehicle,sustainable_business,green_investment,education,travel,retirement,other',
            'priority' => 'required|in:low,medium,high,critical',
            'monthly_contribution' => 'nullable|numeric|min:0',
            'account_id' => 'nullable|exists:accounts,id',
            'is_eco_friendly' => 'boolean',
            'eco_impact_description' => 'nullable|string|max:500',
        ]);
        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'target_amount' => $request->target_amount,
            'current_amount' => $request->current_amount,
            'target_date' => $request->target_date,
            'start_date' => $request->start_date,
            'goal_type' => $request->goal_type,
            'priority' => $request->priority,
            'monthly_contribution' => $request->monthly_contribution ?? 0,
            'account_id' => $request->account_id ?: null,
            'is_eco_friendly' => $request->has('is_eco_friendly'),
            'eco_impact_description' => $request->eco_impact_description,
        ];
        $financialGoal->update($data);
        return redirect()->route('financial-goals.index')
            ->with('success', 'Meta verde atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FinancialGoal $financialGoal)
    {
        $financialGoal->delete();
        return redirect()->route('financial-goals.index')
            ->with('success', 'Meta verde excluída com sucesso!');
    }
} 