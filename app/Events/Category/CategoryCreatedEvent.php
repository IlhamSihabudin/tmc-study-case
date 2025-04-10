<?php

namespace App\Events\Category;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CategoryCreatedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $category;

    public function __construct(array $category)
    {
        $this->category = $category;
    }
}
