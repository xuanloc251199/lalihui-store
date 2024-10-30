<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Slide;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Phương thức để hiển thị trang chủ
    public function index()
    {
        // Lấy danh sách sản phẩm top 3 theo giá
        $productsTop3 = Product::orderBy('price', 'DESC')->take(3)->get();

        // Lấy tất cả các slide
        $slides = Slide::all();

        // Lấy tất cả các slide cùng với sản phẩm liên quan
        $slidesByProducts = Slide::with('product')->orderBy('id')->get();

        // Lấy danh sách sản phẩm featured
        $productsFeatured = Product::orderBy('id')->take(6)->get();

        return view('index', [
            'slides' => $slides,
            'slidesByProducts' => $slidesByProducts,
            'productsTop3' => $productsTop3,
            'productsFeatured' => $productsFeatured,
        ]);
    }
}
