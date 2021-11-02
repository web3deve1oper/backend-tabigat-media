<?php

namespace Database\Factories;

use App\Models\Rubric;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class RubricFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Rubric::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    private $autoIncrement = null;

    public function definition()
    {
        if ($this->autoIncrement == null) {
            $this->autoIncrement = $this->autoincrement();
        }
        $order = (int) $this->autoIncrement->current();

        $this->autoIncrement->next();

        return [
            'title' => str_replace('.','',$this->faker->text('10')),
            'is_preferable' => false,
            'order' => $order,
            'type' => $this->faker->randomElement(['default-view','fluid-view','red-book','solo-view','staggered-view'])
        ];
    }

    public function autoincrement()
    {
        for ($i =1; $i < $this->count; $i++) {
            yield $i;
        }
    }
}
