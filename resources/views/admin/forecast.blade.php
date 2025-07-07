<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📊 {{ __('Hasil Peramalan Penjualan') }}
            </h2>
            <span class="text-sm bg-blue-100 text-blue-800 py-1 px-3 rounded-full">
                Moving Average (7 Hari)
            </span>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Produk -->
            <div class="mb-6 bg-white p-4 rounded-lg shadow">
                <label for="produk-filter" class="block text-sm font-medium text-gray-700 mb-2">Filter Produk:</label>
                <select id="produk-filter"
                    class="w-full md:w-64 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Semua Produk</option>
                    @foreach ($produks as $produk)
                        <option value="produk-{{ $produk->id }}">{{ $produk->nama }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Daftar Hasil Forecast -->
            <div class="space-y-8">
                @foreach ($produks as $produk)
                    @if (isset($forecastData[$produk->id]))
                        <div id="produk-{{ $produk->id }}"
                            class="produk-card bg-white overflow-hidden shadow-sm sm:rounded-lg transition-all duration-300 hover:shadow-md">
                            <!-- Header Produk -->
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                                        <span class="bg-blue-600 text-white p-2 rounded-lg mr-3">
                                            {{ substr($produk->nama, 0, 2) }}
                                        </span>
                                        {{ $produk->nama }}
                                    </h3>
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                        {{ array_sum($forecastData[$produk->id]['forecast']) }} unit diprediksi
                                    </span>
                                </div>
                            </div>

                            <div class="p-6 grid md:grid-cols-2 gap-8">
                                <!-- Data Historis -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex justify-between items-center mb-4">
                                        <h4 class="font-semibold text-lg text-gray-700">
                                            <i class="fas fa-chart-line text-blue-500 mr-2"></i>
                                            Trend 7 Hari Terakhir
                                        </h4>
                                        <span class="text-xs bg-gray-200 text-gray-700 px-2 py-1 rounded">
                                            Moving Average
                                        </span>
                                    </div>

                                    <div class="space-y-3">
                                        @foreach ($forecastData[$produk->id]['last_7_days'] as $date => $ma)
                                            <div
                                                class="flex items-center justify-between py-2 px-3 bg-white rounded border-l-4 border-blue-500 hover:bg-blue-50 transition">
                                                <span class="text-sm font-medium text-gray-600">
                                                    {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
                                                </span>
                                                <span
                                                    class="font-bold {{ $ma > 5 ? 'text-green-600' : 'text-yellow-600' }}">
                                                    {{ $ma }} -> {{ round($ma) }} unit
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Prediksi -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <div class="flex justify-between items-center mb-4">
                                        <h4 class="font-semibold text-lg text-gray-700">
                                            <i class="fas fa-magic text-purple-500 mr-2"></i>
                                            Prediksi 7 Hari Mendatang
                                        </h4>
                                        <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded">
                                            Forecasting
                                        </span>
                                    </div>

                                    <div class="space-y-3">
                                        @foreach ($forecastData[$produk->id]['forecast'] as $date => $prediction)
                                            <div
                                                class="flex items-center justify-between py-2 px-3 bg-white rounded border-l-4 border-purple-500 hover:bg-purple-50 transition">
                                                <span class="text-sm font-medium text-gray-600">
                                                    {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
                                                </span>
                                                <span
                                                    class="font-bold {{ $prediction > 5 ? 'text-green-600' : 'text-yellow-600' }}">
                                                    {{ $prediction }} -> {{ round($prediction) }} unit
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Summary -->
                            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                                <div class="grid grid-cols-3 gap-4 text-center">
                                    <div class="p-2">
                                        <p class="text-sm text-gray-500">Rata-rata 7 Hari</p>
                                        <p class="font-bold text-blue-600">
                                            {{ round(array_sum($forecastData[$produk->id]['last_7_days']) / 7, 2) }} ->
                                            {{ round(array_sum($forecastData[$produk->id]['last_7_days']) / 7) }}
                                            unit
                                        </p>
                                    </div>
                                    <div class="p-2">
                                        <p class="text-sm text-gray-500">Total Prediksi</p>
                                        <p class="font-bold text-purple-600">
                                            {{ array_sum($forecastData[$produk->id]['forecast']) }} ->
                                            {{ round(array_sum($forecastData[$produk->id]['forecast'])) }} unit
                                        </p>
                                    </div>
                                    <div class="p-2">
                                        <p class="text-sm text-gray-500">Kebutuhan Bahan Baku</p>
                                        <ul
                                            class="text-sm font-bold text-green-600 list-disc list-inside space-y-1 text-left flex flex-col items-start mx-auto">
                                            @foreach (explode(',', $forecastData[$produk->id]['material_needs']) as $item)
                                                @php
                                                    $formattedItem = preg_replace(
                                                        '/([0-9])([a-zA-Z])/',
                                                        '$1 $2',
                                                        trim($item),
                                                    );
                                                @endphp
                                                <li>{{ $formattedItem }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .produk-card {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .produk-card:hover {
                transform: translateY(-2px);
            }

            [x-cloak] {
                display: none !important;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Filter produk
            document.getElementById('produk-filter').addEventListener('change', function() {
                const value = this.value;
                document.querySelectorAll('.produk-card').forEach(card => {
                    if (value === '' || card.id === value) {
                        card.classList.remove('hidden');
                    } else {
                        card.classList.add('hidden');
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
