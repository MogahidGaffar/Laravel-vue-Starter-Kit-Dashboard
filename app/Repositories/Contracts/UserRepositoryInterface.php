<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Paginate users, applying the name/email/is_active filters used by the Users index page.
     */
    public function paginateFiltered(array $filters, int $perPage = 10): LengthAwarePaginator;

    public function latestAll(): Collection;

    public function syncRoles(User $user, array $roles): void;
}
