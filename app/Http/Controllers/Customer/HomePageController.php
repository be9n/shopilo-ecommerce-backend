<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Admin\BaseApiController;
use App\Http\Resources\Customer\Categories\CategoryResource;
use App\Http\Resources\Customer\Products\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomePageController extends BaseApiController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $categories = Category::child()->get();
        $bestSellingProducts = Product::with('media')->get();

        return $this->successResponse(__('Processed successfully'), [
            'categories' => CategoryResource::collection($categories),
            'best_selling_products' => ProductResource::collection($bestSellingProducts),
        ]);
    }
}
