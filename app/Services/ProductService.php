<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Http\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductService
{
    private ProductRepository $productService;

    public function __construct(ProductRepository $productService)
    {
        $this->productService = $productService;
    }

    public function createProduct($data)
    {
        return $this->productService->save($data);
    }

    public function getAllProducts()
    {
        return $this->productService->getAll();
    }

    public function getProductById($id)
    {
        $product = $this->productService->getById($id);

        if (!$product) {
            throw new HttpResponseException(response()->json([
                'message' => 'Product not found.'
            ], Response::HTTP_NOT_FOUND));
        }

        return $product;
    }

    public function updateProduct($id, $data)
    {
        $product = $this->productService->getById($id);

        if (!$product) {
            throw new HttpResponseException(response()->json([
                'message' => 'Product not found.'
            ], Response::HTTP_NOT_FOUND));
        }

        return $this->productService->update($id, $data);
    }

    public function deleteProduct($id)
    {
        $product = $this->productService->getById($id);

        if (!$product) {
            throw new HttpResponseException(response()->json([
                'message' => 'Product not found.'
            ], Response::HTTP_NOT_FOUND));
        }

        $this->productService->delete($id);
    }
}
