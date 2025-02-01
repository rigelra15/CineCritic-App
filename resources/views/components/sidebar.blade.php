<div class="bg-gray-900 text-white shadow-lg flex flex-col h-screen">
    <div class="flex items-center space-x-3 p-4 border-b border-gray-700">
        <img src="https://media.istockphoto.com/id/868646936/id/vektor/ikon-penguin-lucu-dalam-gaya-datar.jpg?s=612x612&w=0&k=20&c=p6rfyK4dOW2pDNkFSl1Btp86efWriLCddEHbrxEZ5R4=" 
            alt="User Image" class="w-12 h-12 rounded-full border border-gray-700">
        <div>
            <a href="#" class="block font-semibold text-white hover:text-gray-300">
                {{ Auth::check() ? Auth::user()->name : 'Guest' }}
            </a>
            @if(Auth::check())
                <p class="text-gray-400 text-sm">
                    {{ Auth::user()->role === 'admin' ? 'Administrator' : 'Pengguna' }}
                </p>
            @endif
        </div>
    </div>

    <nav class="flex-1 px-2 mt-2 space-y-2">
        <a href="/films" class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700">
            <i class="fas fa-film w-6"></i>
            <span>Films</span>
        </a>
        <a href="/genres" class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700">
            <i class="fas fa-theater-masks w-6"></i>
            <span>Genres</span>
        </a>
        <a href="/casts" class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700">
            <i class="fas fa-users w-6"></i>
            <span>Casts</span>
        </a>
        <a href="/reviews" class="flex items-center px-4 py-2 rounded-md hover:bg-gray-700">
            <i class="fas fa-star w-6"></i>
            <span>Reviews</span>
        </a>
    </nav>

    <div class="px-4 py-4 border-t border-gray-700">
        @if(Auth::check())
            <a href="{{ route('profile.edit') }}" class="w-full px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800 block text-center">
                <i class="fas fa-user"></i> Profile
            </a>
            <button onclick="openLogoutModal()" class="w-full mt-2 px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        @else
            <a href="{{ route('login') }}" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 block text-center">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
        @endif
    </div>

</div>
<div id="logoutModal" class="fixed inset-0 items-center justify-center bg-black bg-opacity-50" style="display: none;">
    <div class="bg-gray-900 p-6 rounded-lg w-1/3 shadow-lg text-center">
        <h3 class="text-white text-lg font-semibold">Konfirmasi Logout</h3>
        <p class="text-gray-400 mt-2">Apakah Anda yakin ingin keluar?</p>

        <div class="mt-4 flex justify-center space-x-2">
            <button type="button" onclick="closeLogoutModal()" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
                Batal
            </button>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Ya, Logout
                </button>
            </form>
        </div>
    </div>
</div>
<script>
    function openLogoutModal() {
        document.getElementById("logoutModal").style.display = "flex";
    }

    function closeLogoutModal() {
        document.getElementById("logoutModal").style.display = "none";
    }
</script>