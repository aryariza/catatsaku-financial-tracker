<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CatatSaku - Financial Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex">

    <aside class="w-64 bg-slate-50 border-r-2 border-slate-900 flex flex-col fixed inset-y-0 z-50">
        <div class="h-20 px-6 border-b-2 border-slate-900 flex items-center bg-slate-50">
            <a href="{{ route('dashboard') }}" class="text-xl font-extrabold text-slate-900 tracking-tight">
                CatatSaku
            </a>
        </div>

        <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition {{ request()->routeIs('dashboard') ? 'bg-amber-300 text-slate-900 border-2 border-slate-900 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]' : 'text-slate-600 hover:bg-slate-200/60' }}">
                Dashboard
            </a>
            <a href="{{ route('wallets.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition {{ request()->routeIs('wallets.*') ? 'bg-amber-300 text-slate-900 border-2 border-slate-900 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]' : 'text-slate-600 hover:bg-slate-200/60' }}">
                Dompet
            </a>
            <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition {{ request()->routeIs('categories.*') ? 'bg-amber-300 text-slate-900 border-2 border-slate-900 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]' : 'text-slate-600 hover:bg-slate-200/60' }}">
                Kategori
            </a>
            <a href="{{ route('transactions.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition {{ request()->routeIs('transactions.*') ? 'bg-amber-300 text-slate-900 border-2 border-slate-900 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]' : 'text-slate-600 hover:bg-slate-200/60' }}">
                Transaksi
            </a>

            <div class="pt-4 pb-2">
                <div class="px-4 text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Fitur Tambahan</div>
            </div>

            <a href="{{ route('reports.filter') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition {{ request()->routeIs('reports.filter') ? 'bg-amber-300 text-slate-900 border-2 border-slate-900 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]' : 'text-slate-600 hover:bg-slate-200/60' }}">
                Pencarian & Filter
            </a>
            <a href="{{ route('reports.chart') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition {{ request()->routeIs('reports.chart') ? 'bg-amber-300 text-slate-900 border-2 border-slate-900 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]' : 'text-slate-600 hover:bg-slate-200/60' }}">
                Ringkasan Grafik
            </a>
        </nav>

        <div class="p-4 border-t-2 border-slate-900 bg-slate-50">
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition {{ request()->routeIs('profile.*') ? 'bg-amber-300 text-slate-900 border-2 border-slate-900 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]' : 'text-slate-600 hover:bg-slate-200/60' }}">
                Profil
            </a>
        </div>
    </aside>

    <div class="flex-1 ml-64 flex flex-col min-h-screen">
        <header class="bg-slate-50 h-20 border-b-2 border-slate-900 px-8 flex items-center justify-between sticky top-0 z-40">
            <div class="text-sm font-extrabold text-slate-900">
                Selamat Datang, {{ Auth::user()->name ?? 'Pengguna' }}
            </div>
            <div class="flex items-center gap-4">
                <span class="text-xs font-bold px-4 py-2 bg-amber-200 border-2 border-slate-900 text-slate-900 rounded-xl shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]">
                    {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                </span>
            </div>
        </header>

        <main class="flex-1 p-8 max-w-7xl w-full mx-auto">
            @if(session('success'))
                <div class="bg-emerald-200 border-2 border-slate-900 text-slate-900 p-4 rounded-2xl shadow-[4px_4px_0px_0px_rgba(15,23,42,1)] mb-6 flex justify-between items-center text-sm font-bold">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>