<?php

namespace App\Services;

use App\Models\Item;

/**
 * Class ItemService
 *
 * Provides business logic for item-related operations, such as retrieving all items.
 */
class ItemService
{
    /**
     * Retrieve all items from the database.
     * 
     * Fetches all items using the Item model. Throws an exception if any error occurs.
     * 
     * @return \Illuminate\Database\Eloquent\Collection|static[] A collection of Item models.
     * @throws \Throwable Throws any exceptions that occur during the fetch process.
     */
    public function getAllItems()
    {
        try {
            return Item::all();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
