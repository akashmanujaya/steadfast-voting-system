<?php

namespace App\Http\Controllers;

use App\Services\ItemService;
use App\Transformers\ItemTransformer;

/**
 * Class ItemController
 *
 * Handles the HTTP requests related to item management in the application.
 * It utilizes the ItemService for business logic and ItemTransformer for response formatting.
 */
class ItemController extends Controller
{
    /**
     * @var ItemService The service that handles the business logic for items.
     */
    protected $itemService;

    /**
     * ItemController constructor.
     * Injects the ItemService dependency and initializes the controller.
     * 
     * @param ItemService $itemService The service responsible for handling item-related logic.
     */
    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    /**
     * Display a listing of items.
     *
     * Fetches all items using the ItemService and transforms the result for API response.
     * 
     * @return \Illuminate\Http\JsonResponse A JSON response containing the list of items.
     */
    public function index()
    {
        $items = $this->itemService->getAllItems();
        return response()->json(ItemTransformer::transform($items));
    }
}
