<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Requests\Api\Products\ProductCreateRequest;
use App\Http\Resources\Api\Admin\Products\ProductResource;
use App\Http\Services\ProductService;
use App\Models\Product;

class ProductController extends BaseApiController
{
    public function __construct(private ProductService $productService)
    {
    }

    public function index()
    {
        $sortBy = request('sort_by');
        $sortDir = request('sort_dir');
        $search = request('search');
        $categoryId = request('category_id');

        return $this->successResponse(
            'Processed successfully',
            [
                'products' => $this->getPaginatedData(
                    ProductResource::collection(
                        $this->productService->getAllProducts($sortBy, $sortDir, $search, $categoryId)
                    )
                )
            ]
        );
    }

    public function store(ProductCreateRequest $request)
    {
        $validated = $request->validated();

        $this->productService->createProduct($validated);

        return $this->successResponse('Product created successfully');
    }

    public function destroy(Product $product)
    {
        $this->productService->deleteProduct($product);

        return $this->successResponse('Product deleted successfully');
    }
}
