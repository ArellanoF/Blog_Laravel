<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {   
        $name = $this->faker->unique()->word(10);
        $imageUrl = "https://picsum.photos/640/480?random=" . $this->faker->numberBetween(1, 1000);
    
        return [
           'name' => $name,
           'slug' => Str::slug($name),
           'image' => $imageUrl,
           'is_featured' => $this->faker->boolean(),
           'status' => $this->faker->boolean(),
        ];
    }
    
}
