<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        $wallets = Wallet::where('user_id', $userId)->get();
        
        return view('wallets.index', compact('wallets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'balance' => 'required|numeric|min:0',
        ]);

        Wallet::create([
            'user_id' => Auth::id(), 
            'name' => $request->name,
            'balance' => $request->balance,
        ]);

        return redirect()->back()->with('success', 'Dompet berhasil ditambahkan!');
    }

    public function destroy(Wallet $wallet)
    {
        $wallet->delete();
        return redirect()->back()->with('success', 'Dompet berhasil dihapus!');
    }
}