<?php

namespace App\Repositories\Command;

use App\Models\Command\Product;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

class ProductRepository extends BaseRepository
{
    public function model()
    {
        return Product::class;
    }
}
