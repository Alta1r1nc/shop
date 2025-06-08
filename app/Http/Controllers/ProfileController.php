<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Order;

class ProfileController extends Controller
{

    public function show(User $user)
    {
        $user = Auth::user();

        // Если пользователь не авторизован, перенаправляем на страницу входа
        if (!$user) {
            return redirect()->route('login');
        }
        $orders = Order::where('user_id', $user->id)
            ->with('items.product')
            ->latest()
            ->get();

        return view('profile.show', compact('user', 'orders'));
    }
}
