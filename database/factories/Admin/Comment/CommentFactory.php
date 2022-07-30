<?php

namespace Database\Factories\Admin\Comment;

use App\Models\Admin\Animal\Animal;
use App\Models\Admin\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin\Comment\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'body' => $this->faker->paragraph(3),
            'author_id' =>  function (){
                return User::factory()->create()->id;
            },
            'commentable_id' => 1,
            'commentable_type' =>'App\Models\Admin\Animal\Animal',

        ];
    }
}
