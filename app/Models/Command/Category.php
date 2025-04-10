<?php

namespace App\Models\Command;

use App\Traits\DynamicAttributes;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use DynamicAttributes;

    protected $connection = 'mysql';
    protected $table = 'categories';
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = ['id'];
}
