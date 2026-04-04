<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PosController extends Controller
{
    public function index()
    {
        // Get today's sales stats
        $todaySales = Sale::today()->count();
        $todayRevenue = Sale::today()->sum('total_amount');
        $avgSale = $todaySales > 0 ? $todayRevenue / $todaySales : 0;
        $itemsSold = SaleItem::whereHas('sale', function($query) {
            $query->whereDate('sale_date', today());
        })->sum('quantity');

        return view('shop.pos', compact('todaySales', 'todayRevenue', 'avgSale', 'itemsSold'));
    }

    public function processSale(Request $request)
    {
        try {
            DB::beginTransaction();

            // Generate receipt number
            $receiptNumber = 'RCP' . date('Ymd') . str_pad(Sale::count() + 1, 4, '0', STR_PAD_LEFT);

            // Create sale
            $sale = Sale::create([
                'receipt_number' => $receiptNumber,
                'customer_name' => $request->input('customer.name'),
                'customer_phone' => $request->input('customer.phone'),
                'customer_email' => $request->input('customer.email'),
                'subtotal' => $request->input('totals.subtotal'),
                'tax_amount' => $request->input('totals.tax'),
                'discount_amount' => $request->input('totals.discount'),
                'total_amount' => $request->input('totals.total'),
                'payment_method' => $request->input('payment.method'),
                'payment_status' => 'paid',
                'status' => 'completed',
                'notes' => $request->input('notes'),
                'sold_by' => auth()->id(),
                'sale_date' => now(),
            ]);

            // Create sale items and update stock
            foreach ($request->input('items') as $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'total_price' => $item['price'] * $item['quantity'],
                    'discount_amount' => $item['discount'] ?? 0,
                ]);

                // Update product stock
                $product = Product::find($item['id']);
                if ($product) {
                    $product->stock_quantity -= $item['quantity'];
                    $product->save();
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'sale_id' => $sale->id,
                'receipt_number' => $receiptNumber,
                'message' => 'Sale completed successfully!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error processing sale: ' . $e->getMessage()
            ], 500);
        }
    }

    public function receipt(Sale $sale)
    {
        return view('shop.receipt', compact('sale'));
    }

    public function sales(Request $request)
    {
        $sales = Sale::with(['items.product', 'user'])
            ->when($request->search, function($query, $search) {
                $query->where('receipt_number', 'like', "%{$search}%")
                      ->orWhere('customer_name', 'like', "%{$search}%")
                      ->orWhere('customer_phone', 'like', "%{$search}%");
            })
            ->when($request->date_from, function($query, $dateFrom) {
                $query->whereDate('sale_date', '>=', $dateFrom);
            })
            ->when($request->date_to, function($query, $dateTo) {
                $query->whereDate('sale_date', '<=', $dateTo);
            })
            ->orderBy('sale_date', 'desc')
            ->paginate(20);

        return view('shop.sales.index', compact('sales'));
    }

    public function showSale(Sale $sale)
    {
        $sale->load(['items.product', 'user']);
        return view('shop.sales.show', compact('sale'));
    }

    public function reports()
    {
        return view('shop.reports.index');
    }

    public function salesReport(Request $request)
    {
        $startDate = $request->date_from ?? now()->startOfMonth();
        $endDate = $request->date_to ?? now();

        $sales = Sale::whereBetween('sale_date', [$startDate, $endDate])
            ->with(['items.product'])
            ->get();

        $totalSales = $sales->count();
        $totalRevenue = $sales->sum('total_amount');
        $totalItems = $sales->sum(function($sale) {
            return $sale->items->sum('quantity');
        });

        // Group by payment method
        $paymentBreakdown = $sales->groupBy('payment_method')
            ->map(function($group) {
                return [
                    'count' => $group->count(),
                    'total' => $group->sum('total_amount')
                ];
            });

        return view('shop.reports.sales', compact(
            'sales', 'totalSales', 'totalRevenue', 'totalItems', 
            'paymentBreakdown', 'startDate', 'endDate'
        ));
    }

    public function inventoryReport()
    {
        $products = Product::withCount(['saleItems' => function($query) {
                $query->whereHas('sale', function($saleQuery) {
                    $saleQuery->whereDate('sale_date', '>=', now()->subDays(30));
                });
            }])
            ->get();

        $totalProducts = $products->count();
        $totalValue = $products->sum(function($product) {
            return $product->stock_quantity * $product->price;
        });

        $lowStockProducts = $products->filter(function($product) {
            return $product->stock_quantity <= $product->reorder_level;
        });

        $outOfStockProducts = $products->filter(function($product) {
            return $product->stock_quantity == 0;
        });

        return view('shop.reports.inventory', compact(
            'products', 'totalProducts', 'totalValue', 
            'lowStockProducts', 'outOfStockProducts'
        ));
    }

    public function lowStock()
    {
        $lowStockProducts = Product::where('stock_quantity', '<=', DB::raw('reorder_level'))
            ->where('stock_quantity', '>', 0)
            ->orderBy('stock_quantity', 'asc')
            ->get();

        $outOfStockProducts = Product::where('stock_quantity', '=', 0)
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('shop.low-stock', compact('lowStockProducts', 'outOfStockProducts'));
    }
}
