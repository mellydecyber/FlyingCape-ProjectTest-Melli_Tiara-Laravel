<?php

namespace App\Repositories;

use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Collection;

class EnrollmentRepository
{
    protected $enroll;

    public function __construct(Enrollment $enroll)
    {
        $this->enroll = $enroll;
    }

    public function isUserEnrolled(int $classId, int $userId): bool
    {
        return $this->enroll->where('class_id', $classId)
            ->where('user_id', $userId)
            ->exists();
    }

    public function updateEnrollment(int $enrollmentId, array $data)
    {
        $enrollment = $this->enroll->find($enrollmentId);

        if (!$enrollment) {
            throw new \Exception('Enrollment not found.');
        }

        $enrollment->update($data);

        return $enrollment;
    }

    public function revokeEnrollment(int $classId, int $userId)
    {
        $enrollment = $this->enroll->where('class_id', $classId)
            ->where('user_id', $userId)
            ->first();

        if ($enrollment) {
            $enrollment->delete();
        }
    }

    public function getEnrolledClasses(int $userId, string $role): Collection
    {
        return $this->enroll->where('user_id', $userId)
            ->where('role', $role)
            ->with(['class' => function ($query) {
                $query->select('id', 'name', 'description');
            }])
            ->select(['id', 'role', 'class_id'])
            ->get();
    }
}
