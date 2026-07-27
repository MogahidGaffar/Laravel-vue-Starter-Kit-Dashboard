<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Support\Countries;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    private const DEFAULT_AVATAR = 'avatars/default_avatar.png';

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
            'country' => $request->country,
            'is_active' => $request->is_active,
        ];

        $users = $this->users->paginateFiltered($filters, 10);

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
        $roles = $this->roles->pluckNames();
        return Inertia('Users/Create', ['roles' => $roles]);
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
            'avatar' => $request->avatar ? $request->avatar : self::DEFAULT_AVATAR,
            'country' => Countries::option($request->country),
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
        $data['country'] = Countries::option($data['country'] ?? null);

        // Never overwrite the stored avatar with an empty value; only replace it
        // when a new file was actually uploaded.
        if ($request->hasFile('avatar')) {
            $oldAvatar = $user->getRawOriginal('avatar');

            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');

            if ($oldAvatar && $oldAvatar !== self::DEFAULT_AVATAR) {
                Storage::disk('public')->delete($oldAvatar);
            }
        } else {
            unset($data['avatar']);

            // Defensively backfill if the user somehow has no avatar stored at all.
            if (empty($user->getRawOriginal('avatar'))) {
                $data['avatar'] = self::DEFAULT_AVATAR;
            }
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
        $avatar = $user->getRawOriginal('avatar');

        $this->users->delete($user);

        if ($avatar && $avatar !== self::DEFAULT_AVATAR) {
            Storage::disk('public')->delete($avatar);
        }

        return redirect()->route('users.index')
        ->with('success',  __('messages.data_deleted_successfully'));
    }
}
