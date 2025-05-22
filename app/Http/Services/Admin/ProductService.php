<?php

namespace App\Http\Services\Admin;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;


class ProductService extends BaseService
{
    public function getAllProducts(array $params = [])
    {
        $params = $this->prepareCommonQueryParams($params);
        $categoryId = $params['category_id'] ?? null;

        return Product::with('category')
            ->when($categoryId, fn(Builder $builder) =>
                $builder->where('category_id', $categoryId))
            ->applySearch($params['search'])
            ->sortBy($params['sort_by'], $params['sort_dir'])
            ->paginate($params['per_page']);
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
