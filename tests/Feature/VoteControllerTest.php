<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;

class VoteControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_cast_a_vote()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson('/api/vote', ['item_id' => $item->id]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('votes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }
}