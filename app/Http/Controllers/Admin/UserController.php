<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        // Cegah admin hapus dirinya sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Kamu tidak bisa menghapus akun sendiri!');
        }

        $user->delete(); // Cascade otomatis hapus transactions, debts, streak, announcements

        return back()->with('success', 'User berhasil dihapus permanen!');
    }
}