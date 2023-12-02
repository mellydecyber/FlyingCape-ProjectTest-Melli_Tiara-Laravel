<?php

namespace App\Http\Controllers\Shared;

use App\Http\Controllers\BaseApiController;
use App\Http\Requests\CommentRequest;
use App\Services\CommentService;
use App\Services\TopicService;
use Illuminate\Http\JsonResponse;

class CommentController extends BaseApiController
{
    private CommentService $commentService;
    private TopicService $topicService;

    public function __construct(CommentService $commentService, TopicService $topicService)
    {
        $this->commentService = $commentService;
        $this->topicService = $topicService;
    }

    public function store(CommentRequest $request, $topicId): JsonResponse
    {
        if (is_null($this->topicService->getTopicById($topicId))) {
            return $this->sendError('Topic not found', null, 404);
        }

        $userId = auth()->user()->id;
        $commentData = array_merge($request->validated(), ['user_id' => $userId]);

        $this->commentService->addCommentToTopic($topicId, $commentData);

        return $this->sendSuccess(
            [],
            ['message' => 'Comment added successfully'],
            201
        );
    }

    public function getCommentsByTopic($topicId): JsonResponse
    {
        if (is_null($this->topicService->getTopicById($topicId))) {
            return $this->sendError('Topic not found', null, 404);
        }

        $comments = $this->commentService->getCommentsByTopic($topicId);

        return $this->sendSuccess(
            $comments,
            ['message' => 'Get Comment by Topic'],
            201
        );
    }
}
