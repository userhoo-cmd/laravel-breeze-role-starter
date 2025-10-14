<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the cart page or return cart items as JSON.
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            // Return cart items as JSON
            return response(
                $request->user()->cart()->get()
            );
        }

        // Return the cart view
        return view('cart.index');
    }

    /**
     * Add a product to the cart.
     */
    public function store(Request $request)
    {
        $request->validate([
            'barcode' => 'required|exists:products,barcode',
        ]);

        $barcode = $request->barcode;
        $product = Product::where('barcode', $barcode)->first();
        $cart = $request->user()->cart()->where('barcode', $barcode)->first();

        if ($cart) {
            // Check if quantity exceeds stock
            if ($product->quantity <= $cart->pivot->quantity) {
                return response([
                    'message' => __('cart.available', ['quantity' => $product->quantity]),
                ], 400);
            }

            // Increase quantity by 1
            $cart->pivot->quantity += 1;
            $cart->pivot->save();
        } else {
            if ($product->quantity < 1) {
                return response([
                    'message' => __('cart.outstock'),
                ], 400);
            }

            // Attach product to cart with quantity 1
            $request->user()->cart()->attach($product->id, ['quantity' => 1]);
        }

        return response('', 204);
    }

    /**
     * Change quantity of a product in the cart.
     */
    public function changeQty(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($request->product_id);
        $cart = $request->user()->cart()->where('id', $request->product_id)->first();

        if ($cart) {
            // Check stock availability
            if ($product->quantity < $request->quantity) {
                return response([
                    'message' => __('cart.available', ['quantity' => $product->quantity]),
                ], 400);
            }

            $cart->pivot->quantity = $request->quantity;
            $cart->pivot->save();
        }

        return response([
            'success' => true,
        ]);
    }

    /**
     * Remove a product from the cart.
     */
    public function delete(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $request->user()->cart()->detach($request->product_id);

        return response('', 204);
    }

    /**
     * Empty the entire cart.
     */
    public function empty(Request $request)
    {
        $request->user()->cart()->detach();

        return response('', 204);
    }
}
