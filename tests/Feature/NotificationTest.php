<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\GenericDashboardNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\DatabaseNotification;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_receive_and_list_notifications()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Envia notificação
        $this->post('/notifications/test-send')->assertJson(['success' => true]);

        // Lista notificações
        $response = $this->get('/notifications');
        $response->assertStatus(200)
            ->assertJsonStructure([
                'notifications',
                'unread_count',
            ]);
        $this->assertEquals(1, $response->json('unread_count'));
    }

    public function test_user_can_mark_notification_as_read()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $user->notify(new GenericDashboardNotification('Teste', 'Mensagem'));
        $notification = $user->fresh()->unreadNotifications->first();

        $this->post('/notifications/'.$notification->id.'/mark-as-read')
            ->assertJson(['success' => true]);
        $this->assertEquals(0, $user->fresh()->unreadNotifications()->count());
    }

    public function test_user_can_mark_all_notifications_as_read()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $user->notify(new GenericDashboardNotification('Teste 1', 'Mensagem 1'));
        $user->notify(new GenericDashboardNotification('Teste 2', 'Mensagem 2'));
        $this->assertEquals(2, $user->fresh()->unreadNotifications()->count());

        $this->post('/notifications/mark-all-as-read')
            ->assertJson(['success' => true]);
        $this->assertEquals(0, $user->fresh()->unreadNotifications()->count());
    }

    public function test_user_can_delete_notification()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $user->notify(new GenericDashboardNotification('Teste', 'Mensagem'));
        $notification = $user->fresh()->notifications->first();

        $this->delete('/notifications/'.$notification->id)
            ->assertJson(['success' => true]);
        $this->assertEquals(0, $user->fresh()->notifications()->count());
    }
} 