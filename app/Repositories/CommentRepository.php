<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Topic;

class CommentRepository
{
    protected $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function createCommentForTopic(Topic $topic, array $data)
    {
        return $topic->comments()->create($data);
    }

    public function getCommentsByTopic(Topic $topic)
    {
        return $topic->comments()->with('user')
            ->with(['user' => function ($q) {
                $q->select(['id', 'name', 'email', 'role']);
            }])
            ->get();
    }
}
