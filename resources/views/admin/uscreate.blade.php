<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Tambah Pengguna') }}
      </h2>
  </x-slot>

  <div class="container mx-auto px-6 sm:px-10 mt-10 p-6 bg-white shadow-lg rounded-lg max-w-xl">
      <form action="{{ route('admin.usstore') }}" method="POST" class="space-y-4 max-w-md w-full mx-auto">
          @csrf
          <div>
              <label class="block text-sm font-medium text-gray-700">Nama</label>
              <input type="text" name="name" required class="mt-1 w-full p-2 border rounded-md text-sm text-gray-900 focus:ring-2 focus:ring-gray-900 focus:outline-none">
          </div>
          <div>
              <label class="block text-sm font-medium text-gray-700">Email</label>
              <input type="email" name="email" required class="mt-1 w-full p-2 border rounded-md text-sm text-gray-900 focus:ring-2 focus:ring-gray-900 focus:outline-none">
          </div>
          <div>
              <label class="block text-sm font-medium text-gray-700">Password</label>
              <input type="password" name="password" required class="mt-1 w-full p-2 border rounded-md text-sm text-gray-900 focus:ring-2 focus:ring-gray-900 focus:outline-none">
          </div>
          <div>
              <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
              <input type="password" name="password_confirmation" required class="mt-1 w-full p-2 border rounded-md text-sm text-gray-900 focus:ring-2 focus:ring-gray-900 focus:outline-none">
          </div>
          <div>
              <label class="block text-sm font-medium text-gray-700">Role</label>
              <select name="role" required class="mt-1 w-full p-2 border rounded-md text-sm text-gray-900 focus:ring-2 focus:ring-gray-900 focus:outline-none">
                  <option value="admin">Admin</option>
                  <option value="owner">Owner</option>
              </select>
          </div>
          <div class="flex gap-4 justify-end pt-4">
              <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-500 transition text-sm">
                  Simpan
              </button>
              <a href="{{ route('admin.usindex') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-700 transition text-sm">
                  Kembali
              </a>
          </div>
      </form>
  </div>
</x-app-layout>
