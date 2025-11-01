<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;


class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('pages.profile.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('pages.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update($request->only('name', 'email', 'phone'));

        return redirect()->route('profile')->with('success', 'Profil berhasil diperbarui!');
    }
}
