<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Laporan Penjualan') }}
      </h2>
  </x-slot>
  <div class="bg-gray-100 min-h-screen py-8">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="bg-white shadow-md rounded-lg p-6">
              <h1 class="text-2xl font-bold mb-6 text-center">Laporan Penjualan</h1>

              <!-- Form Filter -->
              <form method="GET" action="{{ route('laporan.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                  <div>
                      <label for="filter" class="block font-semibold text-sm text-gray-700">Filter Berdasarkan</label>
                      <select name="filter" id="filter" class="mt-1 w-full border-gray-300 rounded shadow-sm">
                          <option value="tanggal" {{ $filter == 'tanggal' ? 'selected' : '' }}>Tanggal</option>
                          <option value="bulan" {{ $filter == 'bulan' ? 'selected' : '' }}>Bulan</option>
                      </select>
                  </div>

                  <div>
                      <label for="tanggal" class="block font-semibold text-sm text-gray-700">Tanggal</label>
                      <input type="date" name="tanggal" id="tanggal" value="{{ $tanggal }}"
                             class="mt-1 w-full border-gray-300 rounded shadow-sm">
                  </div>

                  <div>
                      <label for="bulan" class="block font-semibold text-sm text-gray-700">Bulan</label>
                      <input type="month" name="bulan" id="bulan" value="{{ $bulan }}"
                             class="mt-1 w-full border-gray-300 rounded shadow-sm">
                  </div>

                  <div class="flex items-end">
                      <button type="submit"
                              class="w-full bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Tampilkan
                      </button>
                  </div>
              </form>

              <!-- Info Filter -->
              @if($filter == 'tanggal' && $tanggal)
                  <p class="text-gray-700 mb-4">Menampilkan laporan untuk tanggal: <strong>{{ $tanggal }}</strong></p>
              @elseif($filter == 'bulan' && $bulan)
                  <p class="text-gray-700 mb-4">Menampilkan laporan untuk bulan: <strong>{{ \Carbon\Carbon::parse($bulan)->isoFormat('MMMM YYYY') }}</strong></p>
              @endif

              <!-- Tabel Laporan -->
              <div class="overflow-auto">
                  <table class="min-w-full bg-white rounded shadow">
                      <thead class="bg-gray-600 text-white">
                      <tr>
                          <th class="py-3 px-2 text-left">ID Transaksi</th>
                          <th class="py-3 px-2 text-left">Tanggal</th>
                          <th class="py-3 px-2 text-left">Produk</th>
                          <th class="py-3 px-2 text-center">Jumlah</th>
                          <th class="py-3 px-2 text-right">Total Harga</th>
                      </tr>
                      </thead>
                      <tbody>
                      @forelse($transaksi as $trx)
                          <tr class="border-b">
                              <td class="py-2 px-2">{{ $trx->id }}</td>
                              <td class="py-2 px-2">{{ $trx->tanggal_transaksi }}</td>
                              <td class="py-2 px-2">
                                <ul class="list-disc list-inside space-y-1">
                                  @foreach ($trx->transaksiProduk as $produk)
                                     <li>{{ $produk->produk->nama ?? 'Produk Tidak Ditemukan' }} ({{ $produk->jumlah }})</li>
                                  @endforeach
                                </ul>
                              </td>
                              <td class="py-2 px-2 text-center">{{ $trx->transaksiProduk->sum('jumlah') }}</td>
                              <td class="py-2 px-2 text-right">Rp {{ number_format($trx->transaksiProduk->sum('total_harga'), 0, ',', '.') }}</td>
                          </tr>
                      @empty
                          <tr>
                              <td colspan="5" class="py-4 text-center text-gray-500">Tidak ada transaksi yang ditemukan.</td>
                          </tr>
                      @endforelse
                      </tbody>
                  </table>
              </div>

              <!-- Total Pendapatan -->
              <div class="mt-6 p-4 bg-green-100 text-green-800 rounded">
                  <h2 class="text-xl font-semibold">Total Pendapatan: Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
