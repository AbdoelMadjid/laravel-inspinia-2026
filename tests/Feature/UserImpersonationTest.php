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

        // 2. Impersonated user stops impersonation and returns to admin
        $stopResponse = $this->post(route('admin.users.impersonate-stop'));

        $stopResponse->assertRedirect(route('admin.users.index'));
        $this->assertEquals($admin->id, auth()->id());
        $this->assertFalse(session()->has('impersonator_id'));
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
