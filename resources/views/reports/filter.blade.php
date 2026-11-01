@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Pencarian & Filter Transaksi</h1>
    <p class="text-sm font-medium text-slate-600 mt-0.5">Cari dan saring data transaksi berdasarkan rentang tanggal atau jenisnya.</p>
</div>

<div class="bg-white p-6 rounded-2xl border-2 border-slate-900 shadow-[4px_4px_0px_0px_rgba(15,23,42,1)] mb-8">
    <form action="{{ route('reports.filter') }}" method="GET">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full bg-slate-50 border-2 border-slate-900 rounded-xl px-4 py-3 text-sm font-semibold text-slate-900 focus:outline-none focus:bg-white transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full bg-slate-50 border-2 border-slate-900 rounded-xl px-4 py-3 text-sm font-semibold text-slate-900 focus:outline-none focus:bg-white transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jenis Transaksi</label>
                <select name="type" class="w-full bg-slate-50 border-2 border-slate-900 rounded-xl px-4 py-3 text-sm font-semibold text-slate-900 focus:outline-none focus:bg-white transition">
                    <option value="">Semua Jenis</option>
                    <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                    <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                </select>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button type="submit" class="px-6 py-3 bg-amber-300 hover:bg-amber-400 text-slate-900 font-extrabold text-sm rounded-xl border-2 border-slate-900 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)] transition">
                Filter Data
            </button>
            <a href="{{ route('reports.filter') }}" class="px-6 py-3 bg-slate-100 hover:bg-slate-200 text-slate-900 font-extrabold text-sm rounded-xl border-2 border-slate-900 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)] transition">
                Reset
            </a>
        </div>
    </form>
</div>

<div class="bg-white rounded-2xl border-2 border-slate-900 shadow-[4px_4px_0px_0px_rgba(15,23,42,1)] overflow-hidden">
    <div class="p-6 border-b-2 border-slate-900 bg-slate-50">
        <h3 class="text-base font-extrabold text-slate-900">Hasil Filter Transaksi</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-100 text-slate-900 text-xs uppercase tracking-wider font-extrabold border-b-2 border-slate-900">
                    <th class="py-3.5 px-6">Tanggal</th>
                    <th class="py-3.5 px-6">Dompet</th>
                    <th class="py-3.5 px-6">Kategori</th>
                    <th class="py-3.5 px-6">Jenis</th>
                    <th class="py-3.5 px-6">Nominal</th>
                    <th class="py-3.5 px-6">Keterangan</th>
                </tr>
            </thead>
            <tbody class="divide-y-2 divide-slate-900 text-sm font-semibold">
                @isset($transactions)
                    @forelse($transactions as $trx)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="py-4 px-6 text-slate-600">{{ $trx->transaction_date }}</td>
                            <td class="py-4 px-6 font-bold text-slate-900">{{ $trx->wallet->name ?? '-' }}</td>
                            <td class="py-4 px-6">{{ $trx->category->name ?? '-' }}</td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-extrabold border-2 border-slate-900 {{ optional($trx->category)->type == 'income' ? 'bg-emerald-200 text-slate-900' : 'bg-rose-200 text-slate-900' }}">
                                    {{ optional($trx->category)->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 font-extrabold {{ optional($trx->category)->type == 'income' ? 'text-emerald-700' : 'text-rose-700' }}">
                                {{ optional($trx->category)->type == 'income' ? '+' : '-' }} Rp {{ number_format($trx->amount, 2, ',', '.') }}
                            </td>
                            <td class="py-4 px-6 text-slate-600">{{ $trx->description ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-500 font-bold text-sm">Belum ada data transaksi yang sesuai filter.</td>
                        </tr>
                    @endforelse
                @else
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-500 font-bold text-sm">Silakan pilih filter dan klik "Filter Data".</td>
                    </tr>
                @endisset
            </tbody>
        </table>
    </div>
</div>
@endsection