<x-app-layout>
    <div class="container mx-auto mt-10">
        <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4">Edit Produk</h2>
            <pre>
              {{ print_r(old('komposisi'), true) }}
          </pre>
          
            <form action="{{ route('admin.pdupdate', $produk->id) }}" method="POST">
                @csrf
                @method('PUT')

                <label class="block text-gray-700">Nama Produk</label>
                <input type="text" name="nama" value="{{ $produk->nama }}" class="w-full p-2 border rounded" required>

                <label class="block text-gray-700 mt-3">Harga</label>
                <input type="number" name="harga" value="{{ $produk->harga }}" class="w-full p-2 border rounded" step="1" required>

                <div class="mb-4 mt-3">
                    <label class="block font-semibold">Komposisi (Bahan Baku & Jumlah)</label>

                    <div id="komposisi-wrapper">
                        @foreach ($produk->komposisi as $index => $komposisi)
                            <div class="flex items-center space-x-2 mb-2">
                                <select name="komposisi[{{ $index }}][bahan_baku_id]"
                                    class="border p-1 rounded w-1/2">
                                    @foreach ($bahanBakus as $bahan)
                                        <option value="{{ $bahan->id }}"
                                            {{ $bahan->id == $komposisi->pivot->bahan_baku_id ? 'selected' : '' }}>
                                            {{ $bahan->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <input type="number" step="0.01" name="komposisi[{{ $index }}][jumlah]"
                                    value="{{ $komposisi->pivot->jumlah }}" class="border p-1 rounded w-1/2" required>
                            </div>
                        @endforeach
                    </div>

                    <!-- Tombol tambah baris baru komposisi -->
                    <button type="button" onclick="tambahKomposisi()"
                        class="mt-2 bg-blue-500 text-white px-3 py-1 rounded">+ Tambah Komposisi</button>
                </div>

                <button type="submit" class="w-full bg-green-500 text-white p-2 rounded mt-4">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    <script>
        let komposisiIndex = {{ count($produk->komposisi) }};

        function tambahKomposisi() {
            const wrapper = document.getElementById('komposisi-wrapper');
            const html = `
              <div class="flex items-center space-x-2 mb-2">
                  <select name="komposisi[${komposisiIndex}][bahan_baku_id]" class="border p-1 rounded w-1/2">
                      @foreach ($bahanBakus as $bahan)
                          <option value="{{ $bahan->id }}">{{ $bahan->nama }}</option>
                      @endforeach
                  </select>
                  <input type="number" step="0.01" name="komposisi[${komposisiIndex}][jumlah]" class="border p-1 rounded w-1/2" required>
              </div>
          `;
            wrapper.insertAdjacentHTML('beforeend', html);
            komposisiIndex++;
        }
    </script>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded mt-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</x-app-layout>
