<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">
            Daftar Genre
        </h2>
    </x-slot>

    <div class="px-6 py-4">
        @if (session('success'))
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    toast("{{ session('success') }}");
                });
            </script>
        @endif

        <form action="{{ route('genres.index') }}" method="GET" class="mb-4 flex items-center gap-3">
            <input type="text" id="searchGenre" placeholder="Cari genre..." 
                   class="w-full px-4 py-2 rounded-md border border-gray-700 bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
        </form>

        @if(Auth::check() && Auth::user()->role === 'admin')
            <x-slot name="actions">
                <a href="{{ route('genres.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    + Tambah Genre
                </a>
            </x-slot>

            <div class="bg-gray-800 shadow-md rounded-lg overflow-hidden border border-gray-700">
                <table class="w-full table-auto">
                    <thead class="bg-gray-700 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left">#</th>
                            <th class="px-6 py-3 text-left">Nama Genre</th>
                            <th class="px-6 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700" id="genreTable">
                        @foreach ($genres as $genre)
                        <tr class="genreRow">
                            <td class="px-6 py-3 text-white">{{ $loop->iteration }}</td>
                            <td class="px-6 py-3 text-white genreName">{{ $genre->name }}</td>
                            <td class="px-6 py-3 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('genres.show', $genre->id) }}" 
                                        class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                        Lihat
                                    </a>
                                    <a href="{{ route('genres.edit', $genre->id) }}" 
                                        class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                                        Edit
                                    </a>
                                    <form action="{{ route('genres.destroy', $genre->id) }}" method="POST" 
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus genre ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" 
                                            class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @else
            <div id="genreList" class="space-y-8">
                @foreach ($genres as $genre)
                    <div class="bg-gray-900 shadow-md rounded-lg p-6 genreSection">
                        <a class="text-white text-xl font-semibold mb-4" href="{{ route('genres.show', $genre->id) }}">
                            {{ $genre->name }}
                        </a>

                        @php
                            $films = $genre->films()->take(4)->get();
                            $totalFilms = $genre->films()->count();
                        @endphp

                        @if ($films->isEmpty())
                            <p class="text-gray-400 text-center">Belum ada film dalam genre ini.</p>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                                @foreach ($films as $film)
                                    <div class="bg-gray-800 rounded-lg shadow-md overflow-hidden">
                                        <a href="{{ route('films.show', $film->id) }}" class="relative block">
                                            @if ($film->poster)
                                                <img src="{{ Str::startsWith($film->poster, 'http') ? $film->poster : asset('storage/' . $film->poster) }}" 
                                                     class="w-full h-56 object-cover">
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

                                @if ($totalFilms > 4)
                                    <div class="bg-gray-800 rounded-lg shadow-md overflow-hidden flex items-center justify-center">
                                        <a href="{{ route('genres.show', $genre->id) }}" class="block w-full h-full text-center p-6 text-gray-400 hover:text-white">
                                            + {{ $totalFilms - 4 }} film lainnya...
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <p id="noGenreFound" class="text-center text-gray-400 mt-6 hidden">Tidak ditemukan genre yang sesuai.</p>
        @endif
    </div>

    <script>
        document.getElementById("searchGenre").addEventListener("input", function() {
            let searchText = this.value.toLowerCase();

            let tableRows = document.querySelectorAll(".genreRow");
            let foundTable = false;
            tableRows.forEach(row => {
                let genreName = row.querySelector(".genreName").textContent.toLowerCase();
                let match = genreName.includes(searchText);
                row.style.display = match ? "" : "none";
                if (match) foundTable = true;
            });

            let genreSections = document.querySelectorAll(".genreSection");
            let foundSection = false;
            genreSections.forEach(section => {
                let genreName = section.querySelector(".genreName").textContent.toLowerCase();
                let match = genreName.includes(searchText);
                section.style.display = match ? "block" : "none";
                if (match) foundSection = true;
            });

            document.getElementById("noGenreFound").classList.toggle("hidden", foundTable || foundSection);
        });
    </script>
</x-app-layout>
