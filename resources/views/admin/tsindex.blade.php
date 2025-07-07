<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      📦 {{ __('Transaksi') }}
    </h2>
  </x-slot>

  <div class="bg-gray-100 py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-white p-6 rounded-lg shadow-md">
        <!-- Import & Tambah -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
          <form action="{{ route('transaksi.import') }}" method="POST" enctype="multipart/form-data"
            class="flex items-center gap-3">
            @csrf
            <input type="file" name="file" id="file"
              class="w-64 text-sm border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300" required>
            <button type="submit"
              class="bg-green-600 hover:bg-green-500 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
              📁 Import
            </button>
          </form>

          @if (session('success'))
          <div class="text-green-600 text-sm">
            ✅ {{ session('success') }}
          </div>
          @endif

          <a href="{{ route('admin.tscreate') }}"
            class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
            ➕ Tambah Transaksi
          </a>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-700 text-white">
              <tr>
                <th class="py-3 px-4 text-left">No</th>
                <th class="py-3 px-4 text-left">Produk</th>
                <th class="py-3 px-4 text-left">Total Harga</th>
                <th class="py-3 px-4 text-left">
                  <a href="{{ route('transaksi.index', ['order' => $order]) }}" class="hover:underline">
                    📅 Tanggal
                  </a>
                </th>
                <th class="py-3 px-4 text-left">ID</th>
                <th class="py-3 px-4 text-left">Aksi</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
              @foreach ($transaksi as $transaksi)
              <tr class="hover:bg-gray-50">
                <td class="py-3 px-4">{{ $loop->iteration }}</td>
                <td class="py-3 px-4">
                  @if ($transaksi->produk->isEmpty())
                  <span class="text-gray-400 italic">Tidak ada produk</span>
                  @else
                  <ul class="list-disc list-inside text-gray-700">
                    @foreach ($transaksi->produk as $produk)
                    <li>{{ $produk->nama }} ({{ $produk->pivot->jumlah }})</li>
                    @endforeach
                  </ul>
                  @endif
                </td>
                <td class="py-3 px-4 font-semibold text-green-600">
                  Rp{{ number_format($transaksi->produk->sum('pivot.total_harga'), 0, ',', '.') }}
                </td>
                <td class="py-3 px-4 text-gray-600">
                  {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d F Y - H.i') }}

                </td>
                <td class="py-3 px-4 text-gray-600">
                  {{ $transaksi->id }}
                </td>
                <td class="py-3 px-4">
                  <form action="{{ route('admin.tsdestroy', $transaksi->id) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus transaksi ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                      class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-xs font-medium transition">
                      🗑 Hapus
                    </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>