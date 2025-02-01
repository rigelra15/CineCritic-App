<x-app-layout>
    <x-slot name="header">
        <div class="w-full flex items-center gap-3">
            <a href="{{ route('films.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 text-sm">
                <i class="fas fa-chevron-left"></i>
            </a>
            <h2 class="font-semibold text-xl text-white">
                Detail Film • {{ $film->title }}
            </h2>
        </div>
    </x-slot>

    <div class="px-6 py-6 bg-gray-900 shadow-md rounded-lg">
        <div class="flex gap-6">
            <div class="flex justify-center items-start w-fit">
                <div class="w-64">
                    @if($film->poster)
                        <img src="{{ Str::startsWith($film->poster, 'http') ? $film->poster : asset('storage/' . $film->poster) }}" 
                             class="rounded-md shadow-lg w-full">
                    @else
                        <p class="text-gray-500 text-center">Tidak ada poster</p>
                    @endif
                </div>
            </div>

            <div class="w-full">
                <div class="mb-4">
                    <h3 class="text-gray-400 text-lg font-semibold">Judul Film</h3>
                    <p class="text-white text-xl font-bold">{{ $film->title }}</p>
                </div>

                <div class="mb-4">
                    <h3 class="text-gray-400 text-lg font-semibold">Genre</h3>
                    <a href="{{ route('genres.show', $film->genre->id) }}" 
                       class="text-blue-400 hover:underline">
                        {{ $film->genre->name }}
                    </a>
                </div>

                <div class="mb-4">
                    <h3 class="text-gray-400 text-lg font-semibold">Tahun</h3>
                    <p class="text-white">{{ $film->release_year }}</p>
                </div>

                <div class="mb-4">
                    <h3 class="text-gray-400 text-lg font-semibold">Sinopsis</h3>
                    <p class="text-white leading-relaxed">{{ $film->summary }}</p>
                </div>

                @if(Auth::check() && Auth::user()->role === 'admin')
                    <x-slot name="actions">
                        <a href="{{ route('films.edit', $film->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600">
                            <i class="fas fa-edit"></i> Edit Film
                        </a>
                    </x-slot>
                @endif
            </div>
        </div>

        <hr class="my-6 border border-gray-700">

        <div class="mt-8">
            <h3 class="text-gray-400 text-lg font-semibold">Pemeran</h3>

            @if($film->casts->isEmpty())
                <p class="text-gray-500 mt-2">Belum ada pemeran yang terdaftar.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-4">
                    @foreach ($film->casts as $cast)
                        <div class="bg-gray-800 rounded-lg shadow-md p-4 flex items-center gap-4">
                            @if($cast->photo)
                                <img src="{{ $cast->photo }}" class="w-16 h-16 object-cover rounded-full shadow">
                            @else
                                <div class="w-16 h-16 bg-gray-700 flex items-center justify-center text-gray-400 rounded-full">
                                    ?
                                </div>
                            @endif
                            <div>
                                <a href="{{ route('casts.show', $cast->id) }}" class="text-white font-semibold hover:underline">
                                    {{ $cast->name }}
                                </a>
                                <p class="text-gray-400 text-sm">{{ $cast->age }} tahun</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <hr class="my-6 border border-gray-700">

        <div class="mt-8">
            @php
                $userHasReviewed = $film->reviews->where('user_id', auth()->id())->count() > 0;
            @endphp

            <div class="flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <h3 class="text-gray-400 text-lg font-semibold">Review Film</h3>
                    <p class="text-black text-lg font-bold bg-yellow-400 text-center px-3 py-0.5 rounded-xl">
                        <span class="mr-1">★</span>{{ $film->averageRating() }} / 5
                    </p>
                    <p class="text-gray-400 text-lg">({{ $film->reviews->count() }} Review)</p>
                    
                </div>
                @if (!$userHasReviewed)
                    <button onclick="openModal()" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        + Tambah Review
                    </button>
                @else
                    <button disabled class="px-4 py-2 bg-gray-600 text-white rounded-md cursor-not-allowed">
                        <i class="fas fa-check-circle"></i>
                        Anda sudah memberikan review
                    </button>
                @endif
            </div>


            <div class="mt-6">
                @php
                    $latestReviews = $film->reviews()->latest()->take(3)->get();
                @endphp

                @forelse($latestReviews as $review)
                    <div class="bg-gray-800 p-4 rounded-md mb-4 border border-gray-700 flex justify-between">
                        <div>
                            <p class="text-white text-lg">{{ $review->content }}</p>
                            <p class="text-gray-500 text-sm mt-1">{{ $review->user->name }} • {{ $review->created_at->diffForHumans() }}</p>
                        </div>
                        <p class="text-yellow-400 text-lg">⭐{{ $review->point }}</p>
                    </div>
                @empty
                    <p class="text-gray-500">Belum ada review untuk film ini.</p>
                @endforelse
            </div>

            @if($film->reviews()->count() > 3)
                <div class="text-center mt-4">
                    <a href="{{ route('reviews.index', $film->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        🔍 Lihat Review Lainnya
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div id="reviewModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
        <div class="bg-gray-900 p-6 rounded-lg w-1/3 shadow-lg">
            <h3 class="text-white text-lg font-semibold">Tambah Review</h3>
            <form action="{{ route('reviews.store', $film->id) }}" method="POST" class="mt-4">
                @csrf
                <textarea name="review" rows="3" class="w-full px-4 py-2 rounded-md border border-gray-700 bg-gray-800 text-white" placeholder="Tulis ulasan Anda..." required></textarea>

                <div class="mt-3">
                    <label class="block text-white font-medium">Rating</label>
                    <div id="starRating" class="flex space-x-1 mt-2 cursor-pointer">
                        @for ($i = 1; $i <= 5; $i++)
                            <div class="relative cursor-pointer">
                                <span class="absolute left-0 text-gray-600 text-5xl star-full" data-value="{{ $i }}">★</span>
                                <span class="absolute left-0 text-gray-600 text-5xl star-half" data-value="{{ $i - 0.5 }}" style="width: 50%; overflow: hidden;">★</span>
                                <span class="text-gray-400 text-5xl">☆</span>
                            </div>
                        @endfor
                        </div>
                    <input type="hidden" name="point" id="ratingInput" required>
                </div>

                <div class="mt-4 flex justify-end space-x-2">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Kirim Review
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById("reviewModal").style.display = "flex";
        }

        function closeModal() {
            document.getElementById("reviewModal").style.display = "none";
        }

        document.addEventListener("DOMContentLoaded", function () {
            const stars = document.querySelectorAll("#starRating .star-full, #starRating .star-half");
            const ratingInput = document.getElementById("ratingInput");

            stars.forEach(star => {
                star.addEventListener("mouseover", function () {
                    let value = parseFloat(this.getAttribute("data-value"));
                    stars.forEach(s => {
                        let sValue = parseFloat(s.getAttribute("data-value"));
                        s.style.color = sValue <= value ? "gold" : "gray";
                    });
                });

                star.addEventListener("click", function () {
                    let value = parseFloat(this.getAttribute("data-value"));
                    ratingInput.value = value;
                    stars.forEach(s => {
                        let sValue = parseFloat(s.getAttribute("data-value"));
                        s.style.color = sValue <= value ? "gold" : "gray";
                    });
                });
            });
        });
    </script>

</x-app-layout>
