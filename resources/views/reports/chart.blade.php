@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Ringkasan Grafik & Analitik</h1>
    <p class="text-sm font-medium text-slate-600 mt-0.5">Visualisasi pergerakan arus kas keuangan berdasarkan transaksi aktual Anda.</p>
</div>

<div id="chartDataContainer" 
     data-labels="{{ json_encode($labels) }}" 
     data-income="{{ json_encode($incomeData) }}" 
     data-expense="{{ json_encode($expenseData) }}" 
     class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

    <div class="bg-white p-6 rounded-2xl border-2 border-slate-900 shadow-[4px_4px_0px_0px_rgba(15,23,42,1)] lg:col-span-2">
        <h3 class="text-base font-extrabold text-slate-900 mb-6">Tren 6 Bulan Terakhir</h3>
        <div class="relative h-80 w-full">
            <canvas id="trendChart"></canvas>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl border-2 border-slate-900 shadow-[4px_4px_0px_0px_rgba(15,23,42,1)] flex flex-col justify-between">
        <div>
            <h3 class="text-base font-extrabold text-slate-900 mb-3">Analisis Keuangan</h3>
            <p class="text-sm font-semibold text-slate-600 leading-relaxed mb-4">
                Grafik di samping merangkum aktivitas pemasukan dan pengeluaran secara otomatis selama 6 bulan ke belakang berdasarkan data transaksi yang tersimpan.
            </p>
        </div>
        <div class="p-4 bg-amber-100 border-2 border-slate-900 rounded-xl shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]">
            <div class="text-xs font-extrabold text-slate-900 uppercase tracking-wider mb-1">Status Sistem</div>
            <p class="text-xs font-bold text-slate-700 leading-relaxed">
                Grafik terhubung secara real-time dengan database sistem Anda.
            </p>
        </div>
    </div>
</div>

<div class="bg-white p-6 rounded-2xl border-2 border-slate-900 shadow-[4px_4px_0px_0px_rgba(15,23,42,1)]">
    <h3 class="text-base font-extrabold text-slate-900 mb-2">Informasi Arus Kas</h3>
    <p class="text-sm font-semibold text-slate-600">
        Pastikan seluruh pencatatan transaksi dicatat secara rutin agar grafik analitik mencerminkan kondisi finansial yang akurat.
    </p>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const container = document.getElementById('chartDataContainer');
        if (!container) return;

        const labels = JSON.parse(container.getAttribute('data-labels'));
        const incomeData = JSON.parse(container.getAttribute('data-income'));
        const expenseData = JSON.parse(container.getAttribute('data-expense'));

        const canvasElement = document.getElementById('trendChart');
        if (!canvasElement) return;

        const ctx = canvasElement.getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: incomeData,
                        backgroundColor: '#10B981',
                        borderColor: '#0F172A',
                        borderWidth: 2,
                        borderRadius: 6,
                    },
                    {
                        label: 'Pengeluaran',
                        data: expenseData,
                        backgroundColor: '#EF4444',
                        borderColor: '#0F172A',
                        borderWidth: 2,
                        borderRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                family: 'Plus Jakarta Sans',
                                weight: '700',
                                size: 12
                            },
                            color: '#0F172A',
                            usePointStyle: true,
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { 
                            font: { family: 'Plus Jakarta Sans', weight: '600' },
                            color: '#0F172A'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: '#F1F5F9' },
                        ticks: { 
                            font: { family: 'Plus Jakarta Sans', weight: '600' },
                            color: '#0F172A'
                        }
                    }
                }
            }
        });
    });
</script>
@endsection