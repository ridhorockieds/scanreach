<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $totalUsers = User::role('user')->get()->count();
            return view('admin.dashboard.index', compact('totalUsers'));
        }

        return redirect()->route('login')->withErrors('error', 'You are not logged in!');
    }
}
