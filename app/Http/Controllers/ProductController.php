<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->productService->getAllProducts();

        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $product = $this->productService->createProduct($data);

        return response()->json($product, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $ind)
    {
        $product = $this->productService->getProductById($ind);

        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $product, int $id)
    {
        $data = $product->validated();
        $updatedProduct = $this->productService->updateProduct($id, $data);

        return response()->json($updatedProduct);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->productService->deleteProduct($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
