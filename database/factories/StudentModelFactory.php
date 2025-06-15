<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Application\Students\Model\StudentModel;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application\Students\Model\StudentModel>
 */
class StudentModelFactory extends Factory
{
    
    protected $model = StudentModel::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'student_name' => $this->faker->name(),
            'department' => $this->faker->word(),
            'enrollment_date' => $this->faker->date(),
            'roll_no' => $this->faker->unique()->numberBetween(1000, 9999),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
