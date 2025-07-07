<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      🍔 {{ __('Produk') }}
    </h2>
  </x-slot>

  <div class="bg-gray-100 py-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
          <h1 class="text-lg font-bold text-gray-800">📋 Tabel Produk</h1>
          <a href="{{ route('admin.pdcreate') }}"
            class="bg-green-600 hover:bg-green-500 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
            + Tambah Produk
          </a>
        </div>

        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-700 text-white">
              <tr>
                <th class="py-3 px-4 text-left">Nama Produk</th>
                <th class="py-3 px-4 text-left">Harga</th>
                <th class="py-3 px-6 text-left">Komposisi</th>
                <th class="py-3 px-4 text-center">Aksi</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
              @foreach ($produks as $produk)
                <tr class="hover:bg-gray-50">
                  <td class="py-3 px-4 text-gray-800 font-medium">
                    {{ $produk->nama }}
                  </td>
                  <td class="py-3 px-4 text-green-700 font-semibold">
                    Rp{{ number_format($produk->harga, 0, ',', '.') }}
                  </td>
                  <td class="py-3 px-6 text-gray-700">
                    <ul class="list-disc list-inside space-y-1">
                      @foreach ($produk->komposisi as $bahanBaku)
                        <li>{{ $bahanBaku->nama }}: {{ $bahanBaku->pivot->jumlah }} {{ $bahanBaku->satuan }}</li>
                      @endforeach
                    </ul>
                  </td>
                  <td class="py-3 px-4 text-center">
                    <div class="flex justify-center gap-2">
                      <a href="{{ route('admin.pdedit', $produk->id) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md text-xs font-semibold shadow transition">
                        ✏️ Edit
                      </a>
                      <form action="{{ route('admin.pddestroy', $produk->id) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                          class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md text-xs font-semibold shadow transition">
                          🗑 Hapus
                        </button>
                      </form>
                    </div>
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
