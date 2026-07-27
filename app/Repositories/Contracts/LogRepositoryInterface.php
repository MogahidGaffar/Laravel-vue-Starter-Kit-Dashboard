<?php

namespace App\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;

interface LogRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * Paginate logs, applying the module_name/action/by_user_id filters used by the Logs index page.
     */
    public function paginateFiltered(array $filters, int $perPage = 10): LengthAwarePaginator;
}
