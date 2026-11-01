<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - CatatSaku</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-white p-8 rounded-2xl border-2 border-slate-900 shadow-[6px_6px_0px_0px_rgba(15,23,42,1)]">
        
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">CatatSaku</h1>
            <p class="text-xs font-bold text-slate-500 mt-1 uppercase tracking-wider">Daftar akun baru untuk mulai mencatat</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-rose-100 border-2 border-slate-900 rounded-xl text-xs font-bold text-rose-700 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full px-4 py-2.5 bg-white border-2 border-slate-900 rounded-xl text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-400 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]"
                    placeholder="Nama Lengkap Anda">
            </div>

            <div class="mb-4">
                <label class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-2.5 bg-white border-2 border-slate-900 rounded-xl text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-400 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]"
                    placeholder="nama@email.com">
            </div>

            <div class="mb-4">
                <label class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider mb-2">Password</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2.5 bg-white border-2 border-slate-900 rounded-xl text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-400 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]"
                    placeholder="••••••••">
            </div>

            <div class="mb-6">
                <label class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required
                    class="w-full px-4 py-2.5 bg-white border-2 border-slate-900 rounded-xl text-sm font-semibold text-slate-900 focus:outline-none focus:ring-2 focus:ring-amber-400 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]"
                    placeholder="••••••••">
            </div>

            <button type="submit" 
                class="w-full py-3 bg-amber-300 hover:bg-amber-400 text-slate-900 font-extrabold text-sm rounded-xl border-2 border-slate-900 shadow-[4px_4px_0px_0px_rgba(15,23,42,1)] active:translate-x-[2px] active:translate-y-[2px] active:shadow-[2px_2px_0px_0px_rgba(15,23,42,1)] transition-all">
                Daftar
            </button>
        </form>

        <div class="text-center mt-6">
            <p class="text-xs font-semibold text-slate-600">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-extrabold text-blue-600 hover:underline">Masuk di sini</a>
            </p>
        </div>

    </div>

</body>
</html>