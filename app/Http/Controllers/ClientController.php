<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = \App\Models\Client::all();
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'tax_id' => 'nullable|string|max:20',
            'hourly_rate' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        // Upload da foto
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('clients/photos', 'public');
            $data['photo'] = $photoPath;
        }

        $cliente = \App\Models\Client::create($data);

        return redirect()->route('clientes.show', $cliente->id)
            ->with('success', 'Cliente criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $cliente = \App\Models\Client::findOrFail($id);
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $cliente = \App\Models\Client::findOrFail($id);
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'tax_id' => 'nullable|string|max:20',
            'hourly_rate' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $cliente = \App\Models\Client::findOrFail($id);
        $data = $request->all();

        // Upload da nova foto
        if ($request->hasFile('photo')) {
            // Remove a foto antiga se existir
            if ($cliente->photo) {
                Storage::disk('public')->delete($cliente->photo);
            }
            
            $photoPath = $request->file('photo')->store('clients/photos', 'public');
            $data['photo'] = $photoPath;
        }

        $cliente->update($data);

        return redirect()->route('clientes.show', $cliente->id)
            ->with('success', 'Cliente atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cliente = \App\Models\Client::findOrFail($id);
        
        // Remove a foto se existir
        if ($cliente->photo) {
            Storage::disk('public')->delete($cliente->photo);
        }
        
        $cliente->delete();

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente removido com sucesso!');
    }

    /**
     * Store a new client via AJAX
     */
    public function storeAjax(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'tax_id' => 'nullable|string|max:20',
            'hourly_rate' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();

        $cliente = \App\Models\Client::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Cliente criado com sucesso!',
            'client' => [
                'id' => $cliente->id,
                'name' => $cliente->name,
                'email' => $cliente->email,
                'company' => $cliente->company
            ]
        ]);
    }
}
