<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifs = Notifikasi::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return response()->json($notifs);
    }

    public function markAsRead($id)
    {
        $notif = Notifikasi::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $notif->update(['is_read' => true]);

        return response()->json(['message' => 'Notifikasi ditandai sudah dibaca.']);
    }
}
