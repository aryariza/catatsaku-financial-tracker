<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function filter(Request $request)
    {
        $userId = Auth::id();
        $query = Transaction::where('user_id', $userId);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('transaction_date', [$request->start_date, $request->end_date]);
        }

        if ($request->filled('type')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('type', $request->type);
            });
        }

        $transactions = $query->with(['wallet', 'category'])->latest()->get();
        $wallets = Wallet::where('user_id', $userId)->get();
        $categories = Category::where('user_id', $userId)->get();

        return view('reports.filter', compact('transactions', 'wallets', 'categories'));
    }

    public function chart()
    {
        $userId = Auth::id();
        $labels = [];
        $incomeData = [];
        $expenseData = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $labels[] = $month->translatedFormat('M Y'); 

            $income = Transaction::where('user_id', $userId)
                ->whereHas('category', function($q) {
                    $q->where('type', 'income');
                })
                ->whereMonth('transaction_date', $month->month)
                ->whereYear('transaction_date', $month->year)
                ->sum('amount');

            $expense = Transaction::where('user_id', $userId)
                ->whereHas('category', function($q) {
                    $q->where('type', 'expense');
                })
                ->whereMonth('transaction_date', $month->month)
                ->whereYear('transaction_date', $month->year)
                ->sum('amount');

            $incomeData[] = $income;
            $expenseData[] = $expense;
        }

        return view('reports.chart', compact('labels', 'incomeData', 'expenseData'));
    }
}