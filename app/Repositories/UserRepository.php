<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAll(): Collection
    {
        return $this->user->all();
    }

    public function getById($userId): ?User
    {
        return $this->user->find($userId);
    }

    public function create(array $data): User
    {
        return $this->user->create($data);
    }

    public function update($userId, array $data): ?User
    {
        $user = $this->user->findOrFail($userId);
        $user->update($data);
        return $user;
    }

    public function delete($userId): void
    {
        $user = $this->user->findOrFail($userId);
        $user->delete();
    }
}
