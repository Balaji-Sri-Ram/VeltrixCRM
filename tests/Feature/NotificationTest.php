<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_fetch_notifications()
    {
        $user = User::factory()->create();
        Notification::create([
            'user_id' => $user->id,
            'title' => 'Test Title',
            'message' => 'Test Message',
            'is_read' => false,
        ]);

        $response = $this->actingAs($user)->get(route('notifications.index'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'notifications',
            'unreadCount',
        ]);
        $response->assertJson([
            'unreadCount' => 1,
        ]);
    }

    public function test_can_mark_notification_as_read()
    {
        $user = User::factory()->create();
        $notification = Notification::create([
            'user_id' => $user->id,
            'title' => 'Test Title',
            'message' => 'Test Message',
            'is_read' => false,
        ]);

        $response = $this->actingAs($user)->post(route('notifications.markAsRead', $notification));

        $response->assertStatus(200);
        $this->assertTrue((bool) $notification->refresh()->is_read);
    }

    public function test_can_mark_all_notifications_as_read()
    {
        $user = User::factory()->create();
        Notification::create([
            'user_id' => $user->id,
            'title' => 'Title 1',
            'message' => 'Message 1',
            'is_read' => false,
        ]);
        Notification::create([
            'user_id' => $user->id,
            'title' => 'Title 2',
            'message' => 'Message 2',
            'is_read' => false,
        ]);

        $response = $this->actingAs($user)->post(route('notifications.readAll'));

        $response->assertStatus(200);
        $this->assertEquals(0, Notification::where('user_id', $user->id)->where('is_read', false)->count());
    }

    public function test_can_clear_all_notifications()
    {
        $user = User::factory()->create();
        Notification::create([
            'user_id' => $user->id,
            'title' => 'Title 1',
            'message' => 'Message 1',
            'is_read' => false,
        ]);

        $response = $this->actingAs($user)->delete(route('notifications.clear'));

        $response->assertStatus(200);
        $this->assertEquals(0, Notification::where('user_id', $user->id)->count());
    }
}
