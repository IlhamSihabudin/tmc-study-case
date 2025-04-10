<?php

namespace App\Jobs\Category;

use App\Events\Category\CategoryCreatedEvent;
use App\Models\Command\Category;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;

class PublishCategoryCreated implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

    public $category;

    /**
     * Create a new job instance.
     */
    public function __construct(Category $category)
    {
        $this->category = $category->toArray();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        event(new CategoryCreatedEvent($this->category));
    }
}
