<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Product::query();

        // Lọc theo danh mục
        if ($request->filled('category') && $request->category !== '') {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('category_name', $request->category);
            });
        }

        // Lọc theo khoảng giá
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereBetween('price', [(int) $request->min_price, (int) $request->max_price]);
        }

        // Sắp xếp sản phẩm
        if ($request->filled('sorting')) {
            switch ($request->sorting) {
                case 'lowest':
                    $query->orderBy('price', 'ASC');
                    break;
                case 'highest':
                    $query->orderBy('price', 'DESC');
                    break;
                case 'popular':
                    $query->orderBy('purchase_count', 'DESC');
                    break;
                default:
                    $query->orderBy('id');
            }
        }

        $products = $query->get();
        $maxProductPrice = Product::max('price') + 100000;
        $minProductPrice = Product::min('price');

        // Xử lý AJAX request
        if ($request->ajax()) {
            return view('partials.product_list', compact('products'))->render();
        }

        return view('shop', compact('products', 'categories', 'maxProductPrice', 'minProductPrice'));
    }
}
