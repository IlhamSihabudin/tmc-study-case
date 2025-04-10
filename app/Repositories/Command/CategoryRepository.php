<?php

namespace App\Repositories\Command;

use App\Models\Command\Category;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

class CategoryRepository extends BaseRepository
{
    public function model()
    {
        return Category::class;
    }
}
