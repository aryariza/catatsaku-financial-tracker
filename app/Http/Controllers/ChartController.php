<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ChartController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', Carbon::now()->endOfDay()->toDateString());

        $totalIncome = Transaction::where('user_id', $userId)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->where('type', 'income')
            ->sum('amount');

        $totalExpense = Transaction::where('user_id', $userId)
            ->whereBetween('transaction_date', [$startDate, $endDate])
            ->where('type', 'expense')
            ->sum('amount');
        
        $netBalance = $totalIncome - $totalExpense;

        $maxVal = max($totalIncome, $totalExpense, 1);
        $incomePercent = ($totalIncome / $maxVal) * 100;
        $expensePercent = ($totalExpense / $maxVal) * 100;

        return view('reports.chart', compact('totalIncome', 'totalExpense', 'netBalance', 'incomePercent', 'expensePercent', 'startDate', 'endDate'));
    }
}