<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Input Bahan Baku') }}
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
        <form action="{{ route('admin.bbstore') }}" method="POST" class="space-y-4 max-w-md w-full">
        @csrf
        <div>
          <label for="nama" name="nama" class="block text-sm font-medium text-gray-700">Nama Bahan Baku</label>
          <input type="text" name="nama" id="nama_bahan_baku" class="mt-1 w-full border rounded-md p-2 text-gray-900 focus:ring-2 focus:ring-gray-900 focus:outline-none" required>
        </div>
        <div>
            <label for="stok" name="stok" class="block text-sm font-medium text-gray-700">Jumlah</label>
            <input type="number" name="stok" id="jumlah" class="mt-1 w-full border rounded-md p-2 text-gray-900 focus:ring-2 focus:ring-gray-900 focus:outline-none" required>
        </div>
        <div>
            <label for="satuan" name="satuan" class="block text-sm font-medium text-gray-700">Satuan</label>
            <input type="text" name="satuan" id="satuan" class="mt-1 w-full border rounded-md p-2 text-gray-900 focus:ring-2 focus:ring-gray-900 focus:outline-none" required>
        </div>
          <button type="submit" class="w-6 h-6 bg-green-600 text-white font-bold rounded-full flex items-center justify-center hover:bg-green-500 transition mt-4">
              <span class="font-bold text-xl">+</span>
          </button>
        </form>
      </div>
    </div>
  </body>
</x-app-layout>
