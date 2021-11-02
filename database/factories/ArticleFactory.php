<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'author_id' => rand(1, 10),
            'rubric_id' => rand(1, 10),
            'title' => $this->faker->text(50),
            'description' => $this->faker->text(100),
            'content' => $this->faker->text(300),
            'is_long_read' => $this->faker->randomElement([true, false]),
            'posted_at' => $this->faker->dateTime,
            'read_time' => $this->faker->numberBetween(5, 20),
            'photography' => $this->faker->company,
            'views' => $this->faker->numberBetween(1, 10000000),
            'staff' => json_encode(['lol' => 'kek']),
        ];
    }
}
