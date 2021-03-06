<?php

namespace Database\Factories;

use Illuminate\Http\File;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $random = rand();
        if($random >=getrandmax()/2) {
            return [
                'body' => $this->faker->sentence(20), 
                'img' => $this->faker->imageUrl(rand(30, 3000), rand(30, 3000)),
            ];
        }
        else {
            return [
                'body' => $this->faker->sentence(20), 
                //'img' => $this->faker->imageUrl(),
            ];
        }
    }
}
