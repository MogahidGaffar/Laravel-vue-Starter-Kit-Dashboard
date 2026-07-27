<?php

namespace App\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;

interface PermissionRepositoryInterface extends BaseRepositoryInterface
{
    public function paginateLatest(int $perPage = 10): LengthAwarePaginator;
}
