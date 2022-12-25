<?php

namespace Database\Factories;

use App\Models\Positions;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Positions>
 */
class PositionsFactory extends Factory
{
    protected $model = Positions::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "title" => $this->faker->jobTitle(),
            "status" => 1,
        ];
    }
}
