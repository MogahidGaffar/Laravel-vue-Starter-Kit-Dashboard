<?php

namespace App\Repositories\Eloquent;

use App\Models\Log;
use App\Repositories\Contracts\LogRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class LogRepository extends BaseRepository implements LogRepositoryInterface
{
    public function __construct(Log $model)
    {
        parent::__construct($model);
    }

    public function paginateFiltered(array $filters, int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->query()->with('user')->latest();

        if (! empty($filters['module_name'])) {
            $query->where('module_name', $filters['module_name']);
        }

        if (! empty($filters['action'])) {
            $query->where('action', $filters['action']);
        }

        if (! empty($filters['by_user_id'])) {
            $query->where('by_user_id', $filters['by_user_id']);
        }

        return $query->paginate($perPage);
    }
}
