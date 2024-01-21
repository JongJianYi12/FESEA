<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $lname = $this->faker->lastName;
        $fname = $this->faker->firstName;
        return [
            //id name gender email yearOfStudy fingerId created_at updated_at
            //generate UUID

            //'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(), //uuid
            //generate names
            'name' => $fname . ' ' . $lname,
            'gender' => $this->faker->randomElement(["F","M"]),
            'examno' => $this->faker->unique()->regexify('[A-Z]{3}[1-9]{6}[A-Z]{3}'),
            'email' => $fname . '' . $lname . '@outlook.org',
            //'email' => $this->faker->unique()->safeEmail,
            'yearOfStudy' => $this->faker->randomElement(["1","2","3","4"]),
            'created_at' => $this->faker->dateTimeBetween('-4 months', $this->faker->dateTimeBetween('-3 month', '-2 month')),
            'updated_at' => $this->faker->dateTimeBetween('-1 month', '+1 month'),

        ];
    }
}
