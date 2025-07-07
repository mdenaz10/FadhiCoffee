<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Input Transaksi') }}
    </h2>
</x-slot>
  <body class="bg-gray-100">
      <div class="mx-auto px-6 sm:px-10 mt-10 p-6 bg-white shadow-lg rounded-lg max-w-xl">
          <h2 class="text-2xl font-semibold mb-4">Tambah Transaksi</h2>
          <form action="{{ route('admin.tsstore') }}" method="POST">
              @csrf
              <div id="produk-container" class="space-y-4">
                  <div class="produk-group flex gap-4 items-center">
                      <select name="produk_id[]" class="w-full p-2 border rounded-md">
                          @foreach ($produks as $produk)
                              <option value="{{ $produk->id }}">{{ $produk->nama }} - Rp{{ number_format($produk->harga, 0, ',', '.') }}</option>
                          @endforeach
                      </select>
                      <input type="number" name="jumlah[]" class="w-20 p-2 border rounded-md" min="1" value="1">
                  </div>
              </div>
              <button type="button" id="tambah-produk" class="mt-4 px-4 py-2 bg-gray-600 text-white rounded-md">Tambah Produk</button>
              <button type="submit" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-md">Simpan</button>
          </form>
      </div>

      <!-- Kirim data produk ke JavaScript -->
      <script>
          let produkData = @json($produks);

          document.getElementById('tambah-produk').addEventListener('click', function() {
              let container = document.getElementById('produk-container');
              let newGroup = document.createElement('div');
              newGroup.classList.add('produk-group', 'flex', 'gap-4', 'items-center');

              let select = document.createElement('select');
              select.name = "produk_id[]";
              select.classList.add('w-full', 'p-2', 'border', 'rounded-md');

              // Tambahkan opsi produk ke dropdown
              produkData.forEach(produk => {
                  let option = document.createElement('option');
                  option.value = produk.id;
                  option.textContent = `${produk.nama} - Rp${produk.harga.toLocaleString('id-ID')}`;
                  select.appendChild(option);
              });

              let input = document.createElement('input');
              input.type = "number";
              input.name = "jumlah[]";
              input.classList.add('w-20', 'p-2', 'border', 'rounded-md');
              input.min = 1;
              input.value = 1;

              let removeBtn = document.createElement('button');
              removeBtn.type = "button";
              removeBtn.classList.add('px-2', 'py-1', 'bg-red-500', 'text-white', 'rounded-md', 'remove-produk');
              removeBtn.textContent = "Hapus";

              newGroup.appendChild(select);
              newGroup.appendChild(input);
              newGroup.appendChild(removeBtn);
              container.appendChild(newGroup);
          });

          // Event listener untuk menghapus produk
          document.addEventListener('click', function(event) {
              if (event.target.classList.contains('remove-produk')) {
                  event.target.parentElement.remove();
              }
          });
      </script>
  </body>
</x-app-layout>
