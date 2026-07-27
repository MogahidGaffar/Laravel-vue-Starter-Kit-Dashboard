<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function paginateFiltered(array $filters, int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->query()->with('roles')->latest();

        $query->when($filters['name'] ?? null, function ($query, $name) {
            $query->where('name', 'LIKE', "%{$name}%");
        });

        $query->when($filters['email'] ?? null, function ($query, $email) {
            $query->where('email', 'LIKE', "%{$email}%");
        });

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        return $query->paginate($perPage);
    }

    public function latestAll(): Collection
    {
        return $this->query()->latest()->get();
    }

    public function syncRoles(User $user, array $roles): void
    {
        $user->syncRoles($roles);
    }
}
