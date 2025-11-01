<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoryService
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function createCategory($data)
    {
        return $this->categoryRepository->save($data);
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->getAll();
    }

    public function getAllById($id)
    {
        $category = $this->categoryRepository->getById($id);

        if (!$category) {
            throw new HttpResponseException(response()->json([
                'message' => 'Category not found.'
            ], Response::HTTP_NOT_FOUND));
        }

        return $category;
    }

    public function updateCategory($id, $data)
    {
        $category = $this->categoryRepository->getById($id);

        if (!$category) {
            throw new HttpResponseException(response()->json([
                'message' => 'Category not found.'
            ], Response::HTTP_NOT_FOUND));
        }

        return $this->categoryRepository->update($id, $data);
    }

    public function deleteCategory($id)
    {
        $category = $this->categoryRepository->getById($id);

        if (!$category) {
            throw new HttpResponseException(response()->json([
                'message' => 'Category not found.'
            ], Response::HTTP_NOT_FOUND));
        }

        $this->categoryRepository->delete($id);
    }
}
