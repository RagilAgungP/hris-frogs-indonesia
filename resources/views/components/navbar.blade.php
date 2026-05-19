<nav class="fixed top-0 left-64 w-[calc(100%-16rem)] h-16 flex items-center justify-between px-6 bg-transparent z-50">

    {{-- LOGO --}}
<div class="flex items-center gap-3">
    <img src="{{ asset('images/logo2.png') }}" class="h-10" alt="Logo">
</div>


{{-- FOTO PROFIL --}}
<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="flex items-center focus:outline-none">
        <!-- Bungkus avatar dengan div relative supaya indikator bisa posisi absolute -->
        <div class="relative">
            <img src="{{ $avatar ?? 'https://randomuser.me/api/portraits/men/15.jpg' }}"
                 class="w-10 h-10 rounded-full border shadow-sm" alt="Avatar">

            <!-- Indikator online -->
            <span class="absolute bottom-0 right-0 block w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full"></span>
        </div>
    </button>

    {{-- DROPDOWN --}}
    <div x-show="open" @click.outside="open = false" x-transition
         class="absolute right-0 mt-3 w-52 bg-white shadow-lg rounded-md border py-2 z-50"
         style="display: none;"> {{-- Ini penting supaya dropdown tidak muncul sebelum klik --}}

        {{-- Info user --}}
        <div class="px-4 py-2 border-b">
            <p class="font-semibold text-gray-700 text-sm">{{ $name ?? 'John Doe' }}</p>
            <p class="text-xs text-gray-500">{{ strtoupper($role ?? 'Administrator') }}</p>
        </div>

        {{-- Menu dropdown --}}
        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Settings</a>
        <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Logout</a>
    </div>
</div>


</nav>

{{-- Spacer supaya konten tidak tertutup navbar --}}
<div class="h-16"></div>
