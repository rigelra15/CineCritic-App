<x-app-layout>
    <x-slot name="header">
        <div class="w-full flex items-center gap-3">
            <a href="{{ route('casts.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 text-sm">
                <i class="fas fa-chevron-left"></i>
            </a>
            <h2 class="font-semibold text-xl text-white">
                Edit Cast • {{ $cast->name }}
            </h2>
        </div>
    </x-slot>

    <div class="px-6 py-6">
        <form action="{{ route('casts.update', $cast->id) }}" method="POST" class="bg-gray-900 shadow-md rounded-lg p-6">
            @csrf @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300">Nama</label>
                <input type="text" name="name" class="w-full px-4 py-2 rounded-md border border-gray-700 bg-gray-800 text-white" value="{{ $cast->name }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300">Umur</label>
                <input type="number" name="age" class="w-full px-4 py-2 rounded-md border border-gray-700 bg-gray-800 text-white" value="{{ $cast->age }}" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300">Bio</label>
                <textarea name="bio" class="w-full px-4 py-2 rounded-md border border-gray-700 bg-gray-800 text-white" required>{{ $cast->bio }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-300">URL Foto</label>
                <input type="text" name="photo" class="w-full px-4 py-2 rounded-md border border-gray-700 bg-gray-800 text-white" value="{{ $cast->photo }}" required>
            </div>

            <div class="flex items-center space-x-4">
                @if($cast->photo)
                    <img src="{{ $cast->photo }}" alt="Foto {{ $cast->name }}" class="w-auto h-24 rounded-lg shadow">
                @endif
            </div>

            <button type="submit" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Update
            </button>
        </form>
    </div>
</x-app-layout>
