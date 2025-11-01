<?php

namespace App\Services;

use App\Jobs\ProcessReviewJob;
use Illuminate\Http\Response;
use App\Repositories\ReviewRepository;
use Illuminate\Http\Exceptions\HttpResponseException;
use Exception;

class ReviewService
{
    private ReviewRepository $reviewRepository;

    public function __construct(ReviewRepository $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    public function createReview($data)
    {
        $user = auth()->user();

        if ($this->reviewRepository->findReviewProductByUser($data['product_id'], $user->id)) {
            throw new HttpResponseException(response()->json([
                'message' => 'You have already submitted a review.'
            ], Response::HTTP_BAD_REQUEST));
        }

        $data['user_id'] = $user->id;
        $review = $this->reviewRepository->save($data);

        ProcessReviewJob::dispatch($review);

        return $review;
    }

    public function getAllReviews()
    {
        return $this->reviewRepository->getAll();
    }

    public function getReviewById($id)
    {
        $review = $this->reviewRepository->getById($id);

        if (!$review) {
            throw new HttpResponseException(response()->json([
                'message' => 'Review not found.'
            ], Response::HTTP_NOT_FOUND));
        }

        return $review;
    }

    public function updateReview($id, $data)
    {
        $review = $this->reviewRepository->getById($id);

        if (!$review) {
            throw new HttpResponseException(response()->json([
                'message' => 'Review not found.'
            ], Response::HTTP_NOT_FOUND));
        }

        $user = auth()->user();

        if ($review->user_id !== $user->id) {
            throw new HttpResponseException(response()->json([
                'message' => 'You are not authorized to update this review.'
            ], Response::HTTP_FORBIDDEN));
        }

        $data['user_id'] = $user->id;

        $review = $this->reviewRepository->update($id, $data);

        ProcessReviewJob::dispatch($review);

        return $review;
    }

    public function updateRatingReview($id, $data) {
        $review = $this->reviewRepository->getById($id);

        if (empty($review)) {
            throw new Exception("Review not found.");
        }

        $this->reviewRepository->update($id, $data);
    }

    public function deleteReview($id)
    {
        $review = $this->reviewRepository->getById($id);

        if (!$review) {
            throw new HttpResponseException(response()->json([
                'message' => 'Review not found.'
            ], Response::HTTP_NOT_FOUND));
        }

        $user = auth()->user();

        if ($review->user_id !== $user->id) {
            throw new HttpResponseException(response()->json([
                'message' => 'You are not authorized to delete this review.'
            ], Response::HTTP_FORBIDDEN));
        }

        $this->reviewRepository->delete($id);
    }
}
