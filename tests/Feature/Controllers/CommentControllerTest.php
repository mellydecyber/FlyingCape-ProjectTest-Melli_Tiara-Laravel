<?php
// tests/Feature/Controllers/CommentControllerTest.php

namespace Tests\Feature\Controllers;

use App\Enums\Roles;
use Tests\TestCase;
use App\Models\User;
use App\Models\Topic;
use App\Http\Controllers\Shared\CommentController;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Services\CommentService;
use App\Services\TopicService;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected CommentService $commentServiceMock;
    protected TopicService $topicServiceMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commentServiceMock = $this->getMockBuilder(CommentService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->topicServiceMock = $this->getMockBuilder(TopicService::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testStoreCommentSuccessfully()
    {
        $user = User::factory()->create(['role' => Roles::TEACHER]);
        $topic = Topic::factory()->create();
        $commentData = ['comment_text' => $this->faker->sentence,'user_id' => $user->id];

        $this->actingAs($user);

        /** @var CommentRequest|MockObject */
        $request = $this->mock(CommentRequest::class);
        $request->shouldReceive('validated')->andReturn($commentData);

        $response = $this->postJson(route('teacher.comment.store', ['topicId' => $topic->id]), $commentData);

        $response->assertStatus(201);

        $response->assertJson([
            "status" => true,
            "data" => [],
            "metadata" => [
                "message"=> "Comment added successfully"
            ]
        ]);
    }

    public function testStoreCommentWithInvalidTopicId()
    {
        $user = User::factory()->create(['role' => Roles::TEACHER]);
        $invalidTopicId = 999;
        $commentData = ['comment_text' => $this->faker->sentence];

        $this->actingAs($user);

        $response = $this->postJson(route('teacher.comment.store', ['topicId' => $invalidTopicId]), $commentData);

        $response->assertStatus(404);
    }

    public function testGetCommentsByTopicSuccessfully()
    {
        $user = User::factory()->create(['role' => Roles::TEACHER]);
        $topic = Topic::factory()->create();
        Comment::factory(3)->create(['topic_id' => $topic->id]);

        $this->actingAs($user);

        $response = $this->get(route('teacher.comment.get', ['topicId' => $topic->id]));

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    public function testGetCommentsByTopicWithInvalidTopicId()
    {
        $user = User::factory()->create(['role' => Roles::TEACHER]);
        $invalidTopicId = 999;

        $this->actingAs($user);

        $response = $this->get(route('teacher.comment.get', ['topicId' => $invalidTopicId]));

        $response->assertStatus(404);
    }
}
