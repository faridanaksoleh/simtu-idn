<?php

namespace Database\Factories;

use App\Models\ConsultationNote;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConsultationNoteFactory extends Factory
{
    protected $model = ConsultationNote::class;

    public function definition(): array
    {
        $students = User::where('role', 'mahasiswa')->pluck('id');
        $coordinators = User::where('role', 'koordinator')->pluck('id');

        return [
            'student_id' => $this->faker->randomElement($students),
            'coordinator_id' => $this->faker->randomElement($coordinators),
            'subject' => $this->faker->sentence(6),
            'message' => $this->faker->paragraph(3),
            'response' => $this->faker->optional()->paragraph(2),
            'status' => $this->faker->randomElement(['pending', 'replied', 'closed']),
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}