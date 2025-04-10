<?php

namespace App\Listeners\Category;

use App\Events\Category\CategoryCreatedEvent;
use App\Facades\Repository\Query\QueryCategoryRepository;

class SyncCategoryCreated
{
    /**
     * Handle the event.
     */
    public function handle(CategoryCreatedEvent $event): void
    {
        QueryCategoryRepository::create($event->category);
    }
}
