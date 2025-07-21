<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'stats' => [
                'sales_income' => Sale::sum('total_price'),
                'customers_count' => Customer::count(),
                'users_count' => User::count(),
                'products_count' => Product::count(),
            ],
        ]);
    }
}
