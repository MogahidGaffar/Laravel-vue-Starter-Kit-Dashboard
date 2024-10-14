<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:view permission', ['only' => ['index']]);
        // $this->middleware('permission:create permission', ['only' => ['create','store']]);
        // $this->middleware('permission:update permission', ['only' => ['update','edit']]);
        // $this->middleware('permission:delete permission', ['only' => ['destroy']]);
    }

    public function index()
    {
        $permissions = Permission::latest()->paginate(10);
        return Inertia('roles-permissions/Permissions/index',[
            'permissions'=>$permissions
         ]);
    }

    public function create()
    {
        return Inertia('roles-permissions/Permissions/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name'
            ]
        ]);

        Permission::create([
            'name' => $request->name
        ]);

        return redirect()->route('permissions.index')
            ->with('success', 'Permission Saved successfully!');
    }

    public function edit(Permission $permission)
    {
        return Inertia('roles-permissions/Permissions/Edit',[
            'permission'=>$permission
         ]); }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name,'.$permission->id
            ]
        ]);

        $permission->update([
            'name' => $request->name
        ]);

        return redirect()->route('permissions.index')
            ->with('success', 'Permission Updated successfully!');
    }

    public function destroy($permissionId)
    {
        $permission = Permission::find($permissionId);
        $permission->delete();
        return redirect()->route('permissions.index')
        ->with('success', 'Permission Deleted Successfully!');

    }
}