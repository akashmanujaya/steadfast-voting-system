<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_all_items()
    {
        $user = User::factory()->create(); // Create a test user
        Item::factory()->count(3)->create();

        $response = $this->actingAs($user)->get('/api/items');

        $response->assertOk();
        $response->assertJsonCount(3);
        // Update the expected structure to match the transformer output
        $expectedStructure = [
            '*' => [
                'id',
                'name',
                'icon',
            ],
        ];

        $response->assertJsonStructure($expectedStructure);
    }
}