<?php

namespace App\Facades\Service;

use Illuminate\Support\Facades\Facade;

class CategoryService extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \App\Services\CategoryService::class;
    }
}
