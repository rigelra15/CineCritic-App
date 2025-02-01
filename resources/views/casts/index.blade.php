<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">
            Daftar Casts
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

        <!-- 🔍 Search Bar -->
        <input type="text" id="searchCast" placeholder="Cari aktor..." 
               class="w-full px-4 py-2 mb-4 rounded-md border border-gray-700 bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">

        @if(Auth::check() && Auth::user()->role === 'admin')
            <!-- Jika Admin, tampilkan dalam bentuk TABEL -->
            <x-slot name="actions">
                <a href="{{ route('casts.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    + Tambah Cast
                </a>
            </x-slot>

            <div class="bg-gray-800 shadow-md rounded-lg overflow-hidden border border-gray-700">
                @if ($casts->isEmpty())
                    <p class="text-gray-400 text-center">Belum ada cast yang terdaftar.</p>
                @else
                    <table class="w-full table-auto">
                        <thead class="bg-gray-700 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left">#</th>
                                <th class="px-6 py-3 text-left">Foto</th>
                                <th class="px-6 py-3 text-left">Nama</th>
                                <th class="px-6 py-3 text-left">Umur</th>
                                <th class="px-6 py-3 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700" id="castTable">
                            @foreach ($casts as $cast)
                            <tr class="castRow">
                                <td class="px-6 py-3 text-white">{{ $loop->iteration + $casts->firstItem() - 1 }}</td>
                                <td class="px-6 py-3">
                                    @if ($cast->photo)
                                        <img src="{{ $cast->photo }}" class="w-16 h-16 rounded-full border border-gray-700 shadow">
                                    @else
                                        <div class="w-16 h-16 rounded-full bg-gray-700 flex items-center justify-center text-gray-400">
                                            ?
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-white castName">{{ $cast->name }}</td>
                                <td class="px-6 py-3 text-white">{{ $cast->age }} tahun</td>
                                <td class="px-6 py-3 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('casts.show', $cast->id) }}" 
                                            class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                            Lihat
                                        </a>
                                        <a href="{{ route('casts.edit', $cast->id) }}" 
                                            class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                                            Edit
                                        </a>
                                        <form action="{{ route('casts.destroy', $cast->id) }}" method="POST" 
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus cast ini?')">
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

                    <!-- Pagination -->
                    <div class="mt-6 flex justify-center">
                        {{ $casts->links('pagination::tailwind') }}
                    </div>
                @endif
            </div>

        @else
            <!-- Jika User atau Guest, tampilkan dalam bentuk GRID -->
            <div id="castList" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach ($casts as $cast)
                    <div class="bg-gray-800 shadow-md rounded-lg overflow-hidden text-center castSection">
                        <a href="{{ route('casts.show', $cast->id) }}">
                            <div class="relative">
                                @if ($cast->photo)
                                    <img src="{{ $cast->photo }}" class="w-full h-40 object-cover">
                                @else
                                    <div class="w-full h-40 bg-gray-700 flex items-center justify-center text-gray-400">
                                        Tidak ada foto
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h4 class="text-white font-semibold castName">{{ $cast->name }}</h4>
                                <p class="text-gray-400 text-sm">{{ $cast->age }} tahun</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Pesan jika tidak ditemukan aktor yang cocok -->
            <p id="noCastFound" class="text-center text-gray-400 mt-6 hidden">Tidak ditemukan aktor yang sesuai.</p>

            <!-- Pagination -->
            <div class="mt-6 flex justify-center">
                {{ $casts->links('pagination::tailwind') }}
            </div>
        @endif
    </div>

    <script>
        document.getElementById("searchCast").addEventListener("input", function() {
            let searchText = this.value.toLowerCase();

            let tableRows = document.querySelectorAll(".castRow");
            let foundTable = false;
            tableRows.forEach(row => {
                let castName = row.querySelector(".castName").textContent.toLowerCase();
                let match = castName.includes(searchText);
                row.style.display = match ? "" : "none";
                if (match) foundTable = true;
            });

            let castSections = document.querySelectorAll(".castSection");
            let foundSection = false;
            castSections.forEach(section => {
                let castName = section.querySelector(".castName").textContent.toLowerCase();
                let match = castName.includes(searchText);
                section.style.display = match ? "block" : "none";
                if (match) foundSection = true;
            });

            document.getElementById("noCastFound").classList.toggle("hidden", foundTable || foundSection);
        });
    </script>
</x-app-layout>
