<x-app-layout>

        <div class="container mx-auto mt-10">
            <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-bold mb-4">Edit Bahan Baku</h2>

                <form action="{{ route('admin.bbupdate', $bahanBaku->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <label class="block text-gray-700">Nama Bahan Baku</label>
                    <input type="text" name="nama" value="{{ $bahanBaku->nama }}" class="w-full p-2 border rounded"
                        required>

                    <label class="block text-gray-700 mt-3">Stok</label>
                    <input type="number" name="stok" value="{{ $bahanBaku->stok }}" class="w-full p-2 border rounded" required step="any">


                    <label class="block text-gray-700 mt-3">Satuan</label>
                    <input type="text" name="satuan" value="{{ $bahanBaku->satuan }}" class="w-full p-2 border rounded"
                        required>

                    <button type="submit" class="w-full bg-green-500 text-white p-2 rounded mt-4">Simpan Perubahan</button>
                </form>
            </div>
        </div>

</x-app-layout>
