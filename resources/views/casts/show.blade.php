<x-app-layout>
    <x-slot name="header">
        <div class="w-full flex items-center gap-3">
            <a href="{{ route('casts.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 text-sm">
                <i class="fas fa-chevron-left"></i>
            </a>
            <h2 class="font-semibold text-xl text-white">
                Cast • {{ $cast->name }}
            </h2>
        </div>
    </x-slot>

    <div class="px-6 py-6">
        <img src="{{ $cast->photo }}" alt="Foto {{ $cast->name }}" class="w-40 h-40 rounded-full shadow-lg mx-auto mb-4 object-cover">
        <h1 class="text-3xl font-semibold text-white mb-2 text-center">{{ $cast->name }}</h1>
        <p class="text-gray-400 text-center mb-4">Umur: {{ $cast->age }} tahun</p>
        
        <div class="bg-gray-900 shadow-md rounded-lg p-6">
            <h3 class="text-gray-400 text-lg font-semibold mb-4">Biografi</h3>
            <p class="text-white leading-relaxed">{{ $cast->bio }}</p>
        </div>

        <div class="bg-gray-900 shadow-md rounded-lg p-6 mt-6">
            <h3 class="text-gray-400 text-lg font-semibold mb-4">Filmografi</h3>

            @if ($cast->films->isEmpty())
                <p class="text-gray-400 text-center">Belum ada film yang menampilkan aktor ini.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($cast->films as $film)
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
