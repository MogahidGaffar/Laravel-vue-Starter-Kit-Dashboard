<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    public function latestAll(): Collection;

    /**
     * @return array<string, string>
     */
    public function pluckNames(): array;

    /**
     * Names of the permissions currently assigned to the given role.
     *
     * @return array<int, string>
     */
    public function getAssignedPermissionNames(Role $role): array;

    public function syncPermissions(Role $role, array $permissions): void;
}
