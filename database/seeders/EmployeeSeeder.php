<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        Employee::updateOrCreate(
            ['employee_id' => 'E1001'],
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'position' => 'Engineer',
                'salary' => 75000,
                'password' => Hash::make('password'),
            ]
        );
    }
}
