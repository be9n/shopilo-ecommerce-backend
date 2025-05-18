<?php

namespace App\Http\Services\Admin;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;


class ProductService
{
    public function getAllProducts(?string $sortBy, ?string $sortDir, ?string $search, ?int $categoryId)
    {
        return Product::with('category')
            ->when($sortBy, function (Builder $builder) use ($sortBy, $sortDir) {
                return $builder->orderBy($sortBy, $sortDir ?? 'asc');
            })
            ->when($search, function (Builder $builder) use ($search) {
                return $builder->where('name', 'like', "%$search%");
            })
            ->when($categoryId, function (Builder $builder) use ($categoryId) {
                return $builder->where('category_id', $categoryId);
            })
            ->paginate(15);
    }

    public function createProduct($data)
    {
        $product = Product::create($data);
        if (isset($data['images'])) {
            $product->storeMultipleFiles($data['images'], 'images');
        }

        return $product;
    }

    public function updateProduct($product, $data)
    {
        $product->update($data);
        if (isset($data['images'])) {
            $product->storeMultipleFiles($data['images'], 'images');
        }

        return $product;
    }

    public function deleteProduct(Product $product)
    {
        return $product->delete();
    }
}
