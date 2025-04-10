<?php

namespace App\Jobs\Product;

use App\Events\Product\ProductCreatedEvent;
use App\Models\Command\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;

class PublishProductCreated implements ShouldQueue
{
    use InteractsWithQueue, Queueable;

    public $product;

    /**
     * Create a new job instance.
     */
    public function __construct(Product $product)
    {
        $this->product = $product->toArray();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        event(new ProductCreatedEvent($this->product));
    }
}
