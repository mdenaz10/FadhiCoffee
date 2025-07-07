<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pengguna') }}
        </h2>
    </x-slot>

    <body class="bg-gray-100">
        <div class="container mx-auto mt-10">
            <h1 class="font-bold text-center mb-6">Tabel Pengguna</h1>
            <div class="p-8 overflow-hidden rounded-lg shadow-md">
                @if (session('success'))
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-center">
                        {{ session('success') }}
                    </div>
                @endif
                <!-- Tombol Tambah Pengguna -->
                <div class="flex justify-end mb-4">
                  <a href="{{ route('admin.uscreate') }}"
                      class="w-6 h-6 bg-green-600 text-white font-bold rounded-full flex items-center justify-center hover:bg-green-500 transition">
                      <span class="font-bold text-sm">+</span>
                  </a>
              </div>

                <div class="p-8 overflow-hidden rounded-lg shadow-md">
                    @if (session('success'))
                        <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-center">
                            {{   session('success') }}
                        </div>
                    @endif
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-600 text-white">
                            <tr>
                                <th class="py-3 px-4 text-left">Nama</th>
                                <th class="py-3 px-4 text-left">Email</th>
                                <th class="py-3 px-4 text-center">#</th>
                                <th class="py-3 px-4 text-left ">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="border-b hover:bg-gray-100">
                                    <td class="py-3 px-4">{{ $user->name }}</td>
                                    <td class="py-3 px-4">{{ $user->email }}</td>
                                    <td class="py-3 px-4 flex space-x-2 justify-center items-center">
                                        <!-- Form Ganti Password -->
                                        <form action="{{ route('admin.updatePassword', $user->id) }}" method="POST"
                                            class="flex space-x-4"">
                                            @csrf
                                            <input type="password" name="password" placeholder="New Password" required
                                                class="border p-1">
                                            <input type="password" name="password_confirmation"
                                                placeholder="Confirm Password" required class="border p-1 space-x-4">
                                            <button type="submit"
                                                class="bg-gray-200 text-black px-2 py-1 m-4 rounded">Update</button>
                                        </form>
                                    </td>
                                    <td><!-- Tombol Hapus -->
                                        <form action="{{ route('admin.usdestroy', $user->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus user ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="m-6 w-6 h-6 bg-red-500 text-white font-bold rounded-full items-center justify-center hover:bg-red-700 transition ">-</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </body>
</x-app-layout>
