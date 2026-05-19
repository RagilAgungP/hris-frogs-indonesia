@extends('layouts.app')

@section('title', 'Surat | FROGS Indonesia')

@section('content')
<div class="container mx-auto p-6">

    {{-- Card --}}
    <div class="bg-white shadow-lg rounded-lg p-6">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 space-y-4 md:space-y-0">
            <h2 class="text-2xl font-semibold text-gray-800">SURAT FROGS INDONESIA</h2>

            {{-- Add Surat --}}
            <a href="{{ route('surat.create') }}" 
               class="px-4 py-2 bg-[#3db5ff] text-white rounded hover:bg-[#33a0e0] font-semibold">
               Create New Surat
            </a>
        </div>

        {{-- Search & Filters --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 space-y-4 md:space-y-0">
            <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search surat..." class="border border-gray-300 rounded px-3 py-2 w-full md:w-1/3">

            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                <select id="divisionFilter" onchange="filterTable()" class="border border-gray-300 rounded px-3 py-2">
                    <option value="">All Division</option>
                    <option value="Board of Directors">Board of Directors</option>
                    <option value="Operational">Operational</option>
                    <option value="Technology">Technology</option>
                    <option value="Business Development">Business Development</option>
                    <option value="Finance">Finance</option>
                    <option value="HRGA">HRGA</option>
                    <option value="Legal">Legal</option>
                </select>
                <select id="jenisFilter" onchange="filterTable()" class="border border-gray-300 rounded px-3 py-2">
                    <option value="">All Jenis Surat</option>
                    <option value="Addendum">Addendum</option>
                    <option value="Berita Acara">Berita Acara</option>
                    <option value="Job Order">Job Order</option>
                    <option value="PKK">PKK</option>
                    <option value="Perjanjian Kerja Sama">Perjanjian Kerja Sama</option>
                    <option value="Kwitansi/Penagihan">Kwitansi/Penagihan</option>
                    <option value="Memorandum">Memorandum</option>
                    <option value="Nota Dinas">Nota Dinas</option>
                    <option value="Pemberitahuan">Pemberitahuan</option>
                    <option value="Permohonan">Permohonan</option>
                    <option value="Perjanjian Kerahasiaan">Perjanjian Kerahasiaan</option>
                    <option value="Penawaran">Penawaran</option>
                    <option value="Purchase Order">Purchase Order</option>
                    <option value="Surat Keputusan">Surat Keputusan</option>
                    <option value="Surat Rekomendasi">Surat Rekomendasi</option>
                    <option value="Surat Tugas">Surat Tugas</option>
                    <option value="SOP">SOP</option>
                    <option value="Surat Kuasa">Surat Kuasa</option>
                    <option value="Perjanjian Jual Beli">Perjanjian Jual Beli</option>
                    <option value="Surat Pengajuan">Surat Pengajuan</option>
                    <option value="Surat Keterangan">Surat Keterangan</option>
                    <option value="Delivery Order">Delivery Order</option>
                    <option value="Surat Peringatan">Surat Peringatan</option>
                </select>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table id="suratTable" class="min-w-full border border-gray-200 rounded">
                <thead class="bg-[#3db5ff] text-white">
                    <tr>
                        <th class="py-2 px-4 border-b text-center">ID</th>
                        <th class="py-2 px-4 border-b">Perihal</th>
                        <th class="py-2 px-4 border-b">Kepada</th>
                        <th class="py-2 px-4 border-b">Division</th>
                        <th class="py-2 px-4 border-b">Jenis Surat</th>
                        <th class="py-2 px-4 border-b">No Surat Panjang</th>
                        <th class="py-2 px-4 border-b">Tanggal Surat</th>
                        <th class="py-2 px-4 border-b">Berkas Surat</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Dummy rows --}}
                    <tr class="surat-row" data-division="Operational" data-jenis="Job Order">
                        <td class="py-2 px-4 border-b text-center">001</td>
                        <td class="py-2 px-4 border-b">Project ABC</td>
                        <td class="py-2 px-4 border-b">PT XYZ</td>
                        <td class="py-2 px-4 border-b">Operational</td>
                        <td class="py-2 px-4 border-b">Job Order</td>
                        <td class="py-2 px-4 border-b">FSI-2025-0001</td>
                        <td class="py-2 px-4 border-b">10 Dec 2025</td>
                        <td class="py-2 px-4 border-b">
                            <a href="#" class="text-blue-500 hover:underline">Download</a>
                        </td>
                        <td class="py-2 px-4 border-b">
                            <div class="relative inline-block text-left">
                                <button onclick="toggleDropdown(this)" class="bg-gray-200 px-2 py-1 rounded hover:bg-gray-300">Actions</button>
                                <div class="dropdown hidden absolute right-0 mt-2 w-28 bg-white border border-gray-200 rounded shadow-lg z-10">
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Edit</a>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr class="surat-row" data-division="Legal" data-jenis="Perjanjian Kerja Sama">
                        <td class="py-2 px-4 border-b text-center">002</td>
                        <td class="py-2 px-4 border-b">Kontrak Vendor</td>
                        <td class="py-2 px-4 border-b">PT ABC</td>
                        <td class="py-2 px-4 border-b">Legal</td>
                        <td class="py-2 px-4 border-b">Perjanjian Kerja Sama</td>
                        <td class="py-2 px-4 border-b">FSI-2025-0002</td>
                        <td class="py-2 px-4 border-b">05 Dec 2025</td>
                        <td class="py-2 px-4 border-b">
                            <a href="#" class="text-blue-500 hover:underline">Download</a>
                        </td>
                        <td class="py-2 px-4 border-b">
                            <div class="relative inline-block text-left">
                                <button onclick="toggleDropdown(this)" class="bg-gray-200 px-2 py-1 rounded hover:bg-gray-300">Actions</button>
                                <div class="dropdown hidden absolute right-0 mt-2 w-28 bg-white border border-gray-200 rounded shadow-lg z-10">
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Edit</a>
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

// Klik di luar untuk tutup semua dropdown
document.addEventListener('click', function(e) {
    document.querySelectorAll('.dropdown').forEach(d => {
        if (!d.previousElementSibling.contains(e.target)) {
            d.classList.add('hidden');
        }
    });
});

// Search & Filters
function filterTable() {
    const search = document.getElementById('searchInput').value.toLowerCase().trim();
    const division = document.getElementById('divisionFilter').value.toLowerCase().trim();
    const jenis = document.getElementById('jenisFilter').value.toLowerCase().trim();

    document.querySelectorAll('.surat-row').forEach(row => {
        const perihal = row.cells[1].innerText.toLowerCase();
        const rowDivision = row.dataset.division.toLowerCase();
        const rowJenis = row.dataset.jenis.toLowerCase();

        if ((perihal.includes(search)) &&
            (division === "" || division === rowDivision) &&
            (jenis === "" || jenis === rowJenis)
        ) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
@endsection
