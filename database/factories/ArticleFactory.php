<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
{
    $title = $this->faker->unique()->realText(55);
    $imageUrl = "https://picsum.photos/640/480?random=" . $this->faker->numberBetween(1, 1000);

    return [
        'title' => $title,
        'slug' => Str::slug($title),
        'introduction' => $this->faker->realText(255),
        'image' => $imageUrl,
        'body' => $this->faker->text(2000),
        'status' => $this->faker->boolean(),
        'user_id' => User::all()->random()->id,
        'category_id' => Category::all()->random()->id
    ];
}
}
