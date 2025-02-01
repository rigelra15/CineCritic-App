<x-app-layout>
    <x-slot name="header">
        <div class="w-full flex items-center gap-3">
            <a href="{{ route('genres.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 text-sm">
                <i class="fas fa-chevron-left"></i>
            </a>
            <h2 class="font-semibold text-xl text-white">
                Genre {{ $genre->name }}
            </h2>
        </div>
    </x-slot>

    <div class="px-6 py-6">
        <h1 class="text-3xl font-semibold text-white mb-4 text-center">{{ $genre->name }}</h1>
        <div class="bg-gray-900 shadow-md rounded-lg p-6">

            @if ($genre->films->isEmpty())
                <p class="text-gray-400 text-center">Belum ada film dalam genre ini.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($genre->films as $film)
                        <div class="bg-gray-800 rounded-lg shadow-md overflow-hidden">
                            <a href="{{ route('films.show', $film->id) }}" class="relative block">
                                @if ($film->poster)
                                    <img src="{{ $film->poster }}" class="w-full h-56 object-cover">
                                @else
                                    <div class="w-full h-56 bg-gray-700 flex items-center justify-center text-gray-400">
                                        Tidak ada poster
                                    </div>
                                @endif
                                <div class="absolute top-2 right-2 flex gap-2">
                                    <p class="text-base bg-blue-600 px-3 py-1 rounded-xl font-bold text-white">
                                        {{ $film->release_year }}
                                    </p>
                                    <p class="text-base bg-yellow-500 px-3 py-1 rounded-xl font-bold text-white flex items-center gap-1">
                                        ★ {{ number_format($film->averageRating(), 2) }}
                                    </p>
                                </div>
                            </a>
                            <div class="p-4">
                                <h4 class="text-white font-semibold">{{ $film->title }}</h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
