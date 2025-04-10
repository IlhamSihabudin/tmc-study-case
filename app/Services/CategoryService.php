<?php

namespace App\Services;

use App\Facades\Repository\Command\CommandCategoryRepository;
use App\Jobs\Category\PublishCategoryCreated;

class CategoryService
{
    /**
     * Store a new category and dispatch a job to publish the category creation event.
     *
     * @param array $data The data for creating the category.
     * @return array An array containing the category's id, name, and creation timestamp.
     */
    public function store(array $data): array
    {
        $category = CommandCategoryRepository::create($data);

        PublishCategoryCreated::dispatch($category);

        return $category->only(['id', 'name', 'createdAt']);
    }
}
