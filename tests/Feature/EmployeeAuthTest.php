<?php

namespace Tests\Feature;

use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmployeeAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_employee_login_page_renders(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function test_employee_login_fails_with_wrong_credentials(): void
    {
        $employee = Employee::factory()->create([
            'employee_id' => '123456789012', // 12 digits
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'employee_id' => '123456789012',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest('employees');
    }

    public function test_employee_login_succeeds_with_correct_credentials(): void
    {
        $employee = Employee::factory()->create([
            'employee_id' => '123456789012', // 12 digits
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'employee_id' => '123456789012',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($employee, 'employees');
    }
}