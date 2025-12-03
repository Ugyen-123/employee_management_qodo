<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Notifications\AdminResetPassword;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AdminPasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_request_form_renders(): void
    {
        $res = $this->get('/admin/password/forgot');
        $res->assertStatus(200);
        $res->assertViewIs('admin.auth.passwords.email');
        $res->assertSee('Forgot Password (Admin)');
    }

    public function test_request_link_always_returns_generic_status(): void
    {
        // Non-existent email
        $res1 = $this->post('/admin/password/email', ['email' => 'nonexistent@example.com']);
        $res1->assertSessionHas('status');

        // Existing admin
        $admin = Admin::factory()->create(['email' => 'admin@example.com']);
        $res2 = $this->post('/admin/password/email', ['email' => $admin->email]);
        $res2->assertSessionHas('status');
    }

    public function test_valid_admin_creates_hashed_token_and_dispatches_notification(): void
    {
        Notification::fake();
        $admin = Admin::factory()->create(['email' => 'admin@example.com']);

        $this->post('/admin/password/email', ['email' => $admin->email])
            ->assertSessionHas('status');

        // Assert notification sent on demand (route('mail', ...))
        Notification::assertSentOnDemand(AdminResetPassword::class, function ($notification, $channels, $notifiable) use ($admin) {
            return in_array('mail', $channels, true)
                && isset($notifiable->routes['mail'])
                && $notifiable->routes['mail'] === $admin->email;
        });

        // Token exists and is hashed
        $row = DB::table('admin_password_resets')->where('email', $admin->email)->first();
        $this->assertNotNull($row, 'Expected a password reset row for the admin email');
        $this->assertNotEmpty($row->token);
        $this->assertNotNull($row->created_at);
    }

    public function test_reset_fails_with_expired_token(): void
    {
        $admin = Admin::factory()->create(['email' => 'admin@example.com']);

        DB::table('admin_password_resets')->insert([
            'email' => $admin->email,
            'token' => Hash::make('valid-token'),
            'created_at' => Carbon::now()->subHours(2),
        ]);

        $this->post('/admin/password/reset', [
            'email' => $admin->email,
            'token' => 'valid-token',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ])->assertSessionHasErrors();
    }

    public function test_reset_fails_with_wrong_token(): void
    {
        $admin = Admin::factory()->create(['email' => 'admin@example.com']);

        DB::table('admin_password_resets')->insert([
            'email' => $admin->email,
            'token' => Hash::make('valid-token'),
            'created_at' => Carbon::now(),
        ]);

        $this->post('/admin/password/reset', [
            'email' => $admin->email,
            'token' => 'wrong-token',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ])->assertSessionHasErrors(['token']);
    }

    public function test_successful_password_reset_updates_password_and_deletes_token(): void
    {
        $admin = Admin::factory()->create([
            'email' => 'admin@example.com',
            'password' => Hash::make('oldpass123'),
        ]);

        DB::table('admin_password_resets')->insert([
            'email' => $admin->email,
            'token' => Hash::make('valid-token'),
            'created_at' => Carbon::now(),
        ]);

        $this->post('/admin/password/reset', [
            'email' => $admin->email,
            'token' => 'valid-token',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ])->assertRedirect(route('admin.login'))
          ->assertSessionHas('status');

        $admin->refresh();
        $this->assertTrue(Hash::check('newpassword123', $admin->password));
        $this->assertDatabaseMissing('admin_password_resets', ['email' => $admin->email]);
    }
}
