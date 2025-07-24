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

        return Inertia::render('Sales/Index', [
            'sales' => $sales,
        ]);
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

        $product = Product::findOrFail($data['product_id']);

        if ($product->stock < $data['quantity']) {
            return back()->withErrors(['quantity' => 'Not enough stock available.']);
        }

        $sale = Sale::create([
            'product_id' => $data['product_id'],
            'customer_id' => $data['customer_id'],
            'quantity' => $data['quantity'],
            'total_price' => $product->price * $data['quantity'],
        ]);

        $product->decrement('stock', $data['quantity']);

        return redirect()->route('sales.index')->with('success', 'Sale recorded successfully.');
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

        if ($sale->product_id == $data['product_id']) {
            $quantityDiff = $data['quantity'] - $sale->quantity;

            if ($quantityDiff > 0) {
                if ($newProduct->stock < $quantityDiff) {
                    return back()->withErrors(['quantity' => 'Not enough stock available.']);
                }
                $newProduct->decrement('stock', $quantityDiff);
            } elseif ($quantityDiff < 0) {
                $newProduct->increment('stock', abs($quantityDiff));
            }
        } else {
            if ($oldProduct) {
                $oldProduct->increment('stock', $sale->quantity);
            }

            if ($newProduct->stock < $data['quantity']) {
                return back()->withErrors(['quantity' => 'Not enough stock available for the selected product.']);
            }

            $newProduct->decrement('stock', $data['quantity']);
        }

        $sale->update([
            'product_id' => $data['product_id'],
            'customer_id' => $data['customer_id'],
            'quantity' => $data['quantity'],
            'total_price' => $newProduct->price * $data['quantity'],
        ]);

        return redirect()->route('sales.index')->with('success', 'Sale updated successfully.');
    }

    public function report(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $customerId = $request->input('customer_id');
        $productId = $request->input('product_id');

        $query = Sale::with(['customer', 'product'])->latest();

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        if ($customerId) {
            $query->where('customer_id', $customerId);
        }

        if ($productId) {
            $query->where('product_id', $productId);
        }

        $sales = $query->get();
        $totalSales = $sales->sum('total_price');

        return Inertia::render('Sales/Report', [
            'sales' => $sales,
            'totalSales' => $totalSales,
            'customers' => Customer::all(),
            'products' => Product::all(),
            'filters' => [
                'start_date' => $startDate,
                'end_date' => $endDate,
                'customer_id' => $customerId,
                'product_id' => $productId,
            ],
        ]);
    }
}
