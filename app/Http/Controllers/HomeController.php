<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\CartController;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $type = $request->input('type', 'все');
        $sort = $request->input('sort', '');
        
        // Получаем корзину
        $cartController = new CartController();
        $cart = $cartController->getCart();
        $cartItems = $cart->items->keyBy('product_id');

        // Построение запроса
        $query = Product::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%'.$search.'%');
            })
            ->when($type !== 'все', function ($query) use ($type) {
                return $query->where('type', $type);
            });

        // Сортировка
        if ($sort === 'cheap') {
            $query->orderBy('price');
        } elseif ($sort === 'expensive') {
            $query->orderByDesc('price');
        }

        // Пагинация
        $products = $query->paginate(12);

        // Ответ для AJAX
        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.products', compact('products', 'cartItems'))->render()
            ]);
        }

        return view('home', compact('products', 'search', 'type', 'sort', 'cartItems'));
    }

    public function about()
    {
        return view('about');
    }

    public function showProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('product.show', compact('product'));
    }
}