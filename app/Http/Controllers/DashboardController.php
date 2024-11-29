<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $breadcrumbs = [
                ['name' => 'Dashboard', 'url' => route('items.index')]
            ];

            $totalUsers = User::role('user')->get()->count();
            $totalItems = Item::get()->count();
            return view('admin.dashboard.index', compact('breadcrumbs', 'totalUsers', 'totalItems'));
        }

        return redirect()->route('login')->withErrors('error', 'You are not logged in!');
    }
}
