<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of customers.
     */
    public function index(): Response
    {
        $customers = Customer::latest()->get();

        return Inertia::render('Customers/Index', [
            'customers' => $customers,
        ]);
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create(): Response
    {
        return Inertia::render('Customers/Create');
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'required|string|max:20',
        ]);

        Customer::create($validated);

        return redirect()->route('customers.index')->with('success', 'Customer added.');
    }

    /**
     * Show the form for editing the specified customer.
     */
    public function edit(Customer $customer): Response
    {
        return Inertia::render('Customers/Edit', [
            'customer' => $customer,
        ]);
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'phone' => 'required|string|max:20',
        ]);

        $customer->update($validated);

        return redirect()->route('customers.index')->with('success', 'Customer updated.');
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }

    /**
     * Show the customer report.
     */
    public function report(Request $request): Response
    {
        $query = Customer::query()
            ->withCount(['sales as total_orders'])
            ->withSum('sales as total_spent', 'total_price');

        // Filters
        if ($request->start_date) {
            $query->whereHas('sales', function ($q) use ($request) {
                $q->whereDate('created_at', '>=', $request->start_date);
            });
        }

        if ($request->end_date) {
            $query->whereHas('sales', function ($q) use ($request) {
                $q->whereDate('created_at', '<=', $request->end_date);
            });
        }

        $customers = $query->get();
        $totalSpent = $customers->sum('total_spent');

        return Inertia::render('Customers/Report', [
            'customers' => $customers,
            'filters' => $request->only(['start_date', 'end_date']),
            'totalSpent' => $totalSpent,
        ]);
    }
}
