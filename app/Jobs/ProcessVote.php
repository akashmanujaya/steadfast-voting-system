<?php

namespace App\Jobs;

use App\Models\Vote;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessVote implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $userId;
    protected $itemId;
    protected $ipAddress;
    protected $location;

    /**
     * Create a new job instance.
     */
    public function __construct($userId, $itemId, $ipAddress, $location)
    {
        $this->userId = $userId;
        $this->itemId = $itemId;
        $this->ipAddress = $ipAddress;
        $this->location = $location;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            Log::info('Processing vote for user: ' . $this->userId);
            
            // Save the vote
            Vote::create([
                'user_id' => $this->userId,
                'item_id' => $this->itemId,
                'ip_address' => $this->ipAddress,
                'location' => $this->location ? $this->location->cityName . ", " . $this->location->regionName . ", " . $this->location->countryName : 'Localhost'
            ]);
            
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
