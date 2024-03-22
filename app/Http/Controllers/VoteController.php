<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoteCreationRequest;
use App\Services\VoteService;

/**
 * Class VoteController
 *
 * Manages voting functionalities within the application, handling HTTP requests related to voting actions.
 * Utilizes the VoteService for the core logic associated with voting operations.
 */
class VoteController extends Controller
{
    /**
     * @var VoteService The service responsible for handling the core logic of voting operations.
     */
    protected $voteService;

    /**
     * VoteController constructor.
     * Initializes the controller with necessary service dependency for vote operations.
     *
     * @param VoteService $voteService The service that encapsulates the business logic for voting.
     */
    public function __construct(VoteService $voteService)
    {
        $this->voteService = $voteService;
    }

    /**
     * Store a new vote.
     *
     * Processes the incoming voting request and delegates the logic to the VoteService.
     * Handles any exceptions that occur during the process and returns an appropriate JSON response.
     *
     * @param VoteCreationRequest $request The validated request containing the vote data.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating the outcome of the vote storage operation.
     */
    public function store(VoteCreationRequest $request)
    {
        try {
            $storeVote = $this->voteService->storeVote($request);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while processing your vote.'], 500);
        }

        return response()->json($storeVote, 201);
    }
}
