<?php

namespace App\Services;

use App\Enums\Roles;
use App\Repositories\ClassRepository;
use App\Repositories\EnrollmentRepository;

class EnrollService
{
    private $classRepository;
    private $enrollmentRepository;

    public function __construct(
        ClassRepository $classRepository,
        EnrollmentRepository $enrollmentRepository
    ) {
        $this->classRepository = $classRepository;
        $this->enrollmentRepository = $enrollmentRepository;
    }

    public function enrollUser(int $classId, int $userId, string $role)
    {
        $class = $this->classRepository->getById($classId);

        // Check if the user is already enrolled in the class
        if ($this->enrollmentRepository->isUserEnrolled($classId, $userId)) {
            throw new \Exception('User is already enrolled in the class.');
        }

        // Enroll the user based on the role
        if ($role === Roles::STUDENT) {
            $class->students()->attach($userId);
        } elseif ($role === Roles::TEACHER) {
            $class->teachers()->attach($userId);
        } else {
            throw new \InvalidArgumentException('Invalid role. Supported roles are student or teacher.');
        }
    }

    public function updateEnrollment(int $enrollmentId, array $data)
    {
        return $this->enrollmentRepository->updateEnrollment($enrollmentId, $data);
    }

    public function revokeEnrollment(int $classId, int $userId)
    {
        return $this->enrollmentRepository->revokeEnrollment($classId, $userId);
    }

    public function getEnrolledClasses(int $userId, $role)
    {
        return $this->enrollmentRepository->getEnrolledClasses($userId, $role);
    }
}
