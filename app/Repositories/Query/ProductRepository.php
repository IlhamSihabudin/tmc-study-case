<?php

namespace App\Repositories\Query;

use App\Models\Query\Product;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

class ProductRepository extends BaseRepository
{
    public function model()
    {
        return Product::class;
    }

    /**
     * Retrieve a paginated list of products with their associated categories.
     *
     * @param array $conditions Array of conditions to filter the products.
     * @param array $pagging Pagination details including 'size' and 'current' page.
     * @return array An array containing the list of products and updated pagination details.
     */
    public function getList($conditions, $pagging)
    {
        $offset = ($pagging['current'] - 1) * $pagging['size'];

        $datas = $this->model()::query()
            ->join('categories', 'categories.id', '=', 'products.categoryId');

        foreach ($conditions as $condition) {
            // Check if the condition use 'in' operator
            if ($condition[2] == 'in'){
                $datas->whereIn($condition[0], $condition[2]);
            } else {
                $datas->where($condition[0], $condition[1], $condition[2]);
            }
        }

        $pagging['total'] = $datas->count();

        $datas = $datas->select(['products.*', 'categories.name as categoryName'])
            ->offset($offset)
            ->limit($pagging['size'])
            ->orderBy('products.createdAt', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'sku' => $item->sku,
                    'name' => $item->name,
                    'price' => $item->price,
                    'stock' => $item->stock,
                    'category' => [
                        'id' => $item->categoryId,
                        'name' => $item->categoryName
                    ],
                    'createdAt' => $item->createdAt
                ];
            });

        return [
            'datas' => $datas,
            'pagging' => $pagging
        ];
    }
}
