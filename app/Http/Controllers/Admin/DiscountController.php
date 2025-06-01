<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Discounts\DiscountCreateRequest;
use App\Http\Requests\Admin\Discounts\DiscountUpdateRequest;
use App\Http\Resources\Admin\Discounts\DetailedDiscountResource;
use App\Http\Resources\Admin\Discounts\DiscountListResource;
use App\Http\Resources\Admin\Discounts\DiscountResource;
use App\Http\Services\Admin\DiscountService;
use App\Models\Discount;

class DiscountController extends BaseApiController
{

    public function __construct(private DiscountService $discountService)
    {
        $this->service = $discountService;
    }

    public function index()
    {
        $params = request()->query();
        $discounts = $this->discountService->getAllDiscounts($params);

        return $this->successResponse(
            __('Processed successfully'),
            [
                'discounts' => $this->withCustomPagination($discounts, DiscountResource::class)
            ]
        );
    }

    public function show(Discount $discount)
    {
        return $this->successResponse(__('Processed successfully'), [
            'discount' => DetailedDiscountResource::make($discount)
        ]);
    }

    public function store(DiscountCreateRequest $request)
    {
        $this->discountService->createDiscount($request->validated());

        return $this->successResponse(__('Processed successfully'));
    }

    public function update(DiscountUpdateRequest $request, Discount $discount)
    {
        $this->discountService->updateDiscount($discount, $request->validated());

        return $this->successResponse(__('Processed successfully'));
    }

    public function destroy(Discount $discount)
    {
        $this->discountService->deleteDiscount($discount);

        return $this->successResponse(__('Processed successfully'));
    }

    public function list()
    {
        $discounts = $this->discountService->getDiscountsList();

        return $this->successResponse(__('Processed successfully'), [
            'discounts' => DiscountListResource::collection($discounts)
        ]);
    }
}
