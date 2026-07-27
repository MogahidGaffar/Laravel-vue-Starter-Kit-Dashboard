<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\PermissionRepositoryInterface;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;

class PermissionController extends Controller
{
    public function __construct(protected PermissionRepositoryInterface $permissions)
    {
        $this->middleware('permission:read permissions', ['only' => ['index']]);
        $this->middleware('permission:create permissions', ['only' => ['create','store']]);
        $this->middleware('permission:update permissions', ['only' => ['update','edit']]);
        $this->middleware('permission:delete permissions', ['only' => ['destroy']]);
    }

    public function index()
    {
        $permissions = $this->permissions->paginateLatest(10);
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
        $this->permissions->create([
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
         ]);
    }

    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        $this->permissions->update($permission, [
            'name' => $request->name,
        ]);

        return redirect()->route('permissions.index')
            ->with('success', __('messages.data_updated_successfully'));
    }

    public function destroy($permissionId)
    {
        $permission = $this->permissions->findOrFail((int) $permissionId);
        $this->permissions->delete($permission);
        return redirect()->route('permissions.index')
        ->with('success',  __('messages.data_deleted_successfully'));

    }
}
