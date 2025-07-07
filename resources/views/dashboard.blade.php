<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Overview') }}
        </h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Welcome Banner -->
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl shadow-lg mb-8 p-6 text-white">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold">Welcome back!</h1>
                        <p class="mt-2 opacity-90">Here's what's happening with your business today.</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <span class="inline-block bg-white bg-opacity-20 px-4 py-2 rounded-full text-sm font-medium">
                            {{ now()->format('l, F j, Y') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Total Transactions -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-500">Total Transaksi</h3>
                                <p class="text-2xl font-semibold text-gray-900">{{ $totalTransaksi }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Products -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <a href="{{ route('admin.pdindex') }}">
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-500">Total Produk</h3>
                                    <p class="text-2xl font-semibold text-gray-900">{{ $totalProduk }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Low Stock -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <a href="{{ route('admin.bbindex') }}">
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-500">Stok Sedikit</h3>
                                    <p class="text-2xl font-semibold text-gray-900">{{ $bahanBakuHampirHabis }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Weekly Transactions -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-500">Transaksi Mingguan</h3>
                                <p class="text-2xl font-semibold text-gray-900">{{ $transaksimingguan }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Forecasting -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                            <a href="{{ route('admin.forecast') }}">
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-500">Peramalan</h3>
                                    <p class="text-2xl font-semibold text-gray-900">{{ $peramalan }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Total Stock -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-100 text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-500">Total Stok</h3>
                                <p class="text-2xl font-semibold text-gray-900">{{ $totalBahanBaku }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Sales Chart -->
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Grafik Penjualan</h3>
                        <div class="relative">
                            <select
                                class="appearance-none bg-gray-100 border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                                <option value="mingguan">Mingguan</option>
                                <option value="bulanan">Bulanan</option>
                                <option value="tahunan">Tahunan</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center">
                      <canvas id="grafikPenjualan" height="100"></canvas>
                    </div>
                </div>

                <!-- Inventory Status -->
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Status Inventaris</h3>
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700">Produk Tersedia</span>
                                <span class="text-sm font-medium text-gray-700">80%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-green-600 h-2.5 rounded-full" style="width: 80%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700">Stok Rendah</span>
                                <span class="text-sm font-medium text-gray-700">15%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-yellow-500 h-2.5 rounded-full" style="width: 15%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between mb-1">
                                <span class="text-sm font-medium text-gray-700">Stok Habis</span>
                                <span class="text-sm font-medium text-gray-700">5%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-red-600 h-2.5 rounded-full" style="width: 5%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const dataPenjualan = @json($dataBulan);

    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById("grafikPenjualan").getContext("2d");

        const data = {
            labels: Object.keys(dataPenjualan),
            datasets: [{
                label: "Total Penjualan (Rp)",
                data: Object.values(dataPenjualan),
                backgroundColor: "rgba(75, 192, 192, 0.4)",
                borderColor: "rgba(75, 192, 192, 1)",
                borderWidth: 2,
                tension: 0.4,
                fill: true
            }]
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        new Chart(ctx, config);
    });
</script>
</x-app-layout>
