<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Apply filters
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('sku', 'like', "%{$request->search}%")
                  ->orWhere('barcode', 'like', "%{$request->search}%");
            });
        }

        if ($request->category) {
            $query->where('category', $request->category);
        }

        if ($request->stock_status) {
            switch ($request->stock_status) {
                case 'in_stock':
                    $query->where('stock_quantity', '>', 0)
                          ->where('stock_quantity', '>', DB::raw('reorder_level'));
                    break;
                case 'low_stock':
                    $query->where('stock_quantity', '<=', DB::raw('reorder_level'))
                          ->where('stock_quantity', '>', 0);
                    break;
                case 'out_of_stock':
                    $query->where('stock_quantity', '=', 0);
                    break;
            }
        }

        if ($request->price_range) {
            switch ($request->price_range) {
                case '0-10000':
                    $query->whereBetween('price', [0, 10000]);
                    break;
                case '10000-50000':
                    $query->whereBetween('price', [10000, 50000]);
                    break;
                case '50000-100000':
                    $query->whereBetween('price', [50000, 100000]);
                    break;
                case '100000+':
                    $query->where('price', '>', 100000);
                    break;
            }
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get stats for the sidebar
        $totalProducts = Product::count();
        $totalValue = Product::selectRaw('SUM(stock_quantity * price) as total_value')->first()->total_value ?? 0;
        $lowStockCount = Product::where('stock_quantity', '<=', DB::raw('reorder_level'))
                            ->where('stock_quantity', '>', 0)->count();
        $outOfStockCount = Product::where('stock_quantity', '=', 0)->count();

        return view('shop.inventory.index', compact(
            'products', 'totalProducts', 'totalValue', 
            'lowStockCount', 'outOfStockCount'
        ));
    }

    public function create()
    {
        return view('shop.inventory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sku' => 'required|string|max:50|unique:products',
            'barcode' => 'nullable|string|max:50',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
            'reorder_quantity' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'supplier' => 'nullable|string|max:255',
            'status' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'notes' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['status'] = $request->has('status');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/products'), $imageName);
            $data['image'] = 'products/' . $imageName;
        }

        Product::create($data);

        return redirect()->route('shop.inventory.index')
                     ->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        return view('shop.inventory.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sku' => 'required|string|max:50|unique:products,sku,' . $product->id,
            'barcode' => 'nullable|string|max:50',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:0',
            'reorder_quantity' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'supplier' => 'nullable|string|max:255',
            'status' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'notes' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['status'] = $request->has('status');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                $oldImagePath = public_path('storage/' . $product->image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/products'), $imageName);
            $data['image'] = 'products/' . $imageName;
        }

        $product->update($data);

        return redirect()->route('shop.inventory.index')
                     ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        // Delete product image if exists
        if ($product->image) {
            $imagePath = public_path('storage/' . $product->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $product->delete();

        return redirect()->route('shop.inventory.index')
                     ->with('success', 'Product deleted successfully!');
    }

    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'adjustment_type' => 'required|in:add,subtract,set',
            'quantity' => 'required|integer|min:0',
            'reason' => 'required|string|max:255',
        ]);

        $adjustmentType = $request->adjustment_type;
        $quantity = $request->quantity;

        switch ($adjustmentType) {
            case 'add':
                $product->stock_quantity += $quantity;
                break;
            case 'subtract':
                $product->stock_quantity = max(0, $product->stock_quantity - $quantity);
                break;
            case 'set':
                $product->stock_quantity = $quantity;
                break;
        }

        $product->save();

        // Log the adjustment (you might want to create a separate table for this)
        // For now, we'll just add it to the notes
        $oldNotes = $product->notes ?? '';
        $newNote = "Stock adjustment: {$adjustmentType} {$quantity} - {$request->reason}";
        $product->notes = $oldNotes . "\n" . $newNote;
        $product->save();

        return response()->json([
            'success' => true,
            'message' => 'Stock updated successfully!',
            'new_quantity' => $product->stock_quantity
        ]);
    }
}
