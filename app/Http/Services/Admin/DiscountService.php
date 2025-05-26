<?php

namespace App\Http\Services\Admin;

use App\Models\Discount;
use App\Models\Product;
use Illuminate\Support\Facades\DB;


class DiscountService extends BaseService
{

    public function getAllDiscounts(array $params = [])
    {
        $commonParams = $this->prepareCommonQueryParams($params);

        return Discount::filter($commonParams['filters'])
            ->sortBy($commonParams['sort_by'], $commonParams['sort_dir'])
            ->paginate($commonParams['per_page']);
    }

    public function createDiscount(array $data): Discount
    {
        return Discount::create($data);
    }

    public function updateDiscount(Discount $discount, array $data): Discount
    {
        $discount->update($data);

        return $discount;
    }

    public function deleteDiscount(Discount $discount): bool
    {
        return $discount->delete();
    }
}
