<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">
            Daftar Film
        </h2>
    </x-slot>

    <div class="px-6 py-4">
        @if(session('success'))
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    toast("{{ session('success') }}");
                });
            </script>
        @endif

        <form action="{{ route('films.index') }}" method="GET" class="mb-4 flex items-center gap-3">
            <input type="text" name="search" placeholder="Cari film..." value="{{ request('search') }}"
                   class="w-full px-4 py-2 rounded-md border border-gray-700 bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Cari
            </button>
        </form>

        @if(Auth::check() && Auth::user()->role === 'admin')
            <x-slot name="actions">
                <a href="{{ route('films.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    + Tambah Film
                </a>
            </x-slot>

            <div class="bg-gray-800 shadow-md rounded-lg overflow-hidden border border-gray-700">
                <table class="w-full table-auto">
                    <thead class="bg-gray-700 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left border-b border-gray-700">#</th>
                            <th class="px-6 py-3 text-left border-b border-gray-700">Poster</th>
                            <th class="px-6 py-3 text-left border-b border-gray-700">Judul</th>
                            <th class="px-6 py-3 text-left border-b border-gray-700">Genre</th>
                            <th class="px-6 py-3 text-left border-b border-gray-700">Tahun</th>
                            <th class="px-6 py-3 text-left border-b border-gray-700">Sinopsis</th>
                            <th class="px-6 py-3 text-left border-b border-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @forelse ($films as $film)
                        <tr class="hover:bg-gray-800">
                            <td class="px-6 py-3 text-white">{{ $loop->iteration + $films->firstItem() - 1 }}</td>
                            <td class="px-6 py-3">
                                @if($film->poster)
                                    @if (Str::startsWith($film->poster, 'http'))
                                        <img src="{{ $film->poster }}" class="w-16 h-24 rounded shadow">
                                    @else
                                        <img src="{{ asset('storage/' . $film->poster) }}" class="w-16 h-24 rounded shadow">
                                    @endif
                                @else
                                    <span class="text-gray-500">Tidak ada poster</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-white">{{ $film->title }}</td>
                            <td class="px-6 py-3 text-white">{{ $film->genre->name }}</td>
                            <td class="px-6 py-3 text-white">{{ $film->release_year }}</td>
                            <td class="px-6 py-3 text-white flex-wrap">{{ Str::limit($film->summary, 15, '...') }}</td>
                            <td class="px-6 py-3 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('films.show', $film->id) }}" 
                                        class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                        Detail
                                    </a>
                                    <a href="{{ route('films.edit', $film->id) }}" 
                                        class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                                        Edit
                                    </a>
                                    <form action="{{ route('films.destroy', $film->id) }}" method="POST" 
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus film ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" 
                                            class="px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-700">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-6 text-gray-400">
                                    Tidak ada film yang tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse ($films as $film)
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
                @empty
                    <p class="text-gray-500 text-center col-span-4">Belum ada film yang tersedia.</p>
                @endforelse
            </div>
        @endif

        <div class="mt-6 flex justify-center">
            {{ $films->links('pagination::tailwind') }}
        </div>
    </div>
</x-app-layout>
