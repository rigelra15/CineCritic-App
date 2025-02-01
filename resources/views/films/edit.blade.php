<x-app-layout>
    <x-slot name="header">
        <div class="w-full flex items-center gap-3">
            <a href="{{ route('films.index') }}" class="px-4 py-2 bg-blue-600 text-white rounded-full hover:bg-blue-700 text-sm">
                <i class="fas fa-chevron-left"></i>
            </a>
            <h2 class="font-semibold text-xl text-white">
                Edit Film • {{ $film->title }}
            </h2>
        </div>
    </x-slot>

    <div class="px-6 py-6 bg-gray-900 shadow-md rounded-lg">

        <form action="{{ route('films.update', $film->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-4 gap-6">
            @csrf @method('PUT')

            <div class="md:col-span-3">
                <div class="mb-3">
                    <label class="form-label block text-white font-medium">Judul Film</label>
                    <input type="text" name="title" id="film_title" class="w-full px-4 py-2 rounded-md border border-gray-700 bg-gray-800 text-white" value="{{ $film->title }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label block text-white font-medium">Genre</label>
                    <select name="genre_id" class="w-full px-4 py-2 rounded-md border border-gray-700 bg-gray-800 text-white" required>
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}" {{ $film->genre_id == $genre->id ? 'selected' : '' }}>{{ $genre->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label block text-white font-medium">Tahun Rilis</label>
                    <input type="text" name="release_year" class="w-full px-4 py-2 rounded-md border border-gray-700 bg-gray-800 text-white" value="{{ $film->release_year }}" required>
                </div>

                <div class="mb-3 relative">
                    <label class="form-label block text-white font-medium">Sinopsis</label>
                    <textarea name="summary" id="film_summary"  class="w-full px-4 py-2 rounded-md border border-gray-700 bg-gray-800 text-white" rows="6" required>{{ $film->summary }}</textarea>
                    
                    <button type="button" id="generate_summary" class="absolute -bottom-7 right-0 px-3 py-1 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700">
                        Generate with AI
                    </button>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-white">Pilih Aktor</label>
                        <div class="flex flex-wrap gap-2" id="selected-cast-container">
                        </div>
                    <button type="button" onclick="openCastModal()" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        + Pilih Aktor
                    </button>
                </div>

                <input type="hidden" name="cast_ids" id="cast_ids">

                <div id="castModal" class="fixed inset-0 items-center justify-center bg-black bg-opacity-50 hidden">
                    <div class="bg-gray-900 p-6 rounded-lg w-1/3 shadow-lg">
                        <h3 class="text-white text-lg font-semibold">Pilih Aktor</h3>

                        <input type="text" id="search-cast" placeholder="Cari aktor..." class="w-full px-4 py-2 rounded-md border border-gray-700 bg-gray-800 text-white mt-2">

                        <div id="cast-list" class="mt-4 max-h-60 overflow-y-auto">
                            @foreach($casts as $cast)
                                <label class="flex items-center justify-between p-2 rounded-md bg-gray-800 cursor-pointer hover:bg-gray-700">
                                    <span class="text-white">{{ $cast->name }} ({{ $cast->age }} tahun)</span>
                                    <input type="checkbox" class="cast-checkbox" value="{{ $cast->id }}" 
                                        {{ $film->casts->contains($cast->id) ? 'checked' : '' }}> 
                                </label>
                            @endforeach
                        </div>

                        <div class="mt-4 flex justify-end space-x-2">
                            <button type="button" onclick="closeCastModal()" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                                Batal
                            </button>
                            <button type="button" onclick="saveSelectedCasts()" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label block text-white font-medium">Metode Poster</label>
                    <div class="flex items-center gap-4">
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="poster_method" id="poster_upload" value="upload" class="form-radio text-blue-500"
                                {{ Str::startsWith($film->poster, 'http') ? '' : 'checked' }}>
                            <span class="text-white">File</span>
                        </label>
                        <label class="flex items-center space-x-2">
                            <input type="radio" name="poster_method" id="poster_url" value="url" class="form-radio text-blue-500"
                                {{ Str::startsWith($film->poster, 'http') ? 'checked' : '' }}>
                            <span class="text-white">Link</span>
                        </label>
                    </div>
                </div>

                <div class="mb-3" id="poster_file_input" style="{{ Str::startsWith($film->poster, 'http') ? 'display: none;' : '' }}">
                    <label class="form-label block text-white font-medium">Upload Poster Baru</label>
                    <input type="file" name="poster_file" class="w-full px-4 py-2 rounded-md border border-gray-700 bg-gray-800 text-white" accept="image/*">
                </div>

                <div class="mb-3" id="poster_url_input" style="{{ Str::startsWith($film->poster, 'http') ? '' : 'display: none;' }}">
                    <label class="form-label block text-white font-medium">URL Poster Baru</label>
                    <input type="url" name="poster_url" class="w-full px-4 py-2 rounded-md border border-gray-700 bg-gray-800 text-white" value="{{ Str::startsWith($film->poster, 'http') ? $film->poster : '' }}">
                </div>

                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                    Update
                </button>
            </div>

            <div class="flex justify-center items-center">
                <div>
                    @if($film->poster)
                        @if (Str::startsWith($film->poster, 'http'))
                            <img src="{{ $film->poster }}" class="rounded-md shadow-lg w-64">
                        @else
                            <img src="{{ asset('storage/' . $film->poster) }}" class="rounded-md shadow-lg w-64">
                        @endif
                    @else
                        <p class="text-gray-400">Tidak ada poster</p>
                    @endif
                </div>
            </div>
        </form>
    </div>

    <script>
        let selectedCasts = [];

        function openCastModal() {
            document.getElementById("castModal").style.display = "flex";
        }

        function closeCastModal() {
            document.getElementById("castModal").style.display = "none";
        }

        function saveSelectedCasts() {
            let selectedCheckboxes = document.querySelectorAll(".cast-checkbox:checked");
            selectedCasts = [];

            selectedCheckboxes.forEach(checkbox => {
                let castId = checkbox.value;
                let castName = checkbox.parentElement.textContent.trim();
                selectedCasts.push({ id: castId, name: castName });
            });

            updateSelectedCasts();
            closeCastModal();
        }

        function updateSelectedCasts() {
            let container = document.getElementById("selected-cast-container");
            container.innerHTML = "";

            selectedCasts.forEach(cast => {
                let badge = document.createElement("div");
                badge.classList = "bg-blue-800 text-white px-3 py-1 rounded-md flex items-center space-x-2";
                badge.innerHTML = `
                    <span>${cast.name}</span>
                    <button onclick="removeCast(${cast.id})" class="text-red-500 text-sm">✕</button>
                `;
                container.appendChild(badge);
            });

            document.getElementById("cast_ids").value = selectedCasts.map(cast => cast.id).join(",");
        }

        function removeCast(castId) {
            selectedCasts = selectedCasts.filter(cast => cast.id != castId);
            document.querySelector(`.cast-checkbox[value="${castId}"]`).checked = false;
            updateSelectedCasts();
        }

        document.getElementById("search-cast").addEventListener("input", function() {
            let searchText = this.value.toLowerCase();
            let labels = document.querySelectorAll("#cast-list label");

            labels.forEach(label => {
                let castName = label.textContent.toLowerCase();
                label.style.display = castName.includes(searchText) ? "flex" : "none";
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            let checkboxes = document.querySelectorAll(".cast-checkbox:checked");
            checkboxes.forEach(checkbox => {
                let castId = checkbox.value;
                let castName = checkbox.parentElement.textContent.trim();
                selectedCasts.push({ id: castId, name: castName });
            });
            updateSelectedCasts();
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const uploadRadio = document.getElementById("poster_upload");
            const urlRadio = document.getElementById("poster_url");
            const fileInput = document.getElementById("poster_file_input");
            const urlInput = document.getElementById("poster_url_input");

            uploadRadio.addEventListener("change", function() {
                fileInput.style.display = "block";
                urlInput.style.display = "none";
            });

            urlRadio.addEventListener("change", function() {
                fileInput.style.display = "none";
                urlInput.style.display = "block";
            });

            const generateButton = document.getElementById("generate_summary");
            const filmTitle = document.getElementById("film_title");
            const filmSummary = document.getElementById("film_summary");

            generateButton.addEventListener("click", async function() {
                const title = filmTitle.value.trim();
                if (!title) {
                    window.toast("Masukkan judul film terlebih dahulu!");
                    return;
                }

                window.toast("Sedang generate sinopsis film...");

                const apiUrl = "https://cinecritic-api.vercel.app/api/generate"; 

                try {
                    generateButton.innerText = "⏳ Generating...";
                    generateButton.disabled = true;

                    const response = await fetch(apiUrl, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ prompt: `Buat sinopsis film berjudul ${title} cukup 400-600 karakter saja.` })
                    });

                    const data = await response.json();

                    if (data.response) {
                        filmSummary.value = data.response;
                        window.toast("Sinopsis berhasil digenerate!");
                    } else {
                        window.toast("Gagal generate sinopsis. Coba lagi nanti.");
                    }
                } catch (error) {
                    window.toast("Terjadi kesalahan saat memanggil API.");
                } finally {
                    generateButton.innerText = "🔄 Generate";
                    generateButton.disabled = false;
                }
            });
        });
    </script>
</x-app-layout>
