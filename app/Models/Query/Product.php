<?php

namespace App\Models\Query;

use App\Models\Command\Category;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $connection = 'mysql_query';
    protected $table = 'products';
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
