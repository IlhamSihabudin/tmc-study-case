<?php

namespace App\Facades\Repository\Query;

use App\Repositories\Query\CategoryRepository;
use Illuminate\Support\Facades\Facade;

/**
 * @see ProductRepository
 */
class QueryCategoryRepository extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return CategoryRepository::class;
    }
}
