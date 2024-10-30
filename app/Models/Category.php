<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = [
        'category_name',
        'detail'
    ];
    public $timestamps = false;

    public function products()
    {
        return $this->hasMany(Product::class, 'id_category');
    }
}
