<?php

namespace App\Repositories;

use App\Models\Classes;
use Illuminate\Database\Eloquent\Collection;

class ClassRepository
{
    protected $class;

    public function __construct(Classes $class)
    {
        $this->class = $class;
    }

    public function getAll(): Collection
    {
        return $this->class->all();
    }

    public function getById($classId): ?Classes
    {
        return $this->class->find($classId);
    }

    public function create(array $data): Classes
    {
        return $this->class->create($data);
    }

    public function update($classId, array $data): ?Classes
    {
        $class = $this->class->findOrFail($classId);
        $class->update($data);
        return $class;
    }

    public function delete($classId): void
    {
        $class = $this->class->findOrFail($classId);
        $class->delete();
    }

    public function isUserInClass(int $teacherId, int $classId): bool
    {
        // Check if the teacher with the specified ID is associated with the class
        return $this->class->where('id', $classId)
            ->whereHas('user', function ($query) use ($teacherId) {
                $query->where('users.id', $teacherId);
            })
            ->exists();
    }
}
