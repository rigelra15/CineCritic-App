<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">
            Review Saya
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

        <input type="text" id="searchReview" placeholder="Cari berdasarkan judul film..." 
               class="w-full px-4 py-2 mb-4 rounded-md border border-gray-700 bg-gray-800 text-white focus:outline-none focus:ring-2 focus:ring-blue-500">

        @if(Auth::check() && Auth::user()->role === 'admin')
            <div class="bg-gray-800 shadow-md rounded-lg overflow-hidden border border-gray-700">
                @if ($reviews->isEmpty())
                    <p class="text-gray-400 text-center">Belum ada review yang dibuat.</p>
                @else
                    <table class="w-full table-auto">
                        <thead class="bg-gray-700 text-white">
                            <tr>
                                <th class="px-6 py-3 text-left">#</th>
                                <th class="px-6 py-3 text-left">Judul Film</th>
                                <th class="px-6 py-3 text-left">Rating</th>
                                <th class="px-6 py-3 text-left">Review</th>
                                <th class="px-6 py-3 text-left">Tanggal</th>
                                <th class="px-6 py-3 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700" id="reviewTable">
                            @foreach ($reviews as $review)
                            <tr class="reviewRow">
                                <td class="px-6 py-3 text-white">{{ $loop->iteration + $reviews->firstItem() - 1 }}</td>
                                <td class="px-6 py-3 text-white reviewTitle">
                                    <a href="{{ route('films.show', $review->film->id) }}" class="text-blue-400 hover:underline">
                                        {{ $review->film->title }}
                                    </a>
                                </td>
                                <td class="px-6 py-3 text-yellow-400">⭐ {{ $review->point }}</td>
                                <td class="px-6 py-3 text-white">{{ Str::limit($review->content, 50, '...') }}</td>
                                <td class="px-6 py-3 text-gray-400">{{ $review->created_at->diffForHumans() }}</td>
                                <td class="px-6 py-3 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('films.show', $review->film->id) }}" 
                                            class="px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                            Lihat Film
                                        </a>
                                        <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" 
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus review ini?')">
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

                    <div class="mt-6 flex justify-center">
                        {{ $reviews->links('pagination::tailwind') }}
                    </div>
                @endif
            </div>

        @else
            <div id="reviewList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($reviews as $review)
                    <div class="bg-gray-800 shadow-md rounded-lg overflow-hidden text-center reviewSection">
                        <a href="{{ route('films.show', $review->film->id) }}">
                            <div class="relative">
                                @if ($review->film->poster)
                                    <img src="{{ Str::startsWith($review->film->poster, 'http') ? $review->film->poster : asset('storage/' . $review->film->poster) }}" 
                                         class="w-full h-40 object-cover">
                                @else
                                    <div class="w-full h-40 bg-gray-700 flex items-center justify-center text-gray-400">
                                        Tidak ada poster
                                    </div>
                                @endif
                                <div class="absolute top-2 right-2 bg-yellow-500 px-3 py-1 rounded-xl font-bold text-white">
                                    ⭐ {{ $review->point }}
                                </div>
                            </div>
                        </a>
                        <div class="p-4">
                            <h4 class="text-white font-semibold reviewTitle">{{ $review->film->title }}</h4>
                            <p class="text-gray-400 text-sm">{{ Str::limit($review->content, 50, '...') }}</p>
                            <p class="text-gray-500 text-xs">{{ $review->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <p id="noReviewFound" class="text-center text-gray-400 mt-6 hidden">Tidak ditemukan review yang sesuai.</p>

            <div class="mt-6 flex justify-center">
                {{ $reviews->links('pagination::tailwind') }}
            </div>
        @endif
    </div>

    <script>
        document.getElementById("searchReview").addEventListener("input", function() {
            let searchText = this.value.toLowerCase();

            let tableRows = document.querySelectorAll(".reviewRow");
            let foundTable = false;
            tableRows.forEach(row => {
                let reviewTitle = row.querySelector(".reviewTitle").textContent.toLowerCase();
                let match = reviewTitle.includes(searchText);
                row.style.display = match ? "" : "none";
                if (match) foundTable = true;
            });

            let reviewSections = document.querySelectorAll(".reviewSection");
            let foundSection = false;
            reviewSections.forEach(section => {
                let reviewTitle = section.querySelector(".reviewTitle").textContent.toLowerCase();
                let match = reviewTitle.includes(searchText);
                section.style.display = match ? "block" : "none";
                if (match) foundSection = true;
            });

            document.getElementById("noReviewFound").classList.toggle("hidden", foundTable || foundSection);
        });
    </script>
</x-app-layout>
