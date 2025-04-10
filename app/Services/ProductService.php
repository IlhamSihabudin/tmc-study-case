<?php

namespace App\Services;

use App\Facades\Repository\Command\CommandProductRepository;
use App\Facades\Repository\Query\QueryProductRepository;
use App\Helpers\ProductFilters;
use App\Jobs\Product\PublishProductCreated;

class ProductService
{
    /**
     * Search for products based on the provided filters and pagination details.
     *
     * @param array $data The search criteria and pagination details.
     *                    - 'size' (optional): The number of items per page (default: 10).
     *                    - 'current' (optional): The current page number (default: 1).
     *                    - Additional filter fields for building conditions.
     * @return array An array containing the list of products and updated pagination details.
     */
    public function search(array $data): array
    {
        $conditions = [];
        ProductFilters::buildConditions($conditions, $data);

        $pagination = [
            'size' => (int)($data['size'] ?? 10),
            'current' => (int)($data['current'] ?? 1),
        ];

        return QueryProductRepository::getList($conditions, $pagination);
    }

    /**
     * Store a new product and dispatch a job to publish the product creation event.
     *
     * @param array $data The data for creating the product.
     * @return array An array containing the product's id, sku, name, price, stock, category, and creation timestamp.
     */
    public function store(array $data)
    {
        $product = CommandProductRepository::create($data);

        PublishProductCreated::dispatch($product);

        return $product->load('category:id,name')
            ->only(['id', 'sku', 'name', 'price', 'stock', 'category', 'createdAt']);
    }
}
