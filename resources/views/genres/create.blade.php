<x-app-layout>
    <x-slot name="header">
        <div class="w-full flex items-center gap-3">
            <a href="{{ route('genres.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 text-sm">
                <i class="fas fa-chevron-left"></i>
            </a>
            <h2 class="font-semibold text-xl text-white">
                Tambah Genre
            </h2>
        </div>
    </x-slot>

    <div class="px-6 py-6 bg-gray-900 shadow-md rounded-lg">
        @if (session('success'))
            <script>
                window.toast("{{ session('success') }}");
            </script>
        @endif

        <form action="{{ route('genres.store') }}" method="POST" class="w-full">
            @csrf
            <div class="mb-4">
                <label class="block text-white font-medium">Nama Genre</label>
                <input type="text" name="name" class="w-full px-4 py-2 rounded-md border border-gray-700 bg-gray-800 text-white focus:ring-2 focus:ring-blue-500" required>
            </div>

            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Simpan
            </button>
        </form>
    </div>
</x-app-layout>
