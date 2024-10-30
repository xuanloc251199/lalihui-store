<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contact';
    protected $fillable = [
        'company_name',
        'hotline',
        'address',
        'link_page',
        'link_map',
        'time_work',
        'date_work',
        'email'
    ];
    public $timestamps = false;
}
