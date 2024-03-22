<?php

namespace App\Services;

use App\Jobs\ProcessVote;
use App\Models\Item;
use App\Models\Vote;
use Stevebauman\Location\Facades\Location;

/**
 * Class VoteService
 *
 * Manages the logic for voting within the application. This includes tallying vote totals and storing new votes.
 * Utilizes Jobs for asynchronous processing and Models for data interaction.
 */
class VoteService
{
    /**
     * Get the total number of votes for each item.
     * 
     * This method calculates both the daily and overall vote totals for each item. It ensures every item is represented,
     * even those without any votes by initializing their counts to 0.
     * 
     * @return array An associative array containing 'dailyTotals' and 'overallTotals' for each item.
     * @throws \Throwable Throws any exceptions that occur during the calculation process.
     */
    public function getVoteTotals()
    {
        try {
            // Fetch all items to ensure every item is represented, even those without votes
            $items = Item::pluck('name', 'id');
    
            // Get today's vote totals per item
            $dailyVotes = Vote::whereDate('created_at', \Carbon\Carbon::today())
                            ->selectRaw('count(*) as total, item_id')
                            ->groupBy('item_id')
                            ->pluck('total', 'item_id');
    
            // Get overall vote totals per item
            $overallVotes = Vote::selectRaw('count(*) as total, item_id')
                                ->groupBy('item_id')
                                ->pluck('total', 'item_id');
    
            // Ensure all items are included with a default count of 0 if not present in the votes
            $dailyTotals = $items->mapWithKeys(function ($item, $itemId) use ($dailyVotes) {
                return [$item => $dailyVotes->get($itemId, 0)];
            });
    
            $overallTotals = $items->mapWithKeys(function ($item, $itemId) use ($overallVotes) {
                return [$item => $overallVotes->get($itemId, 0)];
            });
    
            return ['dailyTotals' => $dailyTotals, 'overallTotals' => $overallTotals];
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Store a new vote based on the user's request.
     * 
     * Validates the user's ability to vote and then dispatches a job to asynchronously process the vote.
     * Captures the user's ID and location for vote verification purposes.
     * 
     * @param \Illuminate\Http\Request $request The request object containing the vote information.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating the vote processing status or an error message.
     * @throws \Throwable Throws any exceptions that occur during vote storage.
     */
    public function storeVote($request)
    {
        try {
            $userId = auth()->id();
            $ipAddress = $request->ip(); // Get user's IP address
            $location = Location::get(); // Get the user's location
    
            if (Vote::where('user_id', $userId)->exists()) {
                return response()->json(['message' => 'You have already voted.'], 403);
            }
    
            // Dispatch the job to process the vote
            ProcessVote::dispatch($userId, $request->item_id, $ipAddress, $location);
    
            return response()->json(['message' => 'Your vote is being processed.'], 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}