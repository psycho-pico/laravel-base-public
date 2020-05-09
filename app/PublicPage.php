<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublicPage extends Model
{
    use SoftDeletes;

    protected $table = 'public_pages';
    protected $fillable = [
        'title',
        'content',
        'route'
    ];
}
