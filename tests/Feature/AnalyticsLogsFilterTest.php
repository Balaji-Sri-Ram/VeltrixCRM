<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AnalyticsLogsFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_analytics_recent_logs_only_contains_staff_activities()
    {
        // 1. Create an admin and a staff member
        $admin = User::factory()->create(['role' => 'admin']);
        $staff1 = User::factory()->create(['role' => 'staff']);
        $staff2 = User::factory()->create(['role' => 'staff']);

        // 2. Create activity logs for all of them
        ActivityLog::create([
            'user_id' => $admin->id,
            'action' => 'Login',
            'description' => 'Admin logged into the system.',
        ]);

        ActivityLog::create([
            'user_id' => $staff1->id,
            'action' => 'Login',
            'description' => 'Staff 1 logged into the system.',
        ]);

        ActivityLog::create([
            'user_id' => $staff2->id,
            'action' => 'Create Customer',
            'description' => 'Staff 2 created a customer.',
        ]);

        // 3. Act as staff1 and fetch analytics data
        $response = $this->actingAs($staff1)->getJson(route('staff.analytics.data'));

        $response->assertStatus(200);

        $logs = $response->json('recentLogs');

        // 4. Verify we only see staff activities, not admin
        $this->assertCount(2, $logs);
        foreach ($logs as $log) {
            $this->assertEquals('staff', $log['user']['role']);
            $this->assertNotEquals('admin', $log['user']['role']);
        }
    }

    public function test_admin_analytics_recent_logs_contains_all_activities()
    {
        // 1. Create an admin and a staff member
        $admin = User::factory()->create(['role' => 'admin']);
        $staff = User::factory()->create(['role' => 'staff']);

        // 2. Create activity logs
        ActivityLog::create([
            'user_id' => $admin->id,
            'action' => 'Login',
            'description' => 'Admin logged into the system.',
        ]);

        ActivityLog::create([
            'user_id' => $staff->id,
            'action' => 'Login',
            'description' => 'Staff logged into the system.',
        ]);

        // 3. Act as admin and fetch analytics data
        $response = $this->actingAs($admin)->getJson(route('admin.analytics.data'));

        $response->assertStatus(200);

        $logs = $response->json('recentLogs');

        // 4. Verify we see both activities
        $this->assertCount(2, $logs);
    }
}
