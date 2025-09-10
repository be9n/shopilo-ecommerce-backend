<?php

namespace App\Http\Services\Admin;

use App\Models\Product;
use Illuminate\Support\Facades\DB;


class ProductService extends BaseService
{
    public function __construct()
    {
        $this->model = Product::class;
    }

    public function getAllProducts(array $params = [])
    {
        $commonParams = $this->prepareCommonQueryParams($params);

        return Product::with('category', 'discount')
            ->filter($commonParams['filters'])
            ->applySearch($commonParams['search'])
            ->sortBy($commonParams['sort_by'], $commonParams['sort_dir'])
            ->paginate($commonParams['per_page']);
    }

    public function createProduct($data)
    {
        return DB::transaction(function () use ($data) {
            $product = Product::create($data);

            if (isset($data['images'])) {
                $product->storeMultipleFiles($data['images'], 'images');
            }

            return $product;
        });
    }

    public function updateProduct($product, $data)
    {
        return DB::transaction(function () use ($product, $data) {
            $product->update($data);

            if (isset($data['images'])) {
                $product->storeMultipleFiles($data['images'], 'images');
            }

            return $product;
        });
    }

    public function deleteProduct(Product $product)
    {
        return $product->delete();
    }
}
