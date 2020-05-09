<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pagination extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'per_page'
    ];
}
