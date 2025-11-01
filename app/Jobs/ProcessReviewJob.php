<?php

namespace App\Jobs;

use App\Models\Review;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\ProcessCommentService;
use App\Services\ReviewService;
use Illuminate\Support\Facades\Log;
use Exception;

class ProcessReviewJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Review $review;

    /**
     * Create a new job instance.
     */
    public function __construct(Review $review)
    {
        $this->review = $review;
    }

    /**
     * Execute the job.
     */
    public function handle(ReviewService $reviewService, ProcessCommentService $processCommentService): void
    {
        try {
            Log::info("Processing review ID: {$this->review->id}");

            $result = $processCommentService->processComment($this->review);
            $reviewService->updateRatingReview($this->review->id, [
                'rating' => $result
            ]);

            Log::info("Processing review ID: {$this->review->id} finished with rating {$result}");
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            Log::info("error processing comment: $message");
        }
    }
}
