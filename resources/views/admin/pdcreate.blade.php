<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Input Produk') }}
    </h2>
</x-slot>
  <body class="bg-gray-100">

    <div class="container mx-auto px-6 sm:px-10 mt-10 p-6 bg-white shadow-lg rounded-lg max-w-xl">
      @if(session('success'))
      <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-center">
          {{ session('success') }}
      </div>
      @endif
      <div class="flex justify-center overflow-visible">
        <form action="{{ route('admin.pdstore') }}" method="POST" class="space-y-4 max-w-md w-full">
        @csrf
        <div>
          <label for="nama" name="nama" class="block text-sm font-medium text-gray-700">Nama Produk</label>
          <input type="text" name="nama" id="nama" class="mt-1 w-full border rounded-md p-2 text-gray-900 focus:ring-2 focus:ring-gray-900 focus:outline-none" required>
        </div>
        <div>
            <label for="harga" name="harga" class="block text-sm font-medium text-gray-700">Harga</label>
            <input type="number" name="harga" id="jumlah" class="mt-1 w-full border rounded-md p-2 text-gray-900 focus:ring-2 focus:ring-gray-900 focus:outline-none" required>
        </div>
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700">Komposisi</label>
          <div id="komposisi-container">
              <div class="flex items-center mb-2 komposisi-item">
                <select name="komposisi[0][bahan_baku_id]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm komposisi-dropdown" required onchange="addKomposisiDropdown(this)">
                  <option value="">Pilih Bahan Baku</option>
                  @foreach($produks as $bahanBaku)
                    <option value="{{ $bahanBaku->id }}">{{ $bahanBaku->nama }}</option>
                  @endforeach
                </select>
                <input type="number" step="any" name="komposisi[0][jumlah]" class="mt-1 ml-2 w-20 border-gray-300 rounded-md shadow-sm" placeholder="Jumlah" required>
                <button type="button" class="ml-2 bg-red-500 text-white rounded-md px-2" onclick="removeKomposisi(this)">Hapus</button>
            </div>
          </div>
          <button type="submit" class="w-6 h-6 bg-green-600 text-white font-bold rounded-full flex items-center justify-center hover:bg-green-500 transition mt-4">
              <span class="font-bold text-xl">+</span>
          </button>
        </form>
      </div>
    </div>
    <script>
      let komposisiIndex = 1; // Mulai dari index ke-1 karena pertama sudah ada

      function addKomposisiDropdown(element) {
          let container = document.getElementById('komposisi-container');

          // Cek jika dropdown terakhir masih kosong, jangan tambahkan baru
          if (element.value === "") return;

          let newDiv = document.createElement('div');
          newDiv.classList.add('flex', 'items-center', 'mb-2', 'komposisi-item');
          newDiv.innerHTML = `
              <select name="komposisi[${komposisiIndex}][bahan_baku_id]" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm komposisi-dropdown" required onchange="addKomposisiDropdown(this)">
                  <option value="">Pilih Bahan Baku</option>
                  @foreach($produks as $bahanBaku)
                    <option value="{{ $bahanBaku->id }}">{{ $bahanBaku->nama }}</option>
                  @endforeach
              </select>
              <input type="number" step="any" name="komposisi[${komposisiIndex}][jumlah]" class="mt-1 ml-2 w-20 border-gray-300 rounded-md shadow-sm" placeholder="Jumlah" required>
              <button type="button" class="ml-2 bg-red-500 text-white rounded-md px-2" onclick="removeKomposisi(this)">Hapus</button>
          `;

          container.appendChild(newDiv);
          komposisiIndex++; // Tambah index untuk input berikutnya
      }

      function removeKomposisi(button) {
          let container = document.getElementById('komposisi-container');
          let parentDiv = button.parentElement;
          container.removeChild(parentDiv);
      }
    </script>
  </body>
</x-app-layout>
