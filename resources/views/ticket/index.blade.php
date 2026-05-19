@extends('layouts.app')

@section('title', 'Ticket | FROGS Indonesia')

@section('content')
<div class="container mx-auto p-6">

    {{-- Card --}}
    <div class="bg-white shadow-lg rounded-lg p-6">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 space-y-4 md:space-y-0">
            <h2 class="text-2xl font-semibold text-gray-800">REQUEST TICKET</h2>

            {{-- Create Ticket --}}
            <a href="{{ route('ticket.create') }}"
               class="px-4 py-2 bg-[#3db5ff] text-white rounded hover:bg-[#33a0e0] font-semibold">
                Create Ticket
            </a>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded">
                <thead class="bg-[#3db5ff] text-white">
                    <tr>
                        <th class="py-2 px-4 border-b text-center">No</th>
                        <th class="py-2 px-4 border-b">Nama</th>
                        <th class="py-2 px-4 border-b">Asal Divisi</th>
                        <th class="py-2 px-4 border-b">Jenis Ticket</th>
                        <th class="py-2 px-4 border-b">No Ticket</th>
                        <th class="py-2 px-4 border-b">Deskripsi</th>
                        <th class="py-2 px-4 border-b">Status</th>
                        <th class="py-2 px-4 border-b">Tanggal Request</th>
                        <th class="py-2 px-4 border-b text-center">Action</th>
                    </tr>
                </thead>
                <tbody>

                    {{-- Dummy Data --}}
                    <tr>
                        <td class="py-2 px-4 border-b text-center">1</td>
                        <td class="py-2 px-4 border-b">Andi Pratama</td>
                        <td class="py-2 px-4 border-b">Technology</td>
                        <td class="py-2 px-4 border-b">IT Support</td>
                        <td class="py-2 px-4 border-b">TCK-2025-001</td>
                        <td class="py-2 px-4 border-b">Laptop tidak bisa menyala</td>
                        <td class="py-2 px-4 border-b">
                            <span class="px-2 py-1 rounded text-sm bg-yellow-100 text-yellow-700">
                                Pending
                            </span>
                        </td>
                        <td class="py-2 px-4 border-b">10 Dec 2025</td>
                        <td class="py-2 px-4 border-b text-center">
                            <div class="relative inline-block text-left">
                                <button onclick="toggleDropdown(this)"
                                    class="bg-gray-200 px-3 py-1 rounded hover:bg-gray-300">
                                    Action
                                </button>
                                <div class="dropdown hidden absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded shadow-lg z-10">
                                    <a href="#"
                                       class="block px-4 py-2 hover:bg-gray-100 text-green-600">
                                        Diproses
                                    </a>
                                    <a href="#"
                                       class="block px-4 py-2 hover:bg-gray-100 text-red-600">
                                        Ditolak
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td class="py-2 px-4 border-b text-center">2</td>
                        <td class="py-2 px-4 border-b">Siti Rahma</td>
                        <td class="py-2 px-4 border-b">HRGA</td>
                        <td class="py-2 px-4 border-b">Akses Sistem</td>
                        <td class="py-2 px-4 border-b">TCK-2025-002</td>
                        <td class="py-2 px-4 border-b">Permintaan akses email</td>
                        <td class="py-2 px-4 border-b">
                            <span class="px-2 py-1 rounded text-sm bg-green-100 text-green-700">
                                Diproses
                            </span>
                        </td>
                        <td class="py-2 px-4 border-b">09 Dec 2025</td>
                        <td class="py-2 px-4 border-b text-center">
                            <div class="relative inline-block text-left">
                                <button onclick="toggleDropdown(this)"
                                    class="bg-gray-200 px-3 py-1 rounded hover:bg-gray-300">
                                    Action
                                </button>
                                <div class="dropdown hidden absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded shadow-lg z-10">
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 text-green-600">
                                        Diproses
                                    </a>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 text-red-600">
                                        Ditolak
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- Script Dropdown --}}
<script>
function toggleDropdown(button) {
    const dropdown = button.nextElementSibling;
    dropdown.classList.toggle('hidden');
}

// klik di luar dropdown
document.addEventListener('click', function(e) {
    document.querySelectorAll('.dropdown').forEach(d => {
        if (!d.previousElementSibling.contains(e.target)) {
            d.classList.add('hidden');
        }
    });
});
</script>
@endsection
