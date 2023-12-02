<?php

namespace App\Services;

use App\Repositories\CommentRepository;
use App\Repositories\TopicRepository;

class CommentService
{
    private $commentRepository;
    private $topicRepository;

    public function __construct(CommentRepository $commentRepository, TopicRepository $topicRepository)
    {
        $this->commentRepository = $commentRepository;
        $this->topicRepository = $topicRepository;
    }

    public function addCommentToTopic(int $topicId, array $commentData)
    {
        $topic = $this->topicRepository->getById($topicId);

        return $this->commentRepository->createCommentForTopic($topic, $commentData);
    }

    public function getCommentsByTopic(int $topicId)
    {
        $topic = $this->topicRepository->getById($topicId);

        return $this->commentRepository->getCommentsByTopic($topic);
    }
}
