<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DailyVoteSummary extends Mailable
{
    use Queueable, SerializesModels;

    public $dailyTotals;
    public $overallTotals;

    /**
     * Create a new message instance.
     */
    public function __construct($dailyTotals, $overallTotals)
    {
        $this->dailyTotals = $dailyTotals;
        $this->overallTotals = $overallTotals;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        try {
            return $this->markdown('emails.daily_vote_summary')
                        ->with([
                            'dailyTotals' => $this->dailyTotals,
                            'overallTotals' => $this->overallTotals,
                        ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
