<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use App\Models\Topic;
use App\Models\Comment;
use App\Models\User;
use App\Repositories\CommentRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateCommentForTopic()
    {
        $topic = Topic::factory()->create();
        $user = User::factory()->create();
        $commentRepository = new CommentRepository(new Comment());

        $commentData = ['comment_text' => 'Test Comment', 'user_id' => $user->id];
        $comment = $commentRepository->createCommentForTopic($topic, $commentData);

        $this->assertInstanceOf(Comment::class, $comment);
        $this->assertEquals('Test Comment', $comment->comment_text);
        $this->assertEquals($topic->id, $comment->topic_id);
    }

    public function testGetCommentsByTopic()
    {
        $topic = Topic::factory()->create();
        Comment::factory(3)->create(['topic_id' => $topic->id]);

        $commentRepository = new CommentRepository(new Comment());
        $comments = $commentRepository->getCommentsByTopic($topic);

        $this->assertCount(3, $comments);
        $this->assertInstanceOf(Comment::class, $comments->first());
        $this->assertArrayHasKey('user', $comments->first()->toArray());
    }
}
