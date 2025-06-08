<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function show()
    {
        $cart = $this->getCart();
        return view('cart', compact('cart'));
    }

    public function add(Product $product, Request $request)
    {
        $cart = $this->getCart();

        // Проверяем, есть ли уже этот товар в корзине
        $existingItem = $cart->items()->where('product_id', $product->id)->first();

        if ($existingItem) {
            // Если товар уже есть, увеличиваем количество на 1
            $existingItem->increment('quantity');
        } else {
            // Если товара нет, создаем новую запись с quantity = 1
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => 1
            ]);
        }

        // Обновляем данные корзины
        $cart = $cart->fresh()->load('items.product');

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'cart_total' => $cart->items()->sum('quantity'),
                'item_quantity' => $cart->items()->where('product_id', $product->id)->first()->quantity
            ]);
        }

        return back()->with('success', 'Товар добавлен в корзину!');
    }

    public function remove(CartItem $item)
    {
        $item->delete();
        return back()->with('success', 'Товар удален из корзины.');
    }

    public function getCart()
    {
        if (Auth::check()) {
            return Cart::with('items.product')->firstOrCreate(['user_id' => Auth::id()]);
        }

        $sessionId = session()->getId();
        return Cart::with('items.product')->firstOrCreate(['session_id' => $sessionId]);
    }

    public function updateQuantity(Product $product, Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = $this->getCart();

        DB::transaction(function () use ($cart, $product, $request) {
            $cart->items()->updateOrCreate(
                ['product_id' => $product->id],
                ['quantity' => $request->quantity]
            );
        });

        // Обновляем корзину после изменений
        $cart = $cart->fresh()->load('items.product');

        return response()->json([
            'success' => true,
            'itemTotal' => $cart->items->firstWhere('product_id', $product->id)->product->price * $request->quantity,
            'subtotal' => $cart->items->sum(fn($i) => $i->product->price * $i->quantity),
            'itemsCount' => $cart->items->sum('quantity')
        ]);
    }
}
