<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    protected $fillable = [
        'user_id',
        'search_panel_collapsed',
        'sidebar_toggled',
        'sidebar_item_collapsed',
        'sidebar_item_collapsed_index',
        'table_row_per_page',
        'dark_mode'
    ];
}
