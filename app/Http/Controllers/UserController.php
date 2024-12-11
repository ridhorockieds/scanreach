<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function index()
    {
        if(!auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $breadcrumbs = [
            ['name' => 'Users', 'url' => route('users.index')]
        ];
        
        $users = User::where('id', '!=', 1)
            ->withCount(['items', 'chats']) // Eager load dan hitung relasi
            ->get();

        return view('user.index', compact('breadcrumbs', 'users'));
    }

    public function show(User $user)
    {
        if(!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $breadcrumbs = [
            ['name' => 'Users', 'url' => route('users.index')],
            ['name' => 'Detail', 'url' => '']
        ];
        return view('user.show', compact('user', 'breadcrumbs'));
    }
    
    public function destroy(User $user)
    {
        if(!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $user->delete();
            
        return response()->json([
            'message' => 'User has been deleted!',
            'redirect' => route('users.index'),
        ]);
    }
}
