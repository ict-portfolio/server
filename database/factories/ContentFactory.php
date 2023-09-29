<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Content>
 */
class ContentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->name();
        return [
            "category_id" => fake()->numberBetween(1,3),
            "image_id" => fake()->numberBetween(1,3),
            "name" => $name,
            "slug" => Str::slug($name),
            "description" => fake()->text(),
            "paragraph" => fake()->text(),
            "status" => random_int(0,1),
        ];
    }
}
