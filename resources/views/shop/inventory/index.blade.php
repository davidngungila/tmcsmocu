@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Inventory Management</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Manage products, stock levels, and categories</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('shop.inventory.create') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0 0h6m-6 0v6m0 0h6m-6 0v6m0 0h6M6 6v12a2 2 0 002-2 2H4a2 2 0 00-2-2V6a2 2 0 002 2z"></path>
                </svg>
                Add Product
            </a>
            <a href="{{ route('shop.low-stock') }}" class="inline-flex items-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 0v2m0 0h6m0 0v2m0 0h6m0 0v2m0 0h6m-6 0v2m0 0h6M6 6v12a2 2 0 002-2 2H4a2 2 0 00-2-2V6a2 2 0 002 2z"></path>
                </svg>
                Low Stock Alerts
            </a>
            <a href="{{ route('shop.reports.inventory') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002 2v6a2 2 0 00-2-2h-4z"></path>
                </svg>
                Inventory Reports
            </a>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">🔍 Search & Filters</h2>
        <form method="GET" action="{{ route('shop.inventory.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search Products</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, SKU, or barcode..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">All Categories</option>
                    <option value="Books">Books</option>
                    <option value="Rosaries">Rosaries</option>
                    <option value="Crosses">Crosses</option>
                    <option value="Bibles">Bibles</option>
                    <option value="Candles">Candles</option>
                    <option value="Medals">Medals</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Stock Status</label>
                <select name="stock_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">All Products</option>
                    <option value="in_stock">In Stock</option>
                    <option value="low_stock">Low Stock</option>
                    <option value="out_of_stock">Out of Stock</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                <select name="price_range" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">All Prices</option>
                    <option value="0-10000">TZS 0 - 10,000</option>
                    <option value="10000-50000">TZS 10,000 - 50,000</option>
                    <option value="50000-100000">TZS 50,000 - 100,000</option>
                    <option value="100000+">Above TZS 100,000</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 transition-colors">
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cost</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($products->count() > 0)
                        @foreach($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-12 h-12 object-cover rounded-lg">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8-4m0 0l8 8m-8-4v8m0 0l-8 8"></path>
                                        </svg>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                @if($product->description)
                                    <p class="text-xs text-gray-500 mt-1">{{ Str::limit($product->description, 50) }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">{{ $product->sku }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">{{ $product->category }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-gray-900">TZS {{ number_format($product->price, 2, '.', ',') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-600">TZS {{ number_format($product->cost_price, 2, '.', ',') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <span class="text-sm font-medium mr-2">{{ $product->stock_quantity }}</span>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full 
                                        @if($product->stock_status == 'out_of_stock') bg-red-100 text-red-800
                                        @elseif($product->stock_status == 'low_stock') bg-yellow-100 text-yellow-800
                                        @else bg-green-100 text-green-800
                                        @endif">
                                        {{ $product->stock_status }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($product->status)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Active</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800">Inactive</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('shop.inventory.edit', $product->id) }}" class="text-purple-600 hover:text-purple-900">Edit</a>
                                    <form action="{{ route('shop.inventory.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                    <button onclick="updateStock({{ $product->id }})" class="text-blue-600 hover:text-blue-900">Update Stock</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8-4m0 0l8 8m-8-4v8m0 0l-8 8"></path>
                                    </svg>
                                    <p class="mt-2">No products found</p>
                                    <p class="text-sm">Try adjusting your search criteria or add new products to the inventory.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        @endif
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8-4m0 0l8 8m-8-4v8m0 0l-8 8"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-blue-700">Total Products</p>
                    <p class="text-2xl font-bold text-blue-900">{{ $totalProducts }}</p>
                </div>
            </div>
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8-4m0 0l8 8m-8-4v8m0 0l-8 8"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-700">Total Value</p>
                    <p class="text-2xl font-bold text-green-900">TZS {{ number_format($totalValue, 2, '.', ',') }}</p>
                </div>
            </div>
        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-4 border border-yellow-200">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 0v2m0 0h6m0 0v2m0 0h6m-6 0v2m0 0h6M6 6v12a2 2 0 002-2 2H4a2 2 0 00-2-2V6a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-yellow-700">Low Stock Items</p>
                    <p class="text-2xl font-bold text-yellow-900">{{ $lowStockCount }}</p>
                </div>
            </div>
        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-4 border border-red-200">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-700">Out of Stock</p>
                    <p class="text-2xl font-bold text-red-900">{{ $outOfStockCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock Update Modal -->
    <div id="stockModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full z-50 hidden">
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-white rounded-lg shadow-xl max-w-md w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Update Stock Level</h3>
                    <button onclick="closeStockModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form onsubmit="processStockUpdate(event)">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Adjustment Type</label>
                        <select name="adjustment_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="add">Add Stock</option>
                            <option value="subtract">Remove Stock</option>
                            <option value="set">Set Stock Level</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                        <input type="number" name="quantity" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Reason</label>
                        <textarea name="reason" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"></textarea>
                    </div>
                    <div class="flex justify-end space-x-3 mt-4">
                        <button type="button" onclick="closeStockModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                            Update Stock
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    let currentProductId = null;

    function updateStock(productId) {
        currentProductId = productId;
        document.getElementById('stockModal').classList.remove('hidden');
    }

    function closeStockModal() {
        document.getElementById('stockModal').classList.add('hidden');
        currentProductId = null;
    }

    function processStockUpdate(event) {
        event.preventDefault();
        
        const formData = new FormData(event.target);
        formData.append('product_id', currentProductId);
        
        fetch('{{ route('shop.inventory.update-stock', ':productId') }}'.replace(':productId', currentProductId), {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Stock updated successfully!');
                closeStockModal();
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating stock');
        });
    }

    // Close modal when clicking outside
    document.getElementById('stockModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeStockModal();
        }
    });
</script>
@endsection
