<?php

namespace App\Services;

use App\Repositories\ClassRepository;

class ClassService
{
    private $classRepository;

    public function __construct(ClassRepository $classRepository)
    {
        $this->classRepository = $classRepository;
    }

    public function getAllClasses()
    {
        return $this->classRepository->getAll();
    }

    public function getClassById($classId)
    {
        return $this->classRepository->getById($classId);
    }

    public function createClass(array $data)
    {
        return $this->classRepository->create($data);
    }

    public function updateClass($classId, array $data)
    {
        return $this->classRepository->update($classId, $data);
    }

    public function deleteClass($classId)
    {
        return $this->classRepository->delete($classId);
    }

    public function isUserInClass(int $userId, int $classId): bool
    {
        return $this->classRepository->isUserInClass($userId, $classId);
    }
}
