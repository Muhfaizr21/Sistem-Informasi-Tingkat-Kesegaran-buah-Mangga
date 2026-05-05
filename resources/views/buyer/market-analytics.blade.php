<x-buyer-layout>
    <x-slot name="title">Analisis Pasar</x-slot>

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Analisis Pasar Mangga</h1>
        <p class="text-gray-500 mt-1">Pantau tren harga dan ketersediaan stok untuk belanja lebih cerdas.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Main Price Chart -->
        <div class="lg:col-span-8 bg-white dark:bg-gray-900 p-8 rounded-[2.5rem] border border-gray-100 dark:border-gray-800 shadow-sm">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-lg font-bold">Tren Harga Per Kilogram</h2>
                <select class="text-xs bg-gray-50 border-none rounded-lg focus:ring-0 cursor-pointer">
                    <option>7 Hari Terakhir</option>
                    <option>30 Hari Terakhir</option>
                </select>
            </div>
            <div class="h-80 w-full relative">
                <canvas id="priceChart"></canvas>
            </div>
        </div>

        <!-- Price Breakdown -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-primary/10 p-6 rounded-[2rem] border border-primary/20">
                <h3 class="font-bold text-gray-900 mb-4">Rata-rata Harga Hari Ini</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium">Harum Manis</span>
                        <span class="font-bold text-primary">Rp 25.000</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium">Gedong Gincu</span>
                        <span class="font-bold text-primary">Rp 35.000</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium">Cengkir</span>
                        <span class="font-bold text-primary">Rp 20.000</span>
                    </div>
                </div>
            </div>

            <div class="bg-gray-900 p-6 rounded-[2rem] text-white">
                <p class="text-xs font-bold text-gray-400 uppercase mb-2">Prediksi Pasar</p>
                <p class="text-sm leading-relaxed">
                    Harga diprediksi akan <span class="text-secondary font-bold">Turun 5%</span> minggu depan karena puncak panen di wilayah Indramayu Barat.
                </p>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('priceChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                    datasets: [{
                        label: 'Harga (Rp)',
                        data: [28000, 27500, 26000, 25500, 25000, 25000, 25000],
                        borderColor: '#FBBF24',
                        backgroundColor: 'rgba(251, 191, 36, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 4,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { 
                            beginAtZero: false,
                            grid: { display: false },
                            ticks: { font: { size: 10 } }
                        },
                        x: { 
                            grid: { display: false },
                            ticks: { font: { size: 10 } }
                        }
                    }
                }
            });
        });
    </script>
</x-buyer-layout>
