<?php

namespace  App\Http\Controllers;

use App\Http\Requests\GivePermissionsRequest;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;

class RoleController extends Controller
{
    public function __construct(protected RoleRepositoryInterface $roles)
    {
        $this->middleware('permission:read roles', ['only' => ['index']]);
        $this->middleware('permission:create roles', ['only' => ['create','store']]);
        $this->middleware('permission:update roles', ['only' => ['update','edit']]);
        $this->middleware('permission:delete roles', ['only' => ['destroy']]);
    }

    public function index()
    {
        $roles = $this->roles->latestAll();
        return Inertia('roles-permissions/Roles/index',[
            'translations' => __('messages'),
            'roles'=>$roles
         ]);
    }

    public function create()
    {
        return Inertia('roles-permissions/Roles/Create',[
            'translations' => __('messages'),
         ]);
    }

    public function store(StoreRoleRequest $request)
    {
        // The validated data is automatically handled by the StoreRoleRequest
        $this->roles->create([
            'name' => $request->name,
        ]);

        return redirect()->route('roles.index')
            ->with('success', __('messages.data_saved_successfully'));
    }

    public function edit(Role $role)
    {
        return Inertia('roles-permissions/Roles/Edit',[
            'translations' => __('messages'),
            'role'=>$role
         ]);
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->roles->update($role, [
            'name' => $request->name,
        ]);

        return redirect()->route('roles.index')
            ->with('success', __('messages.data_updated_successfully'));
    }

    public function destroy($roleId)
    {
        $role = $this->roles->findOrFail((int) $roleId);
        $this->roles->delete($role);
        return redirect()->route('roles.index')
        ->with('success',  __('messages.data_deleted_successfully'));
    }

    public function addPermissionToRole($roleId)
    {
        $permissions = Permission::get();
        $role = $this->roles->findOrFail((int) $roleId);
        $rolePermissions = $this->roles->getAssignedPermissionNames($role);

        return Inertia('roles-permissions/Roles/Add-permissions',[
            'translations' => __('messages'),
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
         ]);
    }

    public function givePermissionToRole(GivePermissionsRequest $request, $roleId)
    {
        $role = $this->roles->findOrFail((int) $roleId);
        $this->roles->syncPermissions($role, $request->validated('selectedPermissions'));

        return redirect()->route('roles.index')
        ->with('success',  __('messages.role_permissions_updated_successfully'));
    }
}
