<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Today's sales
        $todaySales = $user->transactions()
            ->whereDate('transaction_date', today())
            ->sum('total_amount');
        
        // This month sales
        $monthSales = $user->transactions()
            ->whereYear('transaction_date', now()->year)
            ->whereMonth('transaction_date', now()->month)
            ->sum('total_amount');
        
        // Total products
        $totalProducts = $user->products()->where('is_active', true)->count();

        // Total categories
        $totalCategories = $user->categories()->count();
        
        // Total transactions this month
        $monthTransactions = $user->transactions()
            ->whereYear('transaction_date', now()->year)
            ->whereMonth('transaction_date', now()->month)
            ->count();
        
        // Recent transactions
        $recentTransactions = $user->transactions()
            ->with('items')
            ->latest('transaction_date')
            ->take(5)
            ->get();
        
        // Top products this month — grouped by snapshot name (preserves history)
        $topProducts = DB::table('transaction_items')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->where('transactions.user_id', $user->id)
            ->whereYear('transactions.transaction_date',  now()->year)
            ->whereMonth('transactions.transaction_date', now()->month)
            ->select('transaction_items.product_name as name', DB::raw('SUM(transaction_items.quantity) as total_qty'))
            ->groupBy('transaction_items.product_name')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        // Sales chart data (last 7 days)
        $salesChart = $user->transactions()
            ->whereBetween('transaction_date', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
            ->select(
                DB::raw('DATE(transaction_date) as date'),
                DB::raw('SUM(total_amount) as total')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('dashboard', compact(
            'todaySales',
            'monthSales',
            'totalProducts',
            'totalCategories',
            'monthTransactions',
            'recentTransactions',
            'topProducts',
            'salesChart'
        ));
    }
}
