<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = Cart::with('product', 'user')->get();
        return view('admin.cart.index', compact('carts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $products = Product::all();
        return response()->view('admin.cart.create', compact('users', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $validator = Validator::make($request->all(), [
            'item_id' => 'required', // Dùng chung cho cả product_id và ticket_id
            'user_id' => 'required|exists:users,id',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:product,ticket', // Thêm type để xác định là product hay ticket
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $userId = $request->input('user_id'); // Sử dụng user_id từ request (không lấy từ người dùng đăng nhập, vì admin có thể thao tác)
        $type = $request->input('type');

        // Kiểm tra xem sản phẩm/vé đã có trong giỏ hàng chưa
        $cartItem = Cart::where('user_id', $userId)
                        ->where($type == 'product' ? 'product_id' : 'ticket_id', $request->item_id)
                        ->first();

        if ($cartItem) {
            // Nếu sản phẩm/vé đã có, cập nhật số lượng
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // Nếu sản phẩm/vé chưa có, tạo mới
            $cartItemData = [
                'user_id' => $userId,
                'quantity' => $request->quantity,
                'type' => $type,
            ];

            if ($type == 'product') {
                $cartItemData['product_id'] = $request->item_id;
            } else {
                $cartItemData['ticket_id'] = $request->item_id;
            }

            $cartItem = Cart::create($cartItemData);
        }

        if (request()->is('api/*')) {
            return response()->json($cartItem, 201);
        }

        return redirect()->route('admin.cart.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cart = Cart::findOrFail($id);
        $users = User::all();
        $products = Product::all();
        return view('admin.cart.update', compact('cart', 'users', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cart = Cart::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'item_id' => 'required', // Dùng chung cho cả product_id và ticket_id
            'user_id' => 'required|exists:users,id',
            'quantity' => 'required|integer|min:1',
            'type' => 'required|in:product,ticket', // Thêm type để xác định là product hay ticket
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $type = $request->input('type');

        if (request()->is('api/*')) {
            // Cập nhật số lượng, loại và id của item (product/ticket)
            $cart->quantity = $request->quantity;
            if ($type == 'product') {
                $cart->product_id = $request->item_id;
                $cart->ticket_id = null; // Xóa giá trị ticket_id nếu là sản phẩm
            } else {
                $cart->ticket_id = $request->item_id;
                $cart->product_id = null; // Xóa giá trị product_id nếu là vé
            }
            $cart->type = $type;
            $cart->save();

            return response()->json($cart, 200);
        }

        // Đối với giao diện admin web
        $cart->update([
            'user_id' => $request->user_id,
            $type == 'product' ? 'product_id' : 'ticket_id' => $request->item_id,
            'quantity' => $request->quantity,
            'type' => $type,
        ]);

        return redirect()->route('admin.cart.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cartItem = Cart::findOrFail($id);
        $cartItem->delete();

        if (request()->is('api/*')) {
            return response()->json(['message' => 'Item removed from cart successfully'], 200);
        }
        return redirect()->route('admin.cart.index');
    }

}