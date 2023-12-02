<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Classes>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'topic_id' => \App\Models\Topic::factory(),
            'user_id' => \App\Models\User::factory(),
            'comment_text' => $this->faker->paragraph,
        ];
    }
}
