<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SalesController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['product', 'customer'])->latest()->get();
        return Inertia::render('Sales/Index', ['sales' => $sales]);
    }

    public function create()
    {
        return Inertia::render('Sales/Create', [
            'products' => Product::all(),
            'customers' => Customer::all(),
        ]);
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'product_id' => 'required|exists:products,id',
        'customer_id' => 'required|exists:customers,id',
        'quantity' => 'required|integer|min:1',
    ]);

    // Get the single product
    $product = Product::findOrFail($data['product_id']);

    if ($product->stock < $data['quantity']) {
        return back()->withErrors(['quantity' => 'Not enough stock']);
    }

    $sale = Sale::create([
        'product_id' => $data['product_id'],
        'customer_id' => $data['customer_id'],
        'quantity' => $data['quantity'],
        'total_price' => $product->price * $data['quantity'],
    ]);

    // Deduct stock
    $product->decrement('stock', $data['quantity']);

    return redirect()->route('sales.index')->with('success', 'Sale recorded.');
}


    public function edit(Sale $sale)
    {
        return Inertia::render('Sales/Edit', [
            'sale' => $sale->load(['product', 'customer']),
            'products' => Product::all(),
            'customers' => Customer::all(),
        ]);
    }

   public function update(Request $request, Sale $sale)
{
    $data = $request->validate([
        'product_id' => 'required|exists:products,id',
        'customer_id' => 'required|exists:customers,id',
        'quantity' => 'required|integer|min:1',
    ]);

    $oldProduct = Product::find($sale->product_id);
    $newProduct = Product::findOrFail($data['product_id']);

    // Quantity difference and product check
    if ($sale->product_id == $data['product_id']) {
        // Same product, calculate difference in quantity
        $quantityDiff = $data['quantity'] - $sale->quantity;

        if ($quantityDiff > 0) {
            // Need to deduct extra stock from product
            if ($newProduct->stock < $quantityDiff) {
                return back()->withErrors(['quantity' => 'Not enough stock available.']);
            }
            $newProduct->decrement('stock', $quantityDiff);
        } elseif ($quantityDiff < 0) {
            // Add back stock because quantity decreased
            $newProduct->increment('stock', abs($quantityDiff));
        }
    } else {
        // Different product selected
        // Restore stock for old product
        if ($oldProduct) {
            $oldProduct->increment('stock', $sale->quantity);
        }
        // Deduct stock for new product
        if ($newProduct->stock < $data['quantity']) {
            return back()->withErrors(['quantity' => 'Not enough stock available for the new product.']);
        }
        $newProduct->decrement('stock', $data['quantity']);
    }

    // Update sale record
    $sale->update([
        'product_id' => $data['product_id'],
        'customer_id' => $data['customer_id'],
        'quantity' => $data['quantity'],
        'total_price' => $newProduct->price * $data['quantity'],
    ]);

    return redirect()->route('sales.index')->with('success', 'Sale updated successfully.');
}
}