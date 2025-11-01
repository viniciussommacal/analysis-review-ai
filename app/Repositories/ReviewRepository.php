<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Review;

class ReviewRepository
{
    public function getAll(): Collection
    {
        return Review::all();
    }

    public function getById(int $id): ?Review
    {
        return Review::find($id);
    }

    public function save($data): Review
    {
        return Review::create($data);
    }

    public function update(int $id, array $data): Review
    {
        $review = $this->getById($id);
        $review->update($data);

        return $review;
    }

    public function delete(int $id): bool
    {
        $review = $this->getById($id);

        return $review->delete();
    }

    public function findReviewProductByUser($productId, $userId): ?Review
    {
        return Review::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();
    }
}
