<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;

class UsersController extends Controller
{
    public function __construct(
        protected UserRepositoryInterface $users,
        protected RoleRepositoryInterface $roles,
    ) {
        $this->middleware('permission:read users', ['only' => ['index']]);
        $this->middleware('permission:create users', ['only' => ['create']]);
        $this->middleware('permission:update users', ['only' => ['update','edit']]);
        $this->middleware('permission:delete users', ['only' => ['destroy']]);
    }


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

        $users = $this->users->paginateFiltered($filters, 10);

        return Inertia('Users/index', [
            'translations' => __('messages'),
            'filters' => $filters,
            'users' => $users,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = $this->roles->pluckNames();
        return Inertia('Users/Create', [ 'translations' => __('messages'),'roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        // Build the user data, defaulting the avatar when none was uploaded
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),  // Hash the password
            'avatar' => $request->avatar ? $request->avatar : 'avatars/default_avatar.svg',
        ];

        // Handle avatar upload if a file is provided
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user = $this->users->create($data);

        // Sync roles if any selected
        if ($request->has('selectedRoles')) {
            $this->users->syncRoles($user, $request->selectedRoles);
        }

        // Redirect with success message
        return redirect()->route('users.index')
            ->with('success', __('messages.data_saved_successfully'));
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
        $roles = $this->roles->pluckNames();
        $userRoles = $user->roles->pluck('name')->all();
        return Inertia('Users/Edit', [
            'translations' => __('messages'),
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // The request is automatically validated using the UpdateUserRequest rules
        $data = $request->validated();

        // Check if an avatar file is uploaded and store it
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        // Update user information, including avatar and other fields, in a single save operation
        $this->users->update($user, $data);

        // Sync roles if any
        $this->users->syncRoles($user, $request->selectedRoles);

        return redirect()->route('users.index')
            ->with('success', __('messages.data_updated_successfully'));
    }


    public function activate(User $user)
    {
        $this->users->update($user, [
            'is_active' => ($user->is_active) ? 0 : 1
        ]);
        return redirect()->route('users.index')
            ->with('success', 'user Status Updated successfully!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->users->delete($user);
        return redirect()->route('users.index')
        ->with('success',  __('messages.data_deleted_successfully'));
    }
}
