<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Services\ReviewService;
use Illuminate\Http\Response;
use App\Http\Requests\Review\StoreReviewRequest;
use App\Http\Requests\Review\UpdateReviewRequest;
use App\Http\Resources\ReviewResource;

class ReviewController extends Controller
{
    private ReviewService $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = $this->reviewService->getAllReviews();

        return response()->json($reviews);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {
        $data = $request->validated();
        $review = $this->reviewService->createReview($data);
        $resource = new ReviewResource($review);

        return $resource->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $review = $this->reviewService->getReviewById($id);

        return response()->json($review);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, int $id)
    {
        $data = $request->validated();
        $updatedReview = $this->reviewService->updateReview($id, $data);

        return new ReviewResource($updatedReview);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $this->reviewService->deleteReview($review->id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
