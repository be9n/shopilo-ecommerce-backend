<?php

namespace App\Enums;

enum DiscountTypeEnum: string
{
    case FIXED = 'fixed';
    case PERCENTAGE = 'percentage';
}
