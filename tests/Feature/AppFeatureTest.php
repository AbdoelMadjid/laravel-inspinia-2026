<?php

namespace Tests\Feature;

use App\Models\AppFeature;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('db:seed');
    }

    public function test_admin_can_view_app_features_index(): void
    {
        $user = User::where('email', 'admin@admin.com')->first();

        $response = $this->actingAs($user)->get(route('admin.app-features.index'));

        $response->assertStatus(200);
        $response->assertSee('Fitur Apps');
        $response->assertSee('topbar_search');
    }

    public function test_admin_can_toggle_feature_status(): void
    {
        $user = User::where('email', 'admin@admin.com')->first();
        $feature = AppFeature::where('key', 'topbar_search')->first();

        $this->assertTrue($feature->is_active);

        $response = $this->actingAs($user)->patchJson(route('admin.app-features.toggle-status', $feature->id));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'is_active' => false,
        ]);

        $this->assertFalse($feature->fresh()->is_active);
    }

    public function test_admin_can_store_new_feature(): void
    {
        $user = User::where('email', 'admin@admin.com')->first();

        $response = $this->actingAs($user)->post(route('admin.app-features.store'), [
            'name' => 'Custom Widget',
            'key' => 'custom_widget',
            'category' => 'general',
            'description' => 'A custom widget test',
            'is_active' => 'on',
        ]);

        $response->assertRedirect(route('admin.app-features.index'));
        $this->assertDatabaseHas('app_features', [
            'key' => 'custom_widget',
            'is_active' => true,
        ]);
    }
}
