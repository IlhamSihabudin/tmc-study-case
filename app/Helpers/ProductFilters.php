<?php

namespace App\Helpers;

use App\Models\Query\Category;
use App\Models\Query\Product;

class ProductFilters
{
    protected static $product_table;
    protected static $category_table;

    public static function buildConditions(array &$conditions, array $data) : void
    {
        self::$product_table = (new Product())->getTable();
        self::$category_table = (new Category())->getTable();

        self::filterSku($conditions, $data);
        self::filterName($conditions, $data);
        self::filterPrice($conditions, $data);
        self::filterStock($conditions, $data);
        self::filterCategoryId($conditions, $data);
        self::filterCategoryName($conditions, $data);
    }

    protected static function filterSku(array &$conditions, array $data) : void
    {
        if (!empty($data['sku'])) {
            $conditions[] = [self::$product_table . '.sku', 'in', $data['sku']];
        }
    }

    protected static function filterName(array &$conditions, array $data) : void
    {
        if (!empty($data['name'])) {
            foreach ($data['name'] as $name) {
                $conditions[] = [self::$product_table . '.name', 'like', "%{$name}%"];
            }
        }
    }

    protected static function filterPrice(array &$conditions, array $data) : void
    {
        if (!empty($data['price_start']) && !empty($data['price_end'])) {
            $conditions[] = [self::$product_table . '.price', '>=', $data['price_start']];
            $conditions[] = [self::$product_table . '.price', '<=', $data['price_end']];
        }
    }

    protected static function filterStock(array &$conditions, array $data) : void
    {
        if (!empty($data['stock_start']) && !empty($data['stock_end'])) {
            $conditions[] = [self::$product_table . '.stock', '>=', $data['stock_start']];
            $conditions[] = [self::$product_table . '.stock', '<=', $data['stock_end']];
        }
    }

    protected static function filterCategoryId(array &$conditions, array $data) : void
    {
        if (!empty($data['category_id'])) {
            $conditions[] = [self::$category_table . '.id', 'in', $data['category_id']];
        }
    }

    protected static function filterCategoryName(array &$conditions, array $data) : void
    {
        if (!empty($data['category_name'])) {
            $conditions[] = [self::$category_table . '.name', 'in', $data['category_name']];
        }
    }
}
