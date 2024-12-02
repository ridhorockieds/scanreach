<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->withErrors('error', 'You are not logged in!');
        }

        $breadcrumbs = [
            ['name' => 'Dashboard', 'url' => route('items.index')]
        ];

        // Data umum untuk semua pengguna
        $totalItems = Item::where('user_id', auth()->id())->count();
        $totalChat = Chat::where('user_id', auth()->id())->count();
        $totalUsers = null;

        // Data tambahan khusus untuk admin
        if (Auth::user()->hasRole('admin')) {
            $totalUsers = User::where('id', '!=', 1)->count();
            $totalItems = Item::count();  // Override untuk admin melihat semua item
            $totalChat = Chat::count();   // Override untuk admin melihat semua chat
        }

        return view('admin.dashboard.index', compact('breadcrumbs', 'totalUsers', 'totalItems', 'totalChat'));
    }
}

