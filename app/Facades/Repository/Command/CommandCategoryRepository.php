<?php

namespace App\Facades\Repository\Command;

use App\Repositories\Command\CategoryRepository;
use Illuminate\Support\Facades\Facade;

/**
 * @see CategoryRepository
 */
class CommandCategoryRepository extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return CategoryRepository::class;
    }
}
