<?php

namespace App\Http\Middleware;

use App\Models\Vote;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserVoted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (auth()->check()) {
            // Fetch the latest vote and include the related item
            $latestVote = Vote::with('item')
                            ->where('user_id', auth()->id())
                            ->latest()
                            ->first();

            $itemName = $latestVote ? $latestVote->item->name : '';

            // Include whether the user has voted and the item name in the headers
            $response->header('X-User-Has-Voted', $latestVote ? 'true' : 'false');
            $response->header('X-User-Voted-For', $itemName);
        }

        return $response;
    }
}
