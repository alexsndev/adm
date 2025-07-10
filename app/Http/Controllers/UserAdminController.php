<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserAdminController extends Controller
{
    // Lista todos os usuários
    public function index()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Acesso não autorizado');
        }
        $users = User::orderBy('name')->get();
        return view('admin.users.index', compact('users'));
    }

    // Alterna o status de admin
    public function toggleAdmin(User $user)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403, 'Acesso não autorizado');
        }
        // Não permitir remover o próprio admin
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Você não pode remover seu próprio status de administrador.');
        }
        $user->is_admin = !$user->is_admin;
        $user->save();
        return back()->with('success', 'Status de administrador atualizado com sucesso!');
    }
} 