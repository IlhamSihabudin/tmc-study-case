<?php

namespace App\Repositories\Query;

use App\Models\Query\Category;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

class CategoryRepository extends BaseRepository
{
    public function model()
    {
        return Category::class;
    }
}
