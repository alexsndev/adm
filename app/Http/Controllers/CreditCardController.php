<?php

namespace App\Http\Controllers;

use App\Models\CreditCard;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CreditCardController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $creditCards = CreditCard::where('user_id', Auth::id())->with('account')->orderBy('name')->get();
        return view('credit-cards.index', compact('creditCards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $accounts = Account::where('user_id', Auth::id())->active()->orderBy('name')->get();
        return view('credit-cards.create', compact('accounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'is_active' => $request->has('is_active') ? 1 : 0
        ]);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:50',
            'last_four_digits' => 'nullable|string|max:4',
            'credit_limit' => 'nullable|numeric|min:0',
            'current_balance' => 'nullable|numeric|min:0',
            'due_day' => 'nullable|integer|min:1|max:31',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'color' => 'nullable|string|max:30',
            'is_active' => 'boolean',
            'notes' => 'nullable|string',
            'account_id' => 'required|exists:accounts,id',
        ]);
        $validated['user_id'] = Auth::id();
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('credit_cards_logos', 'public');
        }
        CreditCard::create($validated);
        return redirect()->route('credit-cards.index')->with('success', 'Cartão cadastrado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CreditCard $creditCard)
    {
        $this->authorize('view', $creditCard);
        return view('credit-cards.show', compact('creditCard'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CreditCard $creditCard)
    {
        $this->authorize('update', $creditCard);
        $accounts = Account::where('user_id', Auth::id())->active()->orderBy('name')->get();
        return view('credit-cards.edit', compact('creditCard', 'accounts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CreditCard $creditCard)
    {
        $this->authorize('update', $creditCard);
        $request->merge([
            'is_active' => $request->has('is_active') ? 1 : 0
        ]);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:50',
            'last_four_digits' => 'nullable|string|max:4',
            'credit_limit' => 'nullable|numeric|min:0',
            'current_balance' => 'nullable|numeric|min:0',
            'due_day' => 'nullable|integer|min:1|max:31',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'color' => 'nullable|string|max:30',
            'is_active' => 'boolean',
            'notes' => 'nullable|string',
            'account_id' => 'required|exists:accounts,id',
        ]);
        if ($request->hasFile('logo')) {
            if ($creditCard->logo && \Storage::disk('public')->exists($creditCard->logo)) {
                \Storage::disk('public')->delete($creditCard->logo);
            }
            $validated['logo'] = $request->file('logo')->store('credit_cards_logos', 'public');
        }
        $creditCard->update($validated);
        return redirect()->route('credit-cards.index')->with('success', 'Cartão atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CreditCard $creditCard)
    {
        $this->authorize('delete', $creditCard);
        if ($creditCard->logo && \Storage::disk('public')->exists($creditCard->logo)) {
            \Storage::disk('public')->delete($creditCard->logo);
        }
        $creditCard->delete();
        return redirect()->route('credit-cards.index')->with('success', 'Cartão excluído com sucesso!');
    }
}
