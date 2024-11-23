<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
            // hitung user dengan role user
            $users = User::whereHas('roles', function ($query) {
                $query->where('name', 'user');
            })->get()->count();
            return view('admin.dashboard.index', compact('users'));
        } elseif (Auth::user()->hasRole('user')) {
            return view('user.dashboard.index');
        } else {
            abort(404);
        }
    }
}
