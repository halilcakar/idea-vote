<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Idea;
use App\Models\Comment;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'idea_id' => Idea::factory(),
            'body' => $this->faker->paragraph(5),
        ];
    }

    public function existing()
    {
        return $this->state(fn (): array => [
            'user_id' => $this->faker->numberBetween(1, 20),
        ]);
    }
}
