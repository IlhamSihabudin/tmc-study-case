<?php

namespace App\Facades\Repository\Query;

use App\Repositories\Query\ProductRepository;
use Illuminate\Support\Facades\Facade;

/**
 * @see ProductRepository
 */
class QueryProductRepository extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ProductRepository::class;
    }
}
