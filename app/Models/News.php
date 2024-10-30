<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';
    protected $fillable = [
        'title',
        'sub_title',
        'detail',
        'time_upload',
        'writer'
    ];
    public $timestamps = false;
}
