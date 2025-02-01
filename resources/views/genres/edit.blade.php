<x-app-layout>
    <x-slot name="header">
        <div class="w-full flex items-center gap-3">
            <a href="{{ route('genres.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 text-sm">
                <i class="fas fa-chevron-left"></i>
            </a>
            <h2 class="font-semibold text-xl text-white">
                Edit Genre • {{ $genre->name }}
            </h2>
        </div>
    </x-slot>

    <div class="px-6 py-6">
        <div class="bg-gray-900 shadow-md rounded-lg p-6">
            <form action="{{ route('genres.update', $genre->id) }}" method="POST">
                @csrf @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-white">Nama Genre</label>
                    <input type="text" name="name" class="mt-1 block w-full px-4 py-2 rounded-md border border-gray-700 bg-gray-800 text-white" value="{{ $genre->name }}" required>
                </div>

                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Update
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
