<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index()
    {
        // Lấy danh sách đơn hàng và nhóm theo người dùng
    $orders = Order::with('user')->orderBy('user_id')->get();

    return view('admin.order.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Order::with('user', 'orderItems.product')->findOrFail($id);
        return view('admin.order.showdetail', compact('order'));
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        if (request()->is('api/*')) {
            return response()->json(['message' => 'Order deleted successfully'], 200);
        }

        return redirect()->route('admin.order.index')->with('success', 'Order deleted successfully!');
    }
}