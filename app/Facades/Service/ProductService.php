<?php

namespace App\Facades\Service;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Services\ProductService
 */
class ProductService extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \App\Services\ProductService::class;
    }
}
