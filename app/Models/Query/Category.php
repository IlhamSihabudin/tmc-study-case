<?php

namespace App\Models\Query;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $connection = 'mysql_query';
    protected $table = 'categories';
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];
}
