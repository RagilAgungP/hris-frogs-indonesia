@extends('layouts.app')

@section('title', 'Form Operational | FROGS Indonesia')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow-lg rounded-lg p-6">

        {{-- Header --}}
        <div class="flex justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-800"></h2>
            <a href="#" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Create SOP</a>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="py-2 px-4 border-b text-center">No</th>
                        <th class="py-2 px-4 border-b">Nama Prosedur</th>
                        <th class="py-2 px-4 border-b">No Dokumen</th>
                        <th class="py-2 px-4 border-b">Revisi KE</th>
                        <th class="py-2 px-4 border-b">Scope ISO</th>
                        <th class="py-2 px-4 border-b">File FORM</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Dummy Row --}}
                    <tr>
                        <td class="py-2 px-4 border-b text-center">1</td>
                        <td class="py-2 px-4 border-b">Prosedur Pengadaan Barang</td>
                        <td class="py-2 px-4 border-b">SOP-OP-001</td>
                        <td class="py-2 px-4 border-b">2</td>
                        <td class="py-2 px-4 border-b">ISO 9001</td>
                        <td class="py-2 px-4 border-b">
                            <a href="#" class="text-blue-500 hover:underline">Download</a>
                        </td>
                        <td class="py-2 px-4 border-b">
                            <div class="relative inline-block text-left">
                                <button onclick="toggleDropdown(this)" class="bg-gray-200 px-3 py-1 rounded hover:bg-gray-300 w-full text-left">
                                    Actions
                                </button>
                                <div class="dropdown hidden absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded shadow-lg z-10">
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Edit</a>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Delete File</a>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>
// Dropdown action
function toggleDropdown(button) {
    const dropdown = button.nextElementSibling;
    dropdown.classList.toggle('hidden');
}

// Klik di luar untuk tutup dropdown
document.addEventListener('click', function(e) {
    document.querySelectorAll('.dropdown').forEach(d => {
        if (!d.previousElementSibling.contains(e.target)) {
            d.classList.add('hidden');
        }
    });
});
</script>
@endsection
