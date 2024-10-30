<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    // Tên bảng tương ứng trong cơ sở dữ liệu
    protected $table = 'slide';

    // Nếu không có các trường timestamps (created_at, updated_at), bạn có thể tắt chúng đi
    public $timestamps = false;

    // Các trường có thể được gán hàng loạt (mass assignable)
    protected $fillable = [
        'slide_image',
        'title',
        'sub_title',
        'id_prd',
    ];

    /**
     * Quan hệ với bảng Product.
     * Mỗi slide sẽ thuộc về một sản phẩm (Product) thông qua khóa ngoại id_prd
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_prd');
    }
}
