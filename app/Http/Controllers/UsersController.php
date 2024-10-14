<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     return Inertia('Users/index',[
        'users'=>User::latest()->paginate(10)
     ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia('Users/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        User::create(
            $request->validate([
                'name' => 'required',
                'email' => 'required',
                'password' => 'required',
            ])
        );

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
        return Inertia('Users/Edit',[
            'user'=>$user
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
