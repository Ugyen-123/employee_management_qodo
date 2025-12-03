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
            'employee_id' => '123456789012',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'login' => '123456789012',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors();
        $this->assertGuest('employees');
    }

    public function test_employee_login_succeeds_with_employee_id(): void
    {
        $employee = Employee::factory()->create([
            'employee_id' => '123456789012',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'login' => '123456789012',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($employee, 'employees');
    }

    public function test_employee_login_succeeds_with_email(): void
    {
        $employee = Employee::factory()->create([
            'employee_id' => '123456789012',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'login' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($employee, 'employees');
    }
}