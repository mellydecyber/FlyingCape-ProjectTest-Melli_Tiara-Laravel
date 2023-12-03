<?php
// tests/Unit/Services/CommentServiceTest.php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\CommentService;
use App\Repositories\CommentRepository;
use App\Repositories\TopicRepository;
use App\Models\Topic;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testAddCommentToTopic()
    {
        $topicId = 1;
        $commentData = ['content' => 'Test Comment'];

        /** @var TopicRepository|MockObject */
        $topicRepository = $this->getMockBuilder(TopicRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $topicRepository->expects($this->once())
            ->method('getById')
            ->with($topicId)
            ->willReturn(new Topic());

        /** @var CommentRepository|MockObject */
        $commentRepository = $this->getMockBuilder(CommentRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $commentRepository->expects($this->once())
            ->method('createCommentForTopic')
            ->willReturn(new Comment());

        $commentService = new CommentService($commentRepository, $topicRepository);
        $commentService->addCommentToTopic($topicId, $commentData);
    }

    public function testGetCommentsByTopic()
    {
        $topicId = 1;

        /** @var TopicRepository|MockObject */
        $topicRepository = $this->getMockBuilder(TopicRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $topicRepository->expects($this->once())
            ->method('getById')
            ->with($topicId)
            ->willReturn(new Topic());

        /** @var CommentRepository|MockObject */
        $commentRepository = $this->getMockBuilder(CommentRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $commentRepository->expects($this->once())
            ->method('getCommentsByTopic')
            ->willReturn(collect([new Comment()]));

        $commentService = new CommentService($commentRepository, $topicRepository);
        $comments = $commentService->getCommentsByTopic($topicId);

        $this->assertCount(1, $comments);
    }
}
