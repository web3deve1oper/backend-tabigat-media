<?php

namespace Database\Factories;

use App\Models\RedBook;
use Illuminate\Database\Eloquent\Factories\Factory;

class RedBookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RedBook::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->city,
            'name_latin' => $this->faker->country,
            'domain' => $this->faker->streetName,
            'type' => $this->faker->streetAddress,
            'class' => $this->faker->streetSuffix,
            'squad' => $this->faker->streetSuffix,
            'family' => $this->faker->colorName,
            'genus' => $this->faker->address,
            'kind' => $this->faker->timezone,
            'content' => $this->faker->text,
            'status' => [],
            'facts' => [],
        ];
    }
}
