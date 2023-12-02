<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\EnrollUserRequest;
use App\Services\EnrollService;
use Illuminate\Http\JsonResponse;

class EnrollController extends BaseApiController
{
    private EnrollService $enrollService;

    public function __construct(EnrollService $enrollService)
    {
        $this->enrollService = $enrollService;
    }

    public function enrollUser(EnrollUserRequest $request): JsonResponse
    {
        try {
            $classId = $request->input('class_id');
            $userId = $request->input('user_id');
            $role = $request->input('role');

            $this->enrollService->enrollUser($classId, $userId, $role);

            return $this->sendSuccess([], ['message' => 'User enrolled successfully']);
        } catch (\Exception $e) {
            return $this->sendError('Enrollment failed', $e, 500);
        }
    }

    public function revokeEnrollment($classId, $userId): JsonResponse
    {
        $this->enrollService->revokeEnrollment($classId, $userId);

        return $this->sendSuccess([], ['message' => 'Enrollment revoked successfully']);
    }

    public function updateEnrollment(EnrollUserRequest $request, $enrollmentId): JsonResponse
    {
        try {
            $data = $request->validated(); // Assuming you are using form request validation

            $enroll = $this->enrollService->updateEnrollment($enrollmentId, $data);

            return $this->sendSuccess($enroll, ['message' => 'Enrollment updated successfully']);
        } catch (\Exception $e) {
            return $this->sendError('Enrollment update failed', $e, 500);
        }
    }
}
