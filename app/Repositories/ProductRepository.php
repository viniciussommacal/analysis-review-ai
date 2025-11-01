<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Product;

class ProductRepository
{
    public function getAll(): Collection
    {
        return Product::all();
    }

    public function getById(int $id): ?Product
    {
        return Product::find($id);
    }

    public function save($data): Product
    {
        return Product::create($data);
    }

    public function update(int $id, array $data): Product
    {
        $product = $this->getById($id);
        $product->update($data);

        return $product;
    }

    public function delete(int $id): bool
    {
        $product = $this->getById($id);
        return $product->delete();
    }
}
