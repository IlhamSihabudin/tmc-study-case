<?php

namespace App\Traits;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

trait DynamicAttributes
{
    /**
     * Boot the model and add dynamic attributes during the creation event.
     *
     * - Automatically generates a UUID for the primary key if it is empty.
     * - Sets the `createdAt` attribute with the current timestamp in milliseconds.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
                $model->createdAt = Carbon::now()->getPreciseTimestamp(3);
            }
        });
    }
}
