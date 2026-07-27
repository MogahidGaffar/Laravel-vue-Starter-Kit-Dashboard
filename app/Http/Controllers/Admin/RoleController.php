<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\GivePermissionsRequest;
use App\Repositories\Contracts\RoleRepositoryInterface;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\StoreRoleRequest;

class RoleController extends Controller
{
    public function __construct(protected RoleRepositoryInterface $roles)
    {
        $this->middleware('permission:read roles', ['only' => ['index']]);
        $this->middleware('permission:create roles', ['only' => ['create','store']]);
        $this->middleware('permission:update roles', ['only' => ['addPermissionToRole','givePermissionToRole']]);
        $this->middleware('permission:delete roles', ['only' => ['destroy']]);
    }

    public function index()
    {
        $roles = $this->roles->latestAll();
        return Inertia('roles-permissions/Roles/index',[
            'roles'=>$roles
         ]);
    }

    public function create()
    {
        return Inertia('roles-permissions/Roles/Form', [
            'role' => null,
            'permissions' => Permission::get(),
            'rolePermissions' => [],
        ]);
    }

    public function store(StoreRoleRequest $request)
    {
        $role = $this->roles->create([
            'name' => $request->name,
        ]);
        $this->roles->syncPermissions($role, $request->validated('selectedPermissions'));

        return redirect()->route('roles.index')
            ->with('success', __('messages.data_saved_successfully'));
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

        return Inertia('roles-permissions/Roles/Form',[
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
         ]);
    }

    public function givePermissionToRole(GivePermissionsRequest $request, $roleId)
    {
        $role = $this->roles->findOrFail((int) $roleId);
        $this->roles->update($role, ['name' => $request->validated('name')]);
        $this->roles->syncPermissions($role, $request->validated('selectedPermissions'));

        return redirect()->route('roles.index')
        ->with('success',  __('messages.role_permissions_updated_successfully'));
    }
}
