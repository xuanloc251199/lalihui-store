<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrdImage extends Model
{
    protected $table = 'prd_image';
    protected $fillable = [
        'id_prd',
        'name'
    ];
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_prd');
    }
}
