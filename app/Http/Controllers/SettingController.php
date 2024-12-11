<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            ['name' => 'Setting', 'url' => route('setting.index')]
        ];
        return view('setting.index', compact('breadcrumbs'));
    }

    public function account()
    {
        $breadcrumbs = [
            ['name' => 'Setting', 'url' => route('setting.index')],
            ['name' => 'Account', 'url' => '']
        ];
        return view('setting.account', compact('breadcrumbs'));
    }

    public function notification()
    {
        $breadcrumbs = [
            ['name' => 'Setting', 'url' => route('setting.index')],
            ['name' => 'Notification', 'url' => '']
        ];
        if(auth()->user()->hasRole('user')) {
            return view('setting.notification', compact('breadcrumbs'));
        }
        abort(403);
    }

    public function updateProfile(Request $request)
    {
        // Validasi input request
        $validatedData = $request->validate([
            'fullname' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        // Jika password diisi, hash dan tambahkan ke data yang akan diupdate
        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            // Jika password tidak diisi, hapus dari data yang akan diupdate
            unset($validatedData['password']);
        }

        // Update profil pengguna
        $user->update($validatedData);

        return response()->json([
            'message' => 'Profile updated successfully',
            'redirect' => route('setting.account'),
        ], 200);
    }

}
