@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Kelola Dompet</h1>
    <p class="text-sm font-medium text-slate-600 mt-0.5">Tambah dan pantau seluruh sumber rekening atau dompet finansial Anda.</p>
</div>

<div class="bg-white p-6 rounded-2xl border-2 border-slate-900 shadow-[4px_4px_0px_0px_rgba(15,23,42,1)] mb-8">
    <h3 class="text-base font-extrabold text-slate-900 mb-4">Tambah Dompet Baru</h3>
    
    <form action="{{ route('wallets.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Dompet</label>
                <input type="text" name="name" placeholder="Contoh: BCA, Dompet Tunai" required class="w-full bg-slate-50 border-2 border-slate-900 rounded-xl px-4 py-3 text-sm font-semibold text-slate-900 focus:outline-none focus:bg-white transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Saldo Awal</label>
                <input type="number" name="balance" placeholder="0" required class="w-full bg-slate-50 border-2 border-slate-900 rounded-xl px-4 py-3 text-sm font-semibold text-slate-900 focus:outline-none focus:bg-white transition">
            </div>
        </div>
        <button type="submit" class="px-6 py-3 bg-amber-300 hover:bg-amber-400 text-slate-900 font-extrabold text-sm rounded-xl border-2 border-slate-900 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)] transition">
            Simpan Dompet
        </button>
    </form>
</div>

<div class="bg-white rounded-2xl border-2 border-slate-900 shadow-[4px_4px_0px_0px_rgba(15,23,42,1)] overflow-hidden">
    <div class="p-6 border-b-2 border-slate-900 bg-slate-50">
        <h3 class="text-base font-extrabold text-slate-900">Daftar Dompet</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-100 text-slate-900 text-xs uppercase tracking-wider font-extrabold border-b-2 border-slate-900">
                    <th class="py-3.5 px-6">No</th>
                    <th class="py-3.5 px-6">Nama Dompet</th>
                    <th class="py-3.5 px-6">Saldo</th>
                    <th class="py-3.5 px-6">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y-2 divide-slate-900 text-sm font-semibold">
                @forelse($wallets as $index => $wallet)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="py-4 px-6 text-slate-600">{{ $index + 1 }}</td>
                        <td class="py-4 px-6 font-bold text-slate-900">{{ $wallet->name }}</td>
                        <td class="py-4 px-6 font-extrabold text-slate-900">Rp {{ number_format($wallet->balance, 2, ',', '.') }}</td>
                        <td class="py-4 px-6">
                            <form action="{{ route('wallets.destroy', $wallet->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus dompet ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 bg-rose-200 text-slate-900 border-2 border-slate-900 rounded-lg text-xs font-bold hover:bg-rose-300 transition shadow-[1px_1px_0px_0px_rgba(15,23,42,1)]">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-slate-500 font-bold text-sm">Belum ada data dompet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection