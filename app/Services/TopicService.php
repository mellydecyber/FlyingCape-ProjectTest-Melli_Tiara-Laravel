<?php

namespace App\Services;

use App\Models\Topic;
use App\Repositories\TopicRepository;
use Illuminate\Database\Eloquent\Collection;

class TopicService
{
    private TopicRepository $topicRepository;

    public function __construct(TopicRepository $topicRepository)
    {
        $this->topicRepository = $topicRepository;
    }

    public function getAllTopics(): Collection
    {
        return $this->topicRepository->getAll();
    }

    public function getTopicsByTeacher(int $teacherId): Collection
    {
        return $this->topicRepository->getByTeacher($teacherId);
    }

    public function getTopicsByClass(int $classId): Collection
    {
        return $this->topicRepository->getByClass($classId);
    }

    public function getTopicById(int $topicId): ?Topic
    {
        return $this->topicRepository->getById($topicId);
    }

    public function createTopic(array $data): Topic
    {
        return $this->topicRepository->create($data);
    }

    public function updateTopic(int $topicId, array $data): ?Topic
    {
        return $this->topicRepository->update($topicId, $data);
    }

    public function deleteTopic(int $topicId): void
    {
        $this->topicRepository->delete($topicId);
    }

    public function isTopicCreatedByTeacher(int $topicId, int $teacherId): bool
    {
       return $this->topicRepository->isTopicCreatedByTeacher($topicId, $teacherId);
    }
}
