<?php

namespace App\Listeners\Product;

use App\Events\Product\ProductCreatedEvent;
use App\Facades\Repository\Query\QueryProductRepository;

class SyncProductCreated
{
    public function __construct()
    {
    }

    public function handle(ProductCreatedEvent $event): void
    {
        QueryProductRepository::create($event->product);
    }
}
