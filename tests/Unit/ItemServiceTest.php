<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Item;
use App\Services\ItemService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemServiceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_retrieves_all_items()
    {
        $items = Item::factory()->count(4)->create();

        $service = new ItemService();
        $retrievedItems = $service->getAllItems();

        $this->assertCount(4, $retrievedItems);
        $this->assertEquals($items->pluck('id')->sort()->values(), $retrievedItems->pluck('id')->sort()->values());
    }
}
