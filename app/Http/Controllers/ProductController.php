<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function show($id)
    {
        // Находим товар по ID
        $product = Product::findOrFail($id);

        // Возвращаем представление с данными товара
        return view('product.show', compact('product'));
    }

    public function destroy($id)
    {
        // Находим товар по ID
        $product = Product::findOrFail($id);

        // Удаляем изображение товара из хранилища
        if ($product->image) {
            Storage::delete('public/' . $product->image);
        }

        // Удаляем товар из базы данных
        $product->delete();

        // Перенаправляем с сообщением об успешном удалении
        return redirect()->route('admin.products.index')->with('success', 'Товар успешно удален.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image|max:2048',
            'type' => 'required',
            'brand' => 'required',
            'country' => 'required',
            'article' => 'required|unique:products',
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        Product::create([
            ...$validated,
            'image' => $imagePath
        ]);

        return redirect()->route('admin.products.index');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        // Находим товар по ID
        $product = Product::findOrFail($id);
    
        // Валидация данных
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
            'type' => 'required',
            'brand' => 'required',
            'country' => 'required',
            'article' => 'required|unique:products,article,'.$product->id,
        ]);
    
        // Обновление изображения, если оно загружено
        if ($request->hasFile('image')) {
            // Удаляем старое изображение
            Storage::delete('public/' . $product->image);
            // Сохраняем новое изображение
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }
    
        // Обновляем товар
        $product->update($validated);
    
        // Перенаправляем с сообщением об успешном обновлении
        return redirect()->route('admin.products.index')->with('success', 'Товар успешно обновлен.');
    }

}
