<?php

namespace Database\Factories;

use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Classes>
 */
class TopicFactory extends Factory
{
    protected $model = Topic::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'class_id' => \App\Models\Classes::factory(),
            'topic_name' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'teacher_id' => \App\Models\User::factory(),
        ];
    }
}
