<?php

namespace App\Facades\Repository\Command;

use App\Repositories\Command\ProductRepository;
use Illuminate\Support\Facades\Facade;

/**
 * @see ProductRepository
 */
class CommandProductRepository extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ProductRepository::class;
    }
}
