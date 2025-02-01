<x-app-layout>
    <x-slot name="header">
        <div class="w-full flex items-center gap-3">
            <a href="{{ route('films.show', $film->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 text-sm">
                <i class="fas fa-chevron-left"></i>
            </a>
            <h2 class="font-semibold text-xl text-white">
                Semua Review • {{ $film->title }}
            </h2>
        </div>
    </x-slot>

    <div class="px-6 py-6 bg-gray-900 shadow-md rounded-lg">
        
        <!-- JUMLAH REVIEW DAN AVERAGE RATING -->
        <div class="flex flex-row items-center justify-between text-center mb-6 w-full">
            <h3 class="text-gray-400 text-lg font-semibold">
                Total: 
                <span class="text-white">{{ $reviews->total() }} Review</span>
            </h3>
            <h3 class="text-gray-400 text-lg font-semibold">
                Rating: 
                <span class="text-yellow-400">⭐{{ $film->reviews->avg('point') }}</span>
            </h3>
        </div>

        <div class="mt-6">
            @forelse($reviews as $review)
                <div class="bg-gray-800 p-4 rounded-md mb-4 border border-gray-700 flex justify-between">
                    <div>
                        <p class="text-white text-lg">{{ $review->content }}</p>
                        <p class="text-gray-500 text-sm mt-1">{{ $review->user->name }} • {{ $review->created_at->diffForHumans() }}</p>
                    </div>
                    <p class="text-yellow-400 text-lg">⭐{{ $review->point }}</p>
                </div>
            @empty
                <p class="text-gray-500 text-center">Belum ada review untuk film ini.</p>
            @endforelse
        </div>

        <!-- PAGINATION -->
        <div class="mt-6 flex justify-center">
            {{ $reviews->links('pagination::tailwind') }}
        </div>
    </div>
</x-app-layout>