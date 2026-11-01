<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        $totalBalance = Wallet::where('user_id', $userId)->sum('balance');
        
        $totalIncome = Transaction::where('user_id', $userId)
            ->whereHas('category', function($q) {
                $q->where('type', 'income');
            })->sum('amount');
            
        $totalExpense = Transaction::where('user_id', $userId)
            ->whereHas('category', function($q) {
                $q->where('type', 'expense');
            })->sum('amount');

        $recentTransactions = Transaction::with(['wallet', 'category'])
            ->where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        $categoryExpenses = Transaction::select('category_id', DB::raw('SUM(amount) as total'))
            ->where('user_id', $userId)
            ->whereHas('category', function($q) {
                $q->where('type', 'expense');
            })
            ->groupBy('category_id')
            ->with('category')
            ->get();

        return view('dashboard', compact(
            'totalBalance', 
            'totalIncome', 
            'totalExpense', 
            'recentTransactions', 
            'categoryExpenses' 
        ));
    }
}