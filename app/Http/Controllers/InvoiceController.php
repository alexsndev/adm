<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faturas = \App\Models\Invoice::all();
        return view('faturas.index', compact('faturas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('faturas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'invoice_number' => 'nullable|string|max:255|unique:invoices,invoice_number',
            'issue_date' => 'nullable|date',
            'due_date' => 'nullable|date|after_or_equal:issue_date',
            'subtotal' => 'nullable|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'status' => 'required|in:draft,sent,paid,overdue,cancelled',
            'notes' => 'nullable|string|max:1000',
            'terms' => 'nullable|string|max:1000',
            'services' => 'nullable|array',
            'services.*.description' => 'required_with:services|string|max:255',
            'services.*.quantity' => 'required_with:services|numeric|min:1',
            'services.*.unit_price' => 'required_with:services|numeric|min:0',
            'services.*.total' => 'required_with:services|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $fatura = \App\Models\Invoice::create([
                'client_id' => $request->client_id,
                'user_id' => auth()->id(),
                'invoice_number' => $request->invoice_number ?: 'INV-' . time(),
                'issue_date' => $request->issue_date ?: now(),
                'due_date' => $request->due_date ?: now()->addDays(30),
                'subtotal' => $request->subtotal ?? $request->total,
                'tax_rate' => $request->tax_rate ?? 0,
                'tax_amount' => $request->tax_amount ?? 0,
                'total' => $request->total,
                'status' => $request->status,
                'notes' => $request->notes,
                'terms' => $request->terms,
            ]);

            // Salvar serviços se fornecidos
            if ($request->has('services') && is_array($request->services)) {
                foreach ($request->services as $serviceData) {
                    if (!empty($serviceData['description'])) {
                        $fatura->items()->create([
                            'description' => $serviceData['description'],
                            'quantity' => $serviceData['quantity'],
                            'unit_price' => $serviceData['unit_price'],
                            'total' => $serviceData['total'],
                            'type' => 'service',
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('faturas.show', $fatura->id)
                ->with('success', 'Fatura criada com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->withErrors(['error' => 'Erro ao criar fatura: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $fatura = \App\Models\Invoice::findOrFail($id);
        return view('faturas.show', compact('fatura'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $fatura = \App\Models\Invoice::findOrFail($id);
        return view('faturas.edit', compact('fatura'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'invoice_number' => 'nullable|string|max:255|unique:invoices,invoice_number,' . $id,
            'issue_date' => 'nullable|date',
            'due_date' => 'nullable|date|after_or_equal:issue_date',
            'subtotal' => 'nullable|numeric|min:0',
            'tax_rate' => 'nullable|numeric|min:0',
            'tax_amount' => 'nullable|numeric|min:0',
            'total' => 'required|numeric|min:0',
            'status' => 'required|in:draft,sent,paid,overdue,cancelled',
            'notes' => 'nullable|string|max:1000',
            'terms' => 'nullable|string|max:1000',
        ]);

        $fatura = \App\Models\Invoice::findOrFail($id);
        $fatura->update([
            'client_id' => $request->client_id,
            'invoice_number' => $request->invoice_number ?: $fatura->invoice_number,
            'issue_date' => $request->issue_date ?: $fatura->issue_date,
            'due_date' => $request->due_date ?: $fatura->due_date,
            'subtotal' => $request->subtotal ?? $request->total,
            'tax_rate' => $request->tax_rate ?? 0,
            'tax_amount' => $request->tax_amount ?? 0,
            'total' => $request->total,
            'status' => $request->status,
            'notes' => $request->notes,
            'terms' => $request->terms,
        ]);

        return redirect()->route('faturas.show', $fatura->id)->with('success', 'Fatura atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Generate PDF for the invoice
     */
    public function generatePDF($id)
    {
        $fatura = \App\Models\Invoice::with('client')->findOrFail($id);
        $pdf = \PDF::loadView('faturas.pdf', compact('fatura'));
        return $pdf->download("fatura-{$fatura->id}.pdf");
    }
}
