<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Category;

class CategoryRepository
{
    public function getAll(): Collection
    {
        return Category::all();
    }

    public function getById(int $id): ?Category
    {
        return Category::find($id);
    }

    public function save($data): Category
    {
        return Category::create($data);
    }

    public function update(int $id, array $data): Category
    {
        $category = $this->getById($id);
        $category->update($data);

        return $category;
    }

    public function delete(int $id): bool
    {
        $category = $this->getById($id);

        return $category->delete();
    }
}
