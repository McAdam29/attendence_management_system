<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Application\Attendence\Model\AttendenceModel;

class AttendenceModelFactory extends Factory
{
    protected $model = AttendenceModel::class;

    public function definition()
    {
        return [
            'student_id' => \Application\Students\Model\StudentModel::factory(),
            'attendance_date' => now()->startOfWeek()->format('Y-m-d'),
            'status' => $this->faker->randomElement(['present', 'absent']),
        ];
    }
}