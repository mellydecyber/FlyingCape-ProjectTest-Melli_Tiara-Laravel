<?php

namespace App\Http\Controllers\Shared;

use App\Enums\Roles;
use App\Http\Controllers\BaseApiController;
use App\Services\EnrollService;
use Illuminate\Http\JsonResponse;

class EnrollController extends BaseApiController
{
    private $enrollService;

    public function __construct(EnrollService $enrollService)
    {
        $this->enrollService = $enrollService;
    }

    public function readEnrolledClasses(): JsonResponse
    {
        try {
            $user = auth()->user();
            $enrolledClasses = $this->enrollService->getEnrolledClasses($user->id, $user->role);

            return $this->sendSuccess($enrolledClasses, ['message' => 'Enrolled classes retrieved successfully']);
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve enrolled classes', $e, 500);
        }
    }
}
