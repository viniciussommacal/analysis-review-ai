<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductService
{
    private ProductRepository $productService;

    public function __construct(ProductRepository $productService)
    {
        $this->productService = $productService;
    }

    public function createProduct($data)
    {
        $product = $this->productService->save($data);

        return $product;
    }

    public function getAllProducts()
    {
        return $this->productService->getAll();
    }

    public function getProductById($id)
    {
        $product = $this->productService->getById($id);

        if (empty($product)) {
            throw new ModelNotFoundException("Product not found.");
        }

        return $product;
    }

    public function updateproduct($id, $data)
    {
        $product = $this->productService->getById($id);

        if (empty($product)) {
            throw new ModelNotFoundException("Product not found.");
        }

        return $this->productService->update($id, $data);
    }

    public function deleteproduct($id)
    {
        $product = $this->productService->getById($id);

        if (empty($product)) {
            throw new ModelNotFoundException("Product not found.");
        }

        $this->productService->delete($id);
    }
}
