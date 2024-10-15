<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        // Define the filters
        $filters = [
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => $request->is_active,
        ];
        // Start the User query
        $UsersQuery = User::with('roles')->latest();

        // Apply the filters if they exist
        $UsersQuery->when($filters['name'], function ($query, $name) {
            return $query->where('name', 'LIKE', "%{$name}%");
        });

        $UsersQuery->when($filters['email'], function ($query, $email) {
            return $query->where('email', 'LIKE', "%{$email}%");
        });


        if (isset($filters['is_active'])) {
            $UsersQuery->where('is_active', $filters['is_active']);
        }
        // Paginate the filtered users
        $users = $UsersQuery->paginate(10);

        return Inertia('Users/index', [
            'filters' => $filters,
            'users' => $users,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return Inertia('Users/Create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $user = User::make(
            $request->validate([
                'name' => 'required',
                'email' => 'required|unique:users,email',
                'password' => 'required',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ])
        );
        if (!empty($request->password)) {
            $user->password = $request->password;
        }
        $user->avatar = $request->avatar ?: 'avatars/default_avatar.png';
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }
        $user->save();
        // Sync roles if any
        $user->syncRoles($request->selectedRoles);

        return redirect()->route('users.index')
            ->with('success', 'user Saved successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name')->all();
        return Inertia('Users/Edit', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', 
        ]);
    
        // Check if an avatar file is uploaded
        if ($request->hasFile('avatar')) {
            // Store the file in the 'avatars' directory within the 'public' disk
            $path = $request->file('avatar')->store('avatars', 'public');
            $validatedData['avatar'] = $path;
        }
    
        // Update user information, including avatar and other fields, in a single save operation
        $user->update($validatedData);
    
        // Sync roles if any
        $user->syncRoles($request->selectedRoles);
    
        return redirect()->route('users.index')
            ->with('success', 'User updated successfully!');
    }
    

    public function activate(User $user)
    {
        $user->update(
            [
                'is_active' => ($user->is_active) ? 0 : 1
            ]
        );
        return redirect()->route('users.index')
            ->with('success', 'user Status Updated successfully!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'user Deleted successfully!');
    }
}
