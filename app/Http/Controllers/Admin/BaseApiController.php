<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Traits\PaginatedResponseTrait;

class BaseApiController extends Controller
{
    use ApiResponseTrait, PaginatedResponseTrait;
}
