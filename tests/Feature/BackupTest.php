<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class BackupTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_generate_full_backup_with_drop_database(): void
    {
        Storage::fake('local');

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $admin = User::factory()->create(['name' => 'Admin User']);
        $admin->assignRole($adminRole);

        $response = $this->actingAs($admin)
            ->post(route('admin.backups.store'), [
                'backup_type' => 'all',
            ]);

        $response->assertRedirect(route('admin.backups.index'));
        $response->assertSessionHas('success');

        $files = Storage::disk('local')->files('backups');
        $this->assertNotEmpty($files);

        $sqlContent = Storage::disk('local')->get($files[0]);
        $dbName = config('database.connections.' . config('database.default') . '.database');

        if (!empty($dbName)) {
            $this->assertStringContainsString("DROP DATABASE IF EXISTS `{$dbName}`;", $sqlContent);
            $this->assertStringContainsString("CREATE DATABASE IF NOT EXISTS `{$dbName}`", $sqlContent);
            $this->assertStringContainsString("USE `{$dbName}`;", $sqlContent);
        }

        $this->assertStringContainsString("DROP TABLE IF EXISTS", $sqlContent);
    }
}
