<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Vote;
use App\Services\VoteService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;

class VoteServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_stores_a_vote()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();
        $request = Request::create('/api/vote', 'POST', ['item_id' => $item->id]);

        $this->actingAs($user);

        $service = new VoteService();
        $response = $service->storeVote($request);

        $this->assertDatabaseHas('votes', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // Service returns a JSON response
        $this->assertEquals(201, $response->getStatusCode());
    }
}