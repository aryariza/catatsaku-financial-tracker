@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-blue-100">
        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-blue-600">Manajemen Profil</h1>
            <p class="text-sm text-gray-500">Perbarui informasi akun dan kata sandi Anda di sini.</p>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                    class="w-full text-sm border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                    class="w-full text-sm border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:border-blue-500">
            </div>

            <hr class="my-6 border-gray-100">

            <h3 class="text-sm font-bold text-gray-800">Ubah Kata Sandi (Opsional)</h3>
            
            <div>
                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Kata Sandi Saat Ini</label>
                <input type="password" name="current_password" placeholder="Kosongkan jika tidak ingin mengubah password" 
                    class="w-full text-sm border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Kata Sandi Baru</label>
                <input type="password" name="new_password" placeholder="Minimal 6 karakter" 
                    class="w-full text-sm border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Konfirmasi Kata Sandi Baru</label>
                <input type="password" name="new_password_confirmation" placeholder="Ulangi kata sandi baru" 
                    class="w-full text-sm border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:border-blue-500">
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full bg-blue-600 text-white font-semibold text-sm py-2.5 rounded-xl hover:bg-blue-700 transition">
                    Simpan Perubahan Profil
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-red-100 flex items-center justify-between">
        <div>
            <h3 class="text-sm font-bold text-gray-800">Keluar dari Akun</h3>
            <p class="text-xs text-gray-500">Akhiri sesi login Anda saat ini di perangkat ini.</p>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-50 text-red-600 border border-red-200 font-semibold text-xs px-4 py-2 rounded-xl hover:bg-red-100 transition">
                Keluar Aplikasi
            </button>
        </form>
    </div>
</div>
@endsection