<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\BaseApiController;
use App\Services\ClassService;
use App\Services\TopicService;
use Illuminate\Http\JsonResponse;

class TopicController extends BaseApiController
{
    private TopicService $topicService;
    private ClassService $classService;

    public function __construct(TopicService $topicService, ClassService $classService)
    {
        $this->topicService = $topicService;
        $this->classService = $classService;
    }

    public function getTopicByClass($classId): JsonResponse
    {
        if (is_null($this->classService->getClassById($classId))) {
            return $this->sendError('Class not found', null, 404);
        }

        $studentId = auth()->user()->id;

        if (!$this->classService->isUserInClass($studentId, $classId)) {
            return $this->sendError('Student not in this class', null, 403);
        }

        $topics = $this->topicService->getTopicsByClass($classId);
        return $this->sendSuccess($topics, ['message' => 'List all Topic by Class']);
    }
}
