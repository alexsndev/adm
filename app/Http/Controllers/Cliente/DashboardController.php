<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $client = \Illuminate\Support\Facades\Auth::user()->client;
        if (!$client) {
            abort(404, 'Cliente não encontrado ou não vinculado.');
        }
        return view('cliente.dashboard', compact('client'));
    }
} 