<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserImpersonationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_impersonate_user_and_return_to_original_account(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        $admin = User::factory()->create(['name' => 'Admin User']);
        $admin->assignRole($adminRole);

        $targetUser = User::factory()->create(['name' => 'Target User']);
        $targetUser->assignRole($userRole);

        // 1. Admin logs in and impersonates target user
        $response = $this->actingAs($admin)
            ->post(route('admin.users.impersonate', $targetUser->id));

        $response->assertRedirect(route('dashboard'));
        $this->assertEquals($targetUser->id, auth()->id());
        $this->assertEquals($admin->id, session('impersonator_id'));

        // Assert target user got 0 points from impersonation
        $this->assertEquals(0, $targetUser->fresh()->points);
        $this->assertDatabaseHas('login_logs', [
            'user_id' => $targetUser->id,
            'points_awarded' => 0,
        ]);

        // 2. Impersonated user stops impersonation and returns to admin
        $stopResponse = $this->post(route('admin.users.impersonate-stop'));

        $stopResponse->assertRedirect(route('admin.users.index'));
        $this->assertEquals($admin->id, auth()->id());
        $this->assertFalse(session()->has('impersonator_id'));

        // Assert admin got 0 points from stopping impersonation
        $this->assertEquals(0, $admin->fresh()->points);
    }

    public function test_impersonation_does_not_award_points_and_direct_login_does(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        $admin = User::factory()->create(['name' => 'Admin User']);
        $admin->assignRole($adminRole);

        $targetUser = User::factory()->create([
            'name' => 'Target User',
            'email' => 'target@example.com',
            'password' => bcrypt('password123'),
            'points' => 0,
        ]);
        $targetUser->assignRole($userRole);

        // Admin switches to target user
        $this->actingAs($admin)
            ->post(route('admin.users.impersonate', $targetUser->id));

        $this->assertEquals(0, $targetUser->fresh()->points);

        // Clear session to simulate target user logging in directly from their own browser
        session()->forget('impersonator_id');
        auth()->logout();

        // Target user logs in directly with credentials
        $loginResponse = $this->post('/login', [
            'login' => 'target@example.com',
            'password' => 'password123',
        ]);

        $loginResponse->assertRedirect(route('dashboard'));
        // Direct login MUST award 1 point
        $this->assertEquals(1, $targetUser->fresh()->points);
        $this->assertDatabaseHas('login_logs', [
            'user_id' => $targetUser->id,
            'points_awarded' => 1,
        ]);
    }

    public function test_user_cannot_impersonate_themselves(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $admin = User::factory()->create(['name' => 'Admin User']);
        $admin->assignRole($adminRole);

        $response = $this->actingAs($admin)
            ->post(route('admin.users.impersonate', $admin->id));

        $response->assertSessionHas('error');
        $this->assertEquals($admin->id, auth()->id());
        $this->assertFalse(session()->has('impersonator_id'));
    }
}
