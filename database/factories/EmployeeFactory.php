<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        return [
            'employee_id' => $this->faker->unique()->numerify('############'), // 12 digits
            'name' => $this->faker->name(), // Add the name field
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }
}