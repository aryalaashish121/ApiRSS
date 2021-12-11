<?php

namespace Database\Factories;

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
        return [
            'title'=>$this->faker->sentence,
            'author'=>$this->faker->name,
            'description'=>$this->faker->text,
            'category_id'=>rand(1,4),
            'is_live'=>rand(1,0),
        ];
    }
}
