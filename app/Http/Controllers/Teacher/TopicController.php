<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\TopicRequest;
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

    public function index(): JsonResponse
    {
        $topics = $this->topicService->getAllTopics();
        return $this->sendSuccess($topics, ['message' => 'List all Topic']);
    }

    public function getTopicByTeacher(): JsonResponse
    {
        $teacherId = auth()->user()->id;
        $topics = $this->topicService->getTopicsByTeacher($teacherId);
        return $this->sendSuccess($topics, ['message' => 'List all Topic by Teacher']);
    }

    public function getTopicByClass($classId): JsonResponse
    {
        if (is_null($this->classService->getClassById($classId))) {
            return $this->sendError('Class not found', null, 404);
        }

        $topics = $this->topicService->getTopicsByClass($classId);
        return $this->sendSuccess($topics, ['message' => 'List all Topic by Class']);
    }

    public function show(int $topicId): JsonResponse
    {
        $topic = $this->topicService->getTopicById($topicId);
        return $this->sendSuccess($topic, ['message' => 'Detail Topic']);
    }

    public function store(TopicRequest $request): JsonResponse
    {
        $classId = $request->input('class_id');
        $teacherId = auth()->user()->id;

        // Check if the teacher is associated with the specified class
        if (!$this->classService->isUserInClass($teacherId, $classId)) {
            return $this->sendError('Unauthorized', null, 403);
        }

        $data = array_merge($request->validated(), ['teacher_id' => $teacherId]);

        $topic = $this->topicService->createTopic($data);
        return $this->sendSuccess(
            $topic,
            ['message' => 'Topic created successfully'],
            201
        );
    }

    public function update(TopicRequest $request, int $topicId): JsonResponse
    {
        $teacherId = auth()->user()->id;

        if (is_null($this->topicService->getTopicById($topicId))) {
            return $this->sendError('Topic not found', null, 404);
        }

        // Check if the authenticated user is the original teacher who created the topic
        if (!$this->topicService->isTopicCreatedByTeacher($topicId, $teacherId)) {
            return $this->sendError('Unauthorized', null, 403);
        }

        $topic = $this->topicService->updateTopic($topicId, $request->validated());
        return $this->sendSuccess($topic, ['message' => 'Topic updated successfully']);
    }

    public function destroy(int $topicId): JsonResponse
    {
        $teacherId = auth()->user()->id;

        if (is_null($this->topicService->getTopicById($topicId))) {
            return $this->sendError('Topic not found', null, 404);
        }

        // Check if the authenticated user is the original teacher who created the topic
        if (!$this->topicService->isTopicCreatedByTeacher($topicId, $teacherId)) {
            return $this->sendError('Unauthorized', null, 403);
        }

        $this->topicService->deleteTopic($topicId);
        return $this->sendSuccess([], ['message' => 'Topic deleted successfully']);
    }
}
