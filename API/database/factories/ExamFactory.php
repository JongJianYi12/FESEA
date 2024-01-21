<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {



        return [
            //

            'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(), //uuid
            'title' => $this->faker->randomElement(['Course X', 'Course Y', 'Course Z']),
            'venue' => $this->faker->randomElement(['Hall C', 'Hall B', 'Hall A']),
            'date' => $this->faker->dateTimeBetween('-4 months', $this->faker->dateTimeBetween('-3 month', '-2 month')),
            'time' => $this->faker->time,
            'duration' => $this->faker->randomElement(['1 hour', '2 hours', '3 hours']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
