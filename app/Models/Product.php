<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Tên bảng
    protected $table = 'products';

    // Các trường có thể điền được
    protected $fillable = [
        'prd_name',
        'purchase_count',
        'price',
        'quantity',
        'thumbnail',
        'rate',
        'id_category',
        'size',
        'origin',
        'date',
        'detail',
        'description',
        'announcement_form'
    ];

    // Nếu không sử dụng timestamps, bỏ dòng sau
    public $timestamps = false;

    // Quan hệ với Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    /**
     * Phạm vi lọc theo độ phổ biến.
     */
    public function scopePopular($query)
    {
        return $query->where('popular_status', true);
    }

    /**
     * Phạm vi lọc theo giá.
     * @param $query
     * @param $min Giá tối thiểu
     * @param $max Giá tối đa
     * @return mixed
     */
    public function scopePriceBetween($query, $min, $max)
    {
        return $query->whereBetween('price', [$min, $max]);
    }
}
