<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_page_renders(): void
    {
        $this->get('/admin/login')
            ->assertStatus(200)
            ->assertSee('Admin Login');
    }

    public function test_admin_login_fails_with_wrong_credentials(): void
    {
        Admin::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('correctpass'),
        ]);

        $this->post('/admin/login', [
            'email' => 'admin@example.com',
            'password' => 'wrongpass',
        ])->assertSessionHasErrors('email');
    }

    public function test_admin_login_succeeds_with_correct_credentials(): void
    {
        Admin::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('correctpass'),
        ]);

        $this->post('/admin/login', [
            'email' => 'admin@example.com',
            'password' => 'correctpass',
        ])->assertRedirect(route('admin.dashboard'));
    }
}
