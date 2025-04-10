<?php

namespace App\Models\Command;

use App\Traits\DynamicAttributes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use DynamicAttributes;

    protected $connection = 'mysql';
    protected $table = 'products';
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryId', 'id');
    }
}
