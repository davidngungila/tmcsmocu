@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Point of Sale</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Process sales and manage transactions</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('shop.inventory.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8-4m0 0l8 8m-8-4v8m0 0l-8 8"></path>
                </svg>
                Inventory
            </a>
            <a href="{{ route('shop.sales.index') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h2a2 2 0 00-2-2v10a2 2 0 002 2z"></path>
                </svg>
                Sales
            </a>
            <a href="{{ route('shop.reports.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2v6a2 2 0 00-2-2h2a2 2 0 00-2-2v6a2 2 0 002 2z"></path>
                </svg>
                Reports
            </a>
        </div>
    </div>

    <!-- POS Interface -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Products & Cart -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Product Search -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">🔍 Search Products</h2>
                <div class="relative">
                    <input type="text" id="productSearch" placeholder="Scan barcode or search by name..."
                           class="w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <button onclick="searchProduct()" class="absolute right-2 top-1/2 p-2 text-purple-600 hover:text-purple-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-2a2 2 0 00-2 2v4a2 2 0 002 2h4a2 2 0 002 2v4a2 2 0 00-2-2H6a2 2 0 00-2 2v4a2 2 0 002 2z"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Cart -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">🛒 Shopping Cart</h2>
                    <button onclick="clearCart()" class="text-sm text-red-600 hover:text-red-800">Clear Cart</button>
                </div>
                <div id="cartItems" class="space-y-3 max-h-96 overflow-y-auto">
                    <!-- Cart items will be populated here -->
                    <div class="text-center text-gray-500 py-8">
                        <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-4-4H4a4 4 0 00-4 4v4a4 4 0 004 4h8a4 4 0 004-4v4a4 4 0 00-4-4h-4z"></path>
                        </svg>
                        <p class="mt-2">No items in cart</p>
                    </div>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">👤 Customer Information</h2>
                <form id="customerForm" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Customer Name</label>
                        <input type="text" name="customer_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="tel" name="customer_phone" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" name="customer_email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Column - Payment & Summary -->
        <div class="space-y-6">
            <!-- Order Summary -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">📋 Order Summary</h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="font-semibold" id="subtotal">TZS 0.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tax (18%):</span>
                        <span class="font-semibold" id="tax">TZS 0.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Discount:</span>
                        <span class="font-semibold" id="discount">TZS 0.00</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold text-purple-600 pt-3 border-t">
                        <span>Total:</span>
                        <span id="total">TZS 0.00</span>
                    </div>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">💳 Payment Method</h2>
                <form id="paymentForm" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Payment Method</label>
                        <select name="payment_method" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">Select payment method</option>
                            <option value="cash">💵 Cash</option>
                            <option value="mobile_money">📱 Mobile Money</option>
                            <option value="card">💳 Card</option>
                            <option value="bank_transfer">🏦 Bank Transfer</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Amount Received</label>
                        <input type="number" name="amount_received" step="0.01" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Change Due</label>
                        <input type="number" name="change_due" step="0.01" readonly class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
                    </div>
                </form>
            </div>

            <!-- Action Buttons -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">⚡ Actions</h2>
                <div class="space-y-3">
                    <button onclick="processSale()" class="w-full px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 transition-colors">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7l-7-7 4 4z"></path>
                        </svg>
                        Complete Sale
                    </button>
                    <button onclick="holdSale()" class="w-full px-6 py-3 bg-yellow-600 text-white font-semibold rounded-lg hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 transition-colors">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9V6a2 2 0 00-2-2H4a2 2 0 00-2 2v3a2 2 0 002 2h3a2 2 0 002 2v3a2 2 0 00-2-2h-3z"></path>
                        </svg>
                        Hold Sale
                    </button>
                    <button onclick="voidSale()" class="w-full px-6 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Void Sale
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3-1.343-3-3 0-5.657 1.343 1.343 0 3-3h6a3 3 0 003-3v6a3 3 0 003-3h-6a3 3 0 00-3-3z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-blue-700">Today's Sales</p>
                    <p class="text-2xl font-bold text-blue-900">12</p>
                </div>
            </div>
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 border border-green-200">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3-1.343-3-3 0-5.657 1.343 1.343 0 3-3h6a3 3 0 003-3v6a3 3 0 003-3h-6a3 3 0 00-3-3z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-700">Total Revenue</p>
                    <p class="text-2xl font-bold text-green-900">TZS 450,000</p>
                </div>
            </div>
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 border border-purple-200">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-4-4H4a4 4 0 00-4 4v4a4 4 0 004 4h8a4 4 0 004 4v4a4 4 0 00-4-4h-4z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-purple-700">Avg. Sale</p>
                    <p class="text-2xl font-bold text-purple-900">TZS 37,500</p>
                </div>
            </div>
        <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl p-4 border border-orange-200">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h2a2 2 0 002 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-orange-700">Items Sold</p>
                    <p class="text-2xl font-bold text-orange-900">28</p>
                </div>
            </div>
    </div>
</div>

<script>
// POS JavaScript functionality
let cart = [];
let currentSale = null;

function searchProduct() {
    const searchTerm = document.getElementById('productSearch').value;
    // Implement product search logic
    console.log('Searching for:', searchTerm);
}

function addToCart(product) {
    const existingItem = cart.find(item => item.id === product.id);
    if (existingItem) {
        existingItem.quantity += product.quantity || 1;
    } else {
        cart.push({
            ...product,
            quantity: product.quantity || 1
        });
    }
    updateCartDisplay();
}

function removeFromCart(productId) {
    cart = cart.filter(item => item.id !== productId);
    updateCartDisplay();
}

function updateCartDisplay() {
    const cartItems = document.getElementById('cartItems');
    const subtotalElement = document.getElementById('subtotal');
    const taxElement = document.getElementById('tax');
    const discountElement = document.getElementById('discount');
    const totalElement = document.getElementById('total');

    if (cart.length === 0) {
        cartItems.innerHTML = `
            <div class="text-center text-gray-500 py-8">
                <svg class="w-12 h-12 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-4-4H4a4 4 0 00-4 4v4a4 4 0 004 4h8a4 4 0 004 4v4a4 4 0 00-4-4h-4z"></path>
                </svg>
                <p class="mt-2">No items in cart</p>
            </div>
        `;
        subtotalElement.textContent = 'TZS 0.00';
        taxElement.textContent = 'TZS 0.00';
        discountElement.textContent = 'TZS 0.00';
        totalElement.textContent = 'TZS 0.00';
        return;
    }

    let subtotal = 0;
    let tax = 0;
    let discount = 0;

    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        subtotal += itemTotal;
    });

    tax = subtotal * 0.18; // 18% tax
    const total = subtotal + tax - discount;

    // Display cart items
    cartItems.innerHTML = cart.map(item => `
        <div class="flex items-center justify-between p-3 border-b">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center mr-3">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8-4m0 0l8 8m-8-4v8m0 0l-8 8"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900">${item.name}</h4>
                    <p class="text-sm text-gray-600">${item.quantity} × TZS ${item.price.toFixed(2)}</p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <button onclick="removeFromCart(${item.id})" class="text-red-600 hover:text-red-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 01-2.83-2.83l-6.93-6.93A2 2 0 01-2.83 2.83L7 17.657A2 2 0 017.657 2.828 0 012.828 0 012.828 0 01-2.828 2.828l6.93 6.93A2 2 0 002.828 2.828 2.828 0 012.828 0 012.828l6.93 6.93A2 2 0 002.828 2.828 2.828z"></path>
                    </svg>
                </button>
                <span class="font-medium">TZS ${(item.price * item.quantity).toFixed(2)}</span>
            </div>
        </div>
    `).join('');

    subtotalElement.textContent = `TZS ${subtotal.toFixed(2)}`;
    taxElement.textContent = `TZS ${tax.toFixed(2)}`;
    discountElement.textContent = `TZS ${discount.toFixed(2)}`;
    totalElement.textContent = `TZS ${total.toFixed(2)}`;
}

function clearCart() {
    cart = [];
    updateCartDisplay();
}

function processSale() {
    if (cart.length === 0) {
        alert('Please add items to cart first');
        return;
    }

    // Collect form data
    const customerForm = document.getElementById('customerForm');
    const paymentForm = document.getElementById('paymentForm');
    
    const saleData = {
        items: cart,
        customer: {
            name: customerForm.customer_name.value,
            phone: customerForm.customer_phone.value,
            email: customerForm.customer_email.value
        },
        payment: {
            method: paymentForm.payment_method.value,
            amount_received: parseFloat(paymentForm.amount_received.value)
        },
        totals: {
            subtotal: parseFloat(document.getElementById('subtotal').textContent.replace('TZS ', '')),
            tax: parseFloat(document.getElementById('tax').textContent.replace('TZS ', '')),
            discount: parseFloat(document.getElementById('discount').textContent.replace('TZS ', '')),
            total: parseFloat(document.getElementById('total').textContent.replace('TZS ', ''))
        }
    };

    // Submit sale via AJAX
    fetch('{{ route('shop.pos.process') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(saleData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Sale completed successfully!');
            clearCart();
            window.location.href = `{{ route('shop.pos.receipt', ['sale' => ':saleId']) }}`.replace(':saleId', data.sale_id);
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while processing the sale');
    });
}

function holdSale() {
    if (cart.length === 0) {
        alert('Please add items to cart first');
        return;
    }
    // Implement hold sale logic
    console.log('Holding sale...');
}

function voidSale() {
    if (cart.length === 0) {
        alert('Please add items to cart first');
        return;
    }
    // Implement void sale logic
    console.log('Voiding sale...');
}

// Handle barcode scanning
document.getElementById('productSearch').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        searchProduct();
    }
});
</script>
@endsection
