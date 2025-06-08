<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500'
        ]);

        $cart = app(CartController::class)->getCart();

        if ($cart->items->isEmpty()) {
            return back()->with('error', 'Ваша корзина пуста');
        }

        try {
            DB::beginTransaction();

            $orderData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'total' => $cart->items->sum(fn($i) => $i->product->price * $i->quantity),
            ];

            if (Auth::check()) {
                $orderData['user_id'] = Auth::id();
            }

            $order = Order::create($orderData);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }

            $cart->items()->delete();
            DB::commit();

            return response()->json([
                'redirect' => route('profile'),
                'message' => 'Заказ #' . $order->id . ' успешно оформлен!'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Ошибка при оформлении заказа: ' . $e->getMessage(),
                'errors' => ['system' => ['Произошла системная ошибка']]
            ], 500);
        }
    }
}
