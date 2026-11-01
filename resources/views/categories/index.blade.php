@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Kelola Kategori</h1>
    <p class="text-sm font-medium text-slate-600 mt-0.5">Atur kategori pemasukan dan pengeluaran transaksi Anda.</p>
</div>

<div class="bg-white p-6 rounded-2xl border-2 border-slate-900 shadow-[4px_4px_0px_0px_rgba(15,23,42,1)] mb-8">
    <h3 class="text-base font-extrabold text-slate-900 mb-4">Tambah Kategori Baru</h3>
    
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Kategori</label>
                <input type="text" name="name" placeholder="Contoh: Gaji, Makanan, Transportasi" required class="w-full bg-slate-50 border-2 border-slate-900 rounded-xl px-4 py-3 text-sm font-semibold text-slate-900 focus:outline-none focus:bg-white transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tipe Kategori</label>
                <select name="type" required class="w-full bg-slate-50 border-2 border-slate-900 rounded-xl px-4 py-3 text-sm font-semibold text-slate-900 focus:outline-none focus:bg-white transition">
                    <option value="" disabled selected>Pilih Tipe</option>
                    <option value="income">Pemasukan (Income)</option>
                    <option value="expense">Pengeluaran (Expense)</option>
                </select>
            </div>
        </div>
        <button type="submit" class="px-6 py-3 bg-amber-300 hover:bg-amber-400 text-slate-900 font-extrabold text-sm rounded-xl border-2 border-slate-900 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)] transition">
            Simpan Kategori
        </button>
    </form>
</div>

<div class="bg-white rounded-2xl border-2 border-slate-900 shadow-[4px_4px_0px_0px_rgba(15,23,42,1)] overflow-hidden">
    <div class="p-6 border-b-2 border-slate-900 bg-slate-50">
        <h3 class="text-base font-extrabold text-slate-900">Daftar Kategori</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-100 text-slate-900 text-xs uppercase tracking-wider font-extrabold border-b-2 border-slate-900">
                    <th class="py-3.5 px-6">No</th>
                    <th class="py-3.5 px-6">Nama Kategori</th>
                    <th class="py-3.5 px-6">Tipe</th>
                    <th class="py-3.5 px-6">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y-2 divide-slate-900 text-sm font-semibold">
                @forelse($categories as $index => $category)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="py-4 px-6 text-slate-600">{{ $index + 1 }}</td>
                        <td class="py-4 px-6 font-bold text-slate-900">{{ $category->name }}</td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-extrabold border-2 border-slate-900 {{ $category->type == 'income' ? 'bg-emerald-200 text-slate-900' : 'bg-rose-200 text-slate-900' }}">
                                {{ $category->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 bg-rose-200 text-slate-900 border-2 border-slate-900 rounded-lg text-xs font-bold hover:bg-rose-300 transition shadow-[1px_1px_0px_0px_rgba(15,23,42,1)]">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-8 text-center text-slate-500 font-bold text-sm">Belum ada data kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection