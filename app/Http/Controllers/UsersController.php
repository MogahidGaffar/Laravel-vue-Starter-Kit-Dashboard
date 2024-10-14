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
    public function index()
    {
        $user =User::with('roles')->latest()->paginate(10);
     return Inertia('Users/index',[
        'users'=>$user
     ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return Inertia('Users/Create', ['roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $user= User::make(
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'password' => 'required',
            ])
        );
        if(!empty($request->password)){
           $user->password=$request->password;
        }
        $user->save();
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
        $roles = Role::pluck('name','name')->all();
        $userRoles = $user->roles->pluck('name')->all();
        return Inertia('Users/Edit',[
            'user'=>$user,
            'roles' => $roles,
            'userRoles' => $userRoles
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $user->update(
            $request->validate([
                'name' => 'required',
                'email' => 'required',
            ])
        );
        $user->syncRoles($request->selectedRoles);

        return redirect()->route('users.index')
            ->with('success', 'user Updated successfully!');
    }

    
    public function activate(User $user)
{
    $user->update([
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
