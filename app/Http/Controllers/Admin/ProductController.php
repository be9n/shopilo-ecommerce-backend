<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Products\ProductCreateRequest;
use App\Http\Requests\Admin\Products\ProductUpdateRequest;
use App\Http\Resources\Admin\Products\DetailedProductResource;
use App\Http\Resources\Admin\Products\ProductResource;
use App\Http\Services\Admin\ProductService;
use App\Models\Product;

class ProductController extends BaseApiController
{
    public function __construct(private ProductService $productService)
    {
    }

    public function index()
    {
        $params = request()->query();
        $products = $this->productService->getAllProducts($params);

        return $this->successResponse(
            __('Processed successfully'),
            [
                'products' => $this->withCustomPagination($products, ProductResource::class)
            ]
        );
    }

    public function show(Product $product)
    {
        return $this->successResponse(
            __('Processed successfully'),
            [
                'product' =>
                    DetailedProductResource::make(
                        $product->load('category.parent')
                    )
            ]
        );
    }

    public function store(ProductCreateRequest $request)
    {
        $validated = $request->validated();

        $this->productService->createProduct($validated);

        return $this->successResponse(__('Product created successfully'));
    }

    public function update(ProductUpdateRequest $request, Product $product)
    {
        $validated = $request->validated();

        $this->productService->updateProduct($product, $validated);

        return $this->successResponse(__('Product updated successfully'));
    }

    public function destroy(Product $product)
    {
        $this->productService->deleteProduct($product);

        return $this->successResponse(__('Product deleted successfully'));
    }
}
