@extends('layouts.admin')

@section('title', __('Cart'))

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">{{ __('Cart') }}</h1>

    <!-- Add to Cart Form -->
    <div class="mb-6">
        <form id="add-to-cart-form" class="flex gap-2">
            @csrf
            <input type="text" id="barcode" placeholder="Enter product barcode" class="border px-2 py-1 rounded w-64" required>
            <button type="submit" class="bg-blue-500 text-white px-4 py-1 rounded">Add to Cart</button>
        </form>
    </div>

    <!-- Cart Table -->
    <table class="w-full border border-gray-300 mb-4" id="cart-table">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2">Product</th>
                <th class="border px-4 py-2">Price</th>
                <th class="border px-4 py-2">Quantity</th>
                <th class="border px-4 py-2">Total</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody id="cart-body">
            <tr>
                <td colspan="5" class="text-center py-4">Loading cart...</td>
            </tr>
        </tbody>
    </table>

    <!-- Empty Cart Button -->
    <button id="empty-cart" class="bg-red-500 text-white px-4 py-2 rounded">
        {{ __('Empty Cart') }}
    </button>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cartBody = document.getElementById('cart-body');
    const addForm = document.getElementById('add-to-cart-form');
    const barcodeInput = document.getElementById('barcode');

    // Load cart items
    function loadCart() {
        fetch('{{ route('cart.index') }}', {
            headers: { 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            if (!data.length) {
                cartBody.innerHTML = '<tr><td colspan="5" class="text-center py-4">Cart is empty</td></tr>';
                return;
            }

            cartBody.innerHTML = '';
            data.forEach(item => {
                cartBody.innerHTML += `
                    <tr>
                        <td class="border px-4 py-2">${item.name}</td>
                        <td class="border px-4 py-2">${item.price}</td>
                        <td class="border px-4 py-2">
                            <input type="number" value="${item.pivot.quantity}" min="1" data-id="${item.id}" class="qty-input border p-1 w-16">
                        </td>
                        <td class="border px-4 py-2">${(item.price * item.pivot.quantity).toFixed(2)}</td>
                        <td class="border px-4 py-2">
                            <button class="delete-btn bg-red-500 text-white px-2 py-1 rounded" data-id="${item.id}">Delete</button>
                        </td>
                    </tr>
                `;
            });

            attachEvents();
        });
    }

    // Change quantity / Delete / Empty Cart
    function attachEvents() {
        document.querySelectorAll('.qty-input').forEach(input => {
            input.addEventListener('change', function() {
                const productId = this.dataset.id;
                const quantity = this.value;

                fetch('{{ route('cart.changeQty') }}', {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ product_id: productId, quantity: quantity })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) loadCart();
                    else alert(data.message || 'Error updating quantity');
                });
            });
        });

        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const productId = this.dataset.id;
                fetch('{{ route('cart.delete') }}', {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ product_id: productId })
                }).then(() => loadCart());
            });
        });
    }

    document.getElementById('empty-cart').addEventListener('click', function() {
        fetch('{{ route('cart.empty') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(() => loadCart());
    });

    // Add to Cart form submission
    addForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const barcode = barcodeInput.value.trim();
        if (!barcode) return alert('Please enter a barcode');

        fetch('{{ route('cart.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ barcode: barcode })
        })
        .then(res => {
            if (res.status === 204) {
                barcodeInput.value = '';
                loadCart();
            } else {
                return res.json().then(data => alert(data.message || 'Error adding product'));
            }
        });
    });

    // Initial load
    loadCart();
});
</script>
@endsection
