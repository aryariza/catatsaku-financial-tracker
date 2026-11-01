@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Ringkasan Keuangan</h1>
    <p class="text-sm font-medium text-slate-600 mt-0.5">Pantau arus kas dan total saldo dompet Anda di sini.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-amber-100 p-6 rounded-2xl border-2 border-slate-900 shadow-[4px_4px_0px_0px_rgba(15,23,42,1)] flex flex-col justify-between">
        <span class="text-xs font-extrabold text-slate-800 uppercase tracking-wider mb-2">Total Saldo Dompet</span>
        <h2 class="text-2xl font-extrabold text-slate-900">
            Rp {{ number_format($totalBalance ?? 0, 2, ',', '.') }}
        </h2>
    </div>

    <div class="bg-rose-100 p-6 rounded-2xl border-2 border-slate-900 shadow-[4px_4px_0px_0px_rgba(15,23,42,1)] flex flex-col justify-between">
        <span class="text-xs font-extrabold text-slate-800 uppercase tracking-wider mb-2">Total Pemasukan</span>
        <h2 class="text-2xl font-extrabold text-emerald-700">
            + Rp {{ number_format($totalIncome ?? 0, 2, ',', '.') }}
        </h2>
    </div>

    <div class="bg-blue-100 p-6 rounded-2xl border-2 border-slate-900 shadow-[4px_4px_0px_0px_rgba(15,23,42,1)] flex flex-col justify-between">
        <span class="text-xs font-extrabold text-slate-800 uppercase tracking-wider mb-2">Total Pengeluaran</span>
        <h2 class="text-2xl font-extrabold text-rose-700">
            - Rp {{ number_format($totalExpense ?? 0, 2, ',', '.') }}
        </h2>
    </div>
</div>

<div class="bg-white p-6 rounded-2xl border-2 border-slate-900 shadow-[4px_4px_0px_0px_rgba(15,23,42,1)] mb-8">
    <h3 class="text-base font-extrabold text-slate-900 mb-1">Pengeluaran Berdasarkan Kategori</h3>
    <p class="text-xs font-semibold text-slate-500 mb-6">Pantau alokasi pengeluaran pada setiap kategori secara mendetail.</p>

    @if(isset($expensesByCategory) && count($expensesByCategory) > 0)
        <div class="space-y-4">
            @foreach($expensesByCategory as $item)
                @php
                    $percent = min(round($item->percentage ?? 0), 100);
                @endphp
                <div>
                    <div class="flex justify-between items-center text-sm font-bold mb-1.5">
                        <span class="text-slate-800">{{ $item->category_name }}</span>
                        <span class="text-rose-600">Rp {{ number_format($item->total, 2, ',', '.') }}</span>
                    </div>
                    <div class="w-full bg-slate-100 h-3 rounded-full border border-slate-900 overflow-hidden">
                        <div class="bg-rose-500 h-full rounded-full" data-width="{{ $percent }}" id="bar-{{ $loop->index }}"></div>
                    </div>
                    <div class="text-right text-[10px] font-bold text-slate-400 mt-1">
                        {{ number_format($item->percentage ?? 0, 1) }}% dari total pengeluaran
                    </div>
                </div>
            @endforeach
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                document.querySelectorAll('[id^="bar-"]').forEach(function(el) {
                    var w = el.getAttribute('data-width');
                    el.style.width = w + '%';
                });
            });
        </script>
    @else
        <div class="py-8 text-center text-slate-500 font-bold text-sm">
            Belum ada data pengeluaran per kategori yang tercatat.
        </div>
    @endif
</div>

<div class="bg-white rounded-2xl border-2 border-slate-900 shadow-[4px_4px_0px_0px_rgba(15,23,42,1)] overflow-hidden">
    <div class="p-6 border-b-2 border-slate-900 bg-slate-50 flex justify-between items-center">
        <h3 class="text-base font-extrabold text-slate-900">5 Transaksi Terakhir</h3>
        <a href="{{ route('transactions.index') }}" class="text-xs font-bold text-blue-600 hover:underline">Lihat Semua &rarr;</a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-100 text-slate-900 text-xs uppercase tracking-wider font-extrabold border-b-2 border-slate-900">
                    <th class="py-3.5 px-6">Tanggal</th>
                    <th class="py-3.5 px-6">Dompet</th>
                    <th class="py-3.5 px-6">Kategori</th>
                    <th class="py-3.5 px-6">Nominal</th>
                    <th class="py-3.5 px-6">Keterangan</th>
                </tr>
            </thead>
            <tbody class="divide-y-2 divide-slate-900 text-sm font-semibold">
                @if(isset($latestTransactions) && count($latestTransactions) > 0)
                    @foreach($latestTransactions as $trx)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-4 px-6 text-slate-600">{{ $trx->transaction_date }}</td>
                            <td class="py-4 px-6 font-bold text-slate-900">{{ $trx->wallet->name ?? '-' }}</td>
                            <td class="py-4 px-6 text-slate-700">{{ $trx->category->name ?? '-' }}</td>
                            <td class="py-4 px-6 font-extrabold {{ optional($trx->category)->type == 'income' ? 'text-emerald-700' : 'text-rose-700' }}">
                                {{ optional($trx->category)->type == 'income' ? '+' : '-' }} Rp {{ number_format($trx->amount, 2, ',', '.') }}
                            </td>
                            <td class="py-4 px-6 text-slate-600">{{ $trx->description ?: '-' }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="py-8 text-center text-slate-500 font-bold text-sm">Belum ada data transaksi.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection