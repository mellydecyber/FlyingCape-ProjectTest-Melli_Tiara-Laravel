<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Models\User;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers(): Collection
    {
        return $this->userRepository->getAll();
    }

    public function getUserById(int $userId): ?User
    {
        return $this->userRepository->getById($userId);
    }

    public function createUser(array $data): User
    {
        $data['password'] = bcrypt($data['password']);

        return $this->userRepository->create($data);
    }

    public function updateUser(int $userId, array $data): ?User
    {
        return $this->userRepository->update($userId, $data);
    }

    public function deleteUser(int $userId): void
    {
        $this->userRepository->delete($userId);
    }
}
