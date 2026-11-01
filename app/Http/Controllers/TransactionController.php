<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class TransactionController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); 

        $transactions = Transaction::with(['wallet', 'category'])->where('user_id', $userId)->latest()->get();
        $wallets = Wallet::where('user_id', $userId)->get();
        $categories = Category::where('user_id', $userId)->get();
        
        return view('transactions.index', compact('transactions', 'wallets', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'wallet_id' => 'required|exists:wallets,id',
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'transaction_date' => 'required|date',
            'description' => 'nullable|string|max:255',
        ]);

        $wallet = Wallet::findOrFail($request->wallet_id);
        $category = Category::findOrFail($request->category_id);

        if ($category->type == 'income') {
            $wallet->balance += $request->amount;
        } else {
            $wallet->balance -= $request->amount;
        }
        $wallet->save();

        Transaction::create([
            'user_id' => Auth::id(), 
            'wallet_id' => $request->wallet_id,
            'category_id' => $request->category_id,
            'type' => $category->type,
            'amount' => $request->amount,
            'transaction_date' => $request->transaction_date,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil dicatat dan saldo diperbarui!');
    }

    public function destroy(Transaction $transaction)
    {
        $wallet = $transaction->wallet;
        $category = $transaction->category;

        if ($category->type == 'income') {
            $wallet->balance -= $transaction->amount;
        } else {
            $wallet->balance += $transaction->amount;
        }
        $wallet->save();

        $transaction->delete();
        return redirect()->back()->with('success', 'Transaksi berhasil dihapus dan saldo dikembalikan!');
    }
}