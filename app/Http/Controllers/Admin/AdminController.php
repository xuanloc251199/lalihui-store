<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        // Số lượng đơn hàng
        $orderCount = Order::count();

        // Số lượng sản phẩm đã bán
        $totalProductsSold = Product::sum('sold');

        // Số lượng người dùng
        $userCount = User::count();

        // Tổng doanh thu từ tất cả đơn hàng
        $totalEarnings = Order::sum('total_price');

        return view('admin.dashboard', compact('orderCount', 'totalProductsSold', 'userCount', 'totalEarnings'));
    }
}

