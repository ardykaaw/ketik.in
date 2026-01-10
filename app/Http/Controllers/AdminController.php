<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'users_count' => User::where('is_active', true)->count(),
            'premium_users' => User::where('is_active', true)->where('premium_until', '>', now())->count(),
            'new_users_today' => User::where('is_active', true)->whereDate('created_at', today())->count(),
            'content_count' => \App\Models\Content::count(),
        ];
        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        $users = User::where('is_active', true)->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:user,admin',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true, // Admin-created users are active immediately
            'email_verified_at' => now(), 
        ]);

        return back()->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        $user->delete();
        return back()->with('success', 'Pengguna berhasil dihapus.');
    }

    public function subscriptions()
    {
        // Show all users so admin can manage any subscription
        $users = User::where('is_active', true)->latest()->paginate(10);
        return view('admin.subscriptions.index', compact('users'));
    }

    public function extendSubscription(Request $request, User $user)
    {
        $request->validate([
            'days' => 'required|integer|min:1',
        ]);

        $currentUntil = $user->premium_until && $user->premium_until->isFuture() 
            ? $user->premium_until 
            : now();

        $user->update([
            'premium_until' => $currentUntil->addDays((int) $request->days),
            'plan_name' => 'Premium Plan',
        ]);

        return back()->with('success', "Masa aktif {$user->name} berhasil diperpanjang {$request->days} hari.");
    }

    /* --- Verification Logic --- */
    public function verifications()
    {
        // Users who are NOT active and NOT admin
        $pendingUsers = User::where('is_active', false)
            ->where('role', '!=', 'admin')
            ->latest()
            ->paginate(15);
            
        return view('admin.verifications.index', compact('pendingUsers'));
    }

    public function approveUser(User $user)
    {
        $user->update(['is_active' => true]);
        return back()->with('success', "Akun {$user->name} berhasil diverifikasi dan diaktifkan.");
    }
}
