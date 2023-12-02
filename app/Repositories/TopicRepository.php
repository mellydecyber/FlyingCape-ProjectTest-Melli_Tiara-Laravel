<?php

namespace App\Repositories;

use App\Models\Topic;
use Illuminate\Database\Eloquent\Collection;

class TopicRepository
{
    protected $topic;

    public function __construct(Topic $topic)
    {
        $this->topic = $topic;
    }

    public function getAll(): Collection
    {
        return $this->topic->all();
    }

    public function getByTeacher(int $teacherId): Collection
    {
        return $this->topic->where('teacher_id', $teacherId)->get();
    }

    public function getByClass(int $classId): Collection
    {
        return $this->topic->where('class_id', $classId)->get();
    }

    public function getById(int $topicId): ?Topic
    {
        return $this->topic->find($topicId);
    }

    public function create(array $data): Topic
    {
        return $this->topic->create($data);
    }

    public function update(int $topicId, array $data): ?Topic
    {
        $topic = $this->topic->findOrFail($topicId);
        $topic->update($data);
        return $topic;
    }

    public function delete(int $topicId): void
    {
        $topic = $this->topic->findOrFail($topicId);
        $topic->delete();
    }

    public function isTopicCreatedByTeacher(int $topicId, int $teacherId): bool
    {
        return $this->topic->where('id', $topicId)
            ->where('teacher_id', $teacherId)
            ->exists();
    }
}
