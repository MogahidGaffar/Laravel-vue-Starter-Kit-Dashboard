<?php

namespace  App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:view role', ['only' => ['index']]);
        // $this->middleware('permission:create role', ['only' => ['create','store','addPermissionToRole','givePermissionToRole']]);
        // $this->middleware('permission:update role', ['only' => ['update','edit']]);
        // $this->middleware('permission:delete role', ['only' => ['destroy']]);
    }

    public function index()
    {
        $roles = Role::all();
        return Inertia('roles-permissions/Roles/index',[
            'roles'=>$roles
         ]);
    }

   


    public function create()
    {
        return Inertia('roles-permissions/Roles/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:roles,name'
            ]
        ]);

        Role::create([
            'name' => $request->name
        ]);

        
        return redirect()->route('roles.index')
            ->with('success', 'Role Saved successfully!');
    }

    public function edit(Role $role)
    {
        return Inertia('roles-permissions/Roles/Edit',[
            'role'=>$role
         ]);
      
    }

    public function update(Request $request, Role $role)
    {

        $role->update(
            $request->validate([
              'name' => [
                'required',
                'string',
                'unique:roles,name,'.$role->id
            ]
            ])
        );

        return redirect()->route('roles.index')
            ->with('success', 'Role Updated successfully!');

    }

    public function destroy($roleId)
    {
        $role = Role::find($roleId);
        $role->delete();
        return redirect()->route('roles.index')
        ->with('success', 'Role Deleted successfully!');
    }

    public function addPermissionToRole($roleId)
    {
        $permissions = Permission::get();
        $role = Role::findOrFail($roleId);
        $rolePermissions = DB::table('role_has_permissions')
        ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
        ->where('role_has_permissions.role_id', $role->id)
        ->pluck('permissions.name') // Change to 'permissions.name' to get permission names
        ->all();
    

                                return Inertia('roles-permissions/Roles/Add-permissions',[
                                    'role' => $role,
                                    'permissions' => $permissions,
                                    'rolePermissions' => $rolePermissions
                                 ]);

    }

    public function givePermissionToRole(Request $request, $roleId)
    {
        $request->validate([
            'selectedPermissions' => 'required'
        ]);

        $role = Role::findOrFail($roleId);
          $role->syncPermissions($request->selectedPermissions);
        return redirect()->route('roles.index')
        ->with('success', 'Permissions added to role!');
    }
}