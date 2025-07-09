<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Lista as notificações do usuário autenticado
    public function index()
    {
        $notifications = Auth::user()->notifications()->orderBy('created_at', 'desc')->take(20)->get();
        $unreadCount = Auth::user()->unreadNotifications()->count();
        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }

    // Marca uma notificação como lida
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return response()->json(['success' => true]);
    }

    // Marca todas como lidas
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    }

    // Deleta uma notificação
    public function destroy($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();
        return response()->json(['success' => true]);
    }
}
