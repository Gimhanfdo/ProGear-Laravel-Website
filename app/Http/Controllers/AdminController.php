<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class AdminController extends Controller
{
    //CRUD functions for Admin//

    //Create Admin
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => 'admin',
        'email_verified_at' => now(), 
    ]);

        return redirect()->route('admin.admins.index')->with('success', 'Admin created successfully.');
    }

    //Edit Admin
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $admin = $this->getUserById($id);
        $admin->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => 'admin',
        'email_verified_at' => now(), 
    ]);

        return redirect()->route('admin.admins.index')->with('success', 'Admin updated successfully.');
    }

    // Get all users
    public function getAllUsers()
    {
        return User::all();
    }

    // Get users by role
    public function getUsersByRole($role)
    {
        return User::where('role', strtolower($role))->get();
    }

    // Get single user by ID
    public function getUserById($id)
    {
        return User::findOrFail($id);
    }

    // Delete user
    public function destroyUser($id)
    {
        $user = $this->getUserById($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User removed successfully.');
    }

    // Delete admin
    public function destroyAdmin($id)
    {
        $user = $this->getUserById($id);
        $user->delete();

        return redirect()->route('admin.admins.index')->with('success', 'Admin removed successfully.');
    }

    //Views//

    //Display Admin Dashboard
    public function index()
    {
        return view('admin.dashboard');
    }

    // Display users by role
    public function users()
    {
        $users = $this->getUsersByRole('user');
        
        return view('admin.users.index', compact('users'));
    }

    //Display admins
    public function admins()
    {
        $admins = $this->getUsersByRole('admin');
        return view('admin.admins.index', compact('admins'));
    }

    // Show edit admin page
    public function edit($id)
    {
        $admin = $this->getUserById($id);
        return view('admin.admins.edit', compact('admin'));
    }
}
