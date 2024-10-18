<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\StorePermissionRequest; 
use App\Http\Requests\UpdatePermissionRequest;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read permissions', ['only' => ['index']]);
        $this->middleware('permission:create permissions', ['only' => ['create','store']]);
        $this->middleware('permission:update permissions', ['only' => ['update','edit']]);
        $this->middleware('permission:delete permissions', ['only' => ['destroy']]);
    }

    public function index()
    {
        $permissions = Permission::latest()->paginate(10);
        return Inertia('roles-permissions/Permissions/index',[
            'translations' => __('messages'),
              'permissions'=>$permissions
         ]);
    }

    public function create()
    {
        return Inertia('roles-permissions/Permissions/Create',[     'translations' => __('messages')]);
    }

    public function store(StorePermissionRequest $request)
    {
        Permission::create([
            'name' => $request->name
        ]);
    
        return redirect()->route('permissions.index')
            ->with('success', __('messages.data_saved_successfully'));
    }
    public function edit(Permission $permission)
    {
        return Inertia('roles-permissions/Permissions/Edit',[
            'translations' => __('messages'),
             'permission'=>$permission
         ]); }

         public function update(UpdatePermissionRequest $request, Permission $permission)
         {
             $permission->update([
                 'name' => $request->name,
             ]);
         
             return redirect()->route('permissions.index')
                 ->with('success', __('messages.data_updated_successfully'));
         }
    public function destroy($permissionId)
    {
        $permission = Permission::find($permissionId);
        $permission->delete();
        return redirect()->route('permissions.index')
        ->with('success',  __('messages.data_deleted_successfully'));

    }
}