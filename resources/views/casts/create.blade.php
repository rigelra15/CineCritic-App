<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Tambah Cast</h2>
    </x-slot>

    <div class="px-6 py-6">
        <form action="{{ route('casts.store') }}" method="POST" class="bg-gray-900 shadow-md rounded-lg p-6">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300">Nama</label>
                <input type="text" name="name" class="w-full px-4 py-2 rounded-md border border-gray-700 bg-gray-800 text-white" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300">Umur</label>
                <input type="number" name="age" class="w-full px-4 py-2 rounded-md border border-gray-700 bg-gray-800 text-white" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300">Bio</label>
                <textarea name="bio" class="w-full px-4 py-2 rounded-md border border-gray-700 bg-gray-800 text-white" required></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300">URL Foto</label>
                <input type="text" name="photo" class="w-full px-4 py-2 rounded-md border border-gray-700 bg-gray-800 text-white" required>
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Simpan</button>
        </form>
    </div>
</x-app-layout>
