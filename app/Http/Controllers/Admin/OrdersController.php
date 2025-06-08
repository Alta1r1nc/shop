<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items.product'])
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Статус заказа обновлен');
    }

    // Добавьте метод для перевода статусов
    public static function statuses()
    {
        return [
            'pending' => 'В обработке',
            'completed' => 'Завершен',
            'cancelled' => 'Отменен',
        ];
    }
}
