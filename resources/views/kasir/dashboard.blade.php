<x-app-layout>
  <x-slot name="header">
      <div class="flex justify-between items-center">
          <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
              {{ __('Dashboard Overview') }}
          </h2>
          <span class="text-sm bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full">
              {{ now()->format('l, F j, Y') }}
          </span>
      </div>
  </x-slot>

  <div class="py-8 px-4 sm:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto">
          <!-- Welcome Card -->
          <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl shadow-xl p-6 mb-8 text-white">
              <div class="flex flex-col md:flex-row justify-between items-center">
                  <div>
                      <h3 class="text-xl font-bold mb-2">Selamat Datang Kembali!</h3>
                      <p class="opacity-90">Ringkasan performa bisnis Anda hari ini</p>
                  </div>
                  <div class="mt-4 md:mt-0">
                      {{-- <div class="flex items-center bg-white bg-opacity-20 px-4 py-2 rounded-lg">
                          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                          </svg>
                          <span class="font-medium">Performance</span>
                      </div> --}}
                  </div>
              </div>
          </div>

          <!-- Stats Cards -->
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
              <!-- Total Transactions -->
              <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-blue-500">
                  <div class="flex items-start justify-between">
                      <div>
                          <div class="flex items-center mb-3">
                              <div class="p-2 bg-blue-100 rounded-lg mr-3">
                                  <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                  </svg>
                              </div>
                              <h3 class="text-lg font-medium text-gray-500">Total Transaksi</h3>
                          </div>
                          <p class="text-3xl font-bold text-gray-900 mb-2">{{ $totalTransaksi }}</p>
                          <p class="text-sm text-gray-500 flex items-center">
                              <span class="text-green-500 flex items-center">
                                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                  </svg>
                                  12% dari bulan lalu
                              </span>
                          </p>
                      </div>
                  </div>
              </div>

              <!-- Today's Transactions -->
              <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-green-500">
                  <div class="flex items-start justify-between">
                      <div>
                          <div class="flex items-center mb-3">
                              <div class="p-2 bg-green-100 rounded-lg mr-3">
                                  <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                  </svg>
                              </div>
                              <h3 class="text-lg font-medium text-gray-500">Transaksi Hari Ini</h3>
                          </div>
                          <p class="text-3xl font-bold text-gray-900 mb-2">{{ $transaksiHariIni }}</p>
                          <p class="text-sm text-gray-500 flex items-center">
                              <span class="text-green-500 flex items-center">
                                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                  </svg>
                                  5% dari kemarin
                              </span>
                          </p>
                      </div>
                  </div>
              </div>

              <!-- Products Sold -->
              <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border-l-4 border-red-500">
                  <div class="flex items-start justify-between">
                      <div>
                          <div class="flex items-center mb-3">
                              <div class="p-2 bg-red-100 rounded-lg mr-3">
                                  <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                  </svg>
                              </div>
                              <h3 class="text-lg font-medium text-gray-500">Total Produk Terjual</h3>
                          </div>
                          <p class="text-3xl font-bold text-gray-900 mb-2">{{ $produkTerjual }}</p>
                          <p class="text-sm text-gray-500 flex items-center">
                              <span class="text-green-500 flex items-center">
                                  <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                  </svg>
                                  8% dari minggu lalu
                              </span>
                          </p>
                      </div>
                  </div>
              </div>
          </div>

          <!-- Additional Charts Section -->
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
              <!-- Sales Chart -->
              <div class="bg-white p-6 rounded-xl shadow-lg">
                  <div class="flex justify-between items-center mb-4">
                      <h3 class="text-lg font-medium text-gray-900">Grafik Penjualan 7 Hari Terakhir</h3>
                      <button class="text-sm text-indigo-600 hover:text-indigo-800">Lihat Detail</button>
                  </div>
                  <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center">
                      <!-- Placeholder for chart -->
                      <div class="text-center">
                          <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                          </svg>
                          <p class="mt-2 text-gray-500">Data grafik akan ditampilkan di sini</p>
                      </div>
                  </div>
              </div>

              <!-- Top Products -->
              <div class="bg-white p-6 rounded-xl shadow-lg">
                  <div class="flex justify-between items-center mb-4">
                      <h3 class="text-lg font-medium text-gray-900">Produk Terlaris</h3>
                      <button class="text-sm text-indigo-600 hover:text-indigo-800">Lihat Semua</button>
                  </div>
                  <div class="space-y-4">
                      <div class="flex items-center">
                          <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                              <span class="text-blue-800 font-medium">1</span>
                          </div>
                          <div class="ml-4 flex-1">
                              <div class="flex justify-between">
                                  <p class="text-sm font-medium text-gray-900">Roti Tawar</p>
                                  <p class="text-sm font-medium text-gray-900">152 terjual</p>
                              </div>
                              <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                  <div class="bg-blue-600 h-1.5 rounded-full" style="width: 75%"></div>
                              </div>
                          </div>
                      </div>
                      <div class="flex items-center">
                          <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                              <span class="text-green-800 font-medium">2</span>
                          </div>
                          <div class="ml-4 flex-1">
                              <div class="flex justify-between">
                                  <p class="text-sm font-medium text-gray-900">Donat Coklat</p>
                                  <p class="text-sm font-medium text-gray-900">98 terjual</p>
                              </div>
                              <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                  <div class="bg-green-600 h-1.5 rounded-full" style="width: 60%"></div>
                              </div>
                          </div>
                      </div>
                      <div class="flex items-center">
                          <div class="flex-shrink-0 w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                              <span class="text-yellow-800 font-medium">3</span>
                          </div>
                          <div class="ml-4 flex-1">
                              <div class="flex justify-between">
                                  <p class="text-sm font-medium text-gray-900">Pisang Coklat</p>
                                  <p class="text-sm font-medium text-gray-900">76 terjual</p>
                              </div>
                              <div class="w-full bg-gray-200 rounded-full h-1.5 mt-1">
                                  <div class="bg-yellow-500 h-1.5 rounded-full" style="width: 45%"></div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>