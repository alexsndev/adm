<?php

namespace App\Http\Controllers;

use App\Models\DailyForecast;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Transaction;
use App\Models\Category;

class DailyForecastController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'client_id' => 'nullable|exists:clients,id',
            'date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
        ]);
        DailyForecast::create([
            'user_id' => Auth::id(),
            'client_id' => $request->client_id,
            'amount' => $request->amount,
            'date' => $request->date,
            'notes' => $request->notes,
            'status' => 'pendente',
        ]);
        return Redirect::back()->with('success', 'Diária prevista lançada com sucesso!');
    }

    public function index()
    {
        $diarias = DailyForecast::where('user_id', Auth::id())->orderBy('date', 'desc')->get();
        $clientes = Client::where('user_id', Auth::id())->get();
        $totalRecebido = $diarias->where('status', 'recebido')->sum('amount');
        $totalPendente = $diarias->where('status', 'pendente')->sum('amount');
        $totalGeral = $diarias->sum('amount');
        $rankingClientes = $diarias->where('status', 'recebido')
            ->groupBy('client_id')
            ->map(function($items, $clientId) use ($clientes) {
                $cliente = $clientes->firstWhere('id', $clientId);
                return [
                    'nome' => $cliente ? $cliente->name : 'Sem cliente',
                    'valor' => $items->sum('amount'),
                    'cliente' => $cliente
                ];
            })->sortByDesc('valor');
        return view('daily-forecasts.index', compact('diarias', 'clientes', 'totalRecebido', 'totalPendente', 'totalGeral', 'rankingClientes'));
    }

    public function receive(Request $request, $id)
    {
        $diaria = DailyForecast::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $request->validate([
            'account_id' => 'required|exists:accounts,id',
        ]);
        // Buscar ou criar categoria 'Diárias'
        $categoria = Category::firstOrCreate([
            'user_id' => Auth::id(),
            'name' => 'Diárias',
            'type' => 'income',
        ]);
        // Criar transação de receita
        Transaction::create([
            'user_id' => Auth::id(),
            'account_id' => $request->account_id,
            'category_id' => $categoria->id,
            'amount' => $diaria->amount,
            'date' => $diaria->date,
            'type' => 'income',
            'description' => 'Recebimento de diária'.($diaria->client ? ' - '.$diaria->client->name : ''),
            'notes' => $diaria->notes,
            'is_recurring' => false,
        ]);
        $diaria->status = 'recebido';
        $diaria->save();
        return Redirect::back()->with('success', 'Diária recebida e lançada nas transações!');
    }
} 