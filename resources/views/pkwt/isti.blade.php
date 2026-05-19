@extends('layouts.app')

@section('title', 'PKWT Employees | PT Inovasi Solusi Transportasi Indonesia')

@section('content')
<div class="container mx-auto p-6">

    {{-- Card --}}
    <div class="bg-white shadow-lg rounded-lg p-6">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 space-y-4 md:space-y-0">

            {{-- Tabs Active / Resign --}}
            <div class="flex space-x-2 border-b border-gray-200">
                <button id="activeTab" onclick="switchTab('active')" class="px-4 py-2 font-semibold transition border-b-4 -mb-1">Active</button>
                <button id="resignTab" onclick="switchTab('resign')" class="px-4 py-2 font-semibold transition border-b-4 -mb-1">Resign</button>
            </div>

            {{-- Add PKWT Employee --}}
            <a href="{{ route('employee.create') }}" 
               class="px-4 py-2 bg-[#3db5ff] text-white rounded hover:bg-[#33a0e0] font-semibold">
               Add New PKWT Employee
            </a>

        </div>

        {{-- Search & Filters --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 space-y-4 md:space-y-0">
            <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search employee..." class="border border-gray-300 rounded px-3 py-2 w-full md:w-1/3">

            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
                <select id="departmentFilter" onchange="filterTable()" class="border border-gray-300 rounded px-3 py-2">
                    <option value="">All Department</option>
                    <option value="IT">IT</option>
                    <option value="HR">HR</option>
                </select>
                <select id="positionFilter" onchange="filterTable()" class="border border-gray-300 rounded px-3 py-2">
                    <option value="">All Position</option>
                    <option value="Developer">Developer</option>
                    <option value="Manager">Manager</option>
                </select>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table id="employeeTable" class="min-w-full border border-gray-200 rounded">
                <thead class="bg-[#3db5ff] text-white">
                    <tr>
                        <th class="py-2 px-4 border-b text-center">No PKWT</th>
                        <th class="py-2 px-4 border-b">Employee Name</th>
                        <th class="py-2 px-4 border-b">Position</th>
                        <th class="py-2 px-4 border-b">Department</th>
                        <th class="py-2 px-4 border-b">Tanggal Awal</th>
                        <th class="py-2 px-4 border-b">Tanggal Akhir</th>
                        <th class="py-2 px-4 border-b">Waktu (Tahun, Bulan, Hari)</th>
                        <th class="py-2 px-4 border-b">File PKWT</th>
                        <th class="py-2 px-4 border-b">Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Example row --}}
                    <tr class="employee-row" data-status="active" data-department="IT" data-position="Developer">
                        <td class="py-2 px-4 border-b text-center">PKWT001</td>
                        <td class="py-2 px-4 border-b">
                            John Doe <br>
                            <span class="text-gray-500 text-sm">ID: 12345</span>
                        </td>
                        <td class="py-2 px-4 border-b">Developer</td>
                        <td class="py-2 px-4 border-b">IT</td>
                        <td class="py-2 px-4 border-b">01 Jan 2023</td>
                        <td class="py-2 px-4 border-b">31 Dec 2023</td>
                        <td class="py-2 px-4 border-b"></td> {{-- Will be filled by JS --}}
                        <td class="py-2 px-4 border-b">
                            <a href="#" class="text-blue-600 hover:underline">Download</a>
                        </td>
                        <td class="py-2 px-4 border-b">
                            <div class="relative inline-block text-left">
                                <button onclick="toggleDropdown(this)" class="bg-gray-200 px-2 py-1 rounded hover:bg-gray-300">
                                    Actions
                                </button>
                                <div class="dropdown hidden absolute right-0 mt-2 w-28 bg-white border border-gray-200 rounded shadow-lg z-10">
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Edit</a>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>

                    {{-- Add more rows dynamically using @foreach for real data --}}
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

    document.addEventListener('click', function handler(e) {
        if (!button.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
            document.removeEventListener('click', handler);
        }
    });
}

// Active / Resign tab
let currentTab = 'active';
function switchTab(tab) {
    currentTab = tab;

    const activeBtn = document.getElementById('activeTab');
    const resignBtn = document.getElementById('resignTab');

    const activeClass = 'border-b-4 border-[#3db5ff] text-[#3db5ff]';
    const inactiveClass = 'border-b-4 border-transparent text-gray-700';

    if(tab === 'active') {
        activeBtn.className = `px-4 py-2 font-semibold transition ${activeClass}`;
        resignBtn.className = `px-4 py-2 font-semibold transition ${inactiveClass}`;
    } else {
        resignBtn.className = `px-4 py-2 font-semibold transition ${activeClass}`;
        activeBtn.className = `px-4 py-2 font-semibold transition ${inactiveClass}`;
    }

    filterTable();
}

// Search & Filters
function filterTable() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const department = document.getElementById('departmentFilter').value.toLowerCase();
    const position = document.getElementById('positionFilter').value.toLowerCase();

    document.querySelectorAll('.employee-row').forEach(row => {
        const name = row.cells[1].innerText.toLowerCase();
        const rowStatus = row.dataset.status;
        const rowDepartment = row.dataset.department.toLowerCase();
        const rowPosition = row.dataset.position.toLowerCase();

        if ((name.includes(search)) &&
            (department === "" || department === rowDepartment) &&
            (position === "" || position === rowPosition) &&
            (rowStatus === currentTab)
        ) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Initialize default tab
switchTab('active');

// ===== Calculate Waktu (Contract Duration) =====
function calculateDuration(startDate, endDate) {
    const start = new Date(startDate);
    const end = new Date(endDate);

    let years = end.getFullYear() - start.getFullYear();
    let months = end.getMonth() - start.getMonth();
    let days = end.getDate() - start.getDate();

    if (days < 0) {
        months -= 1;
        const previousMonth = new Date(end.getFullYear(), end.getMonth(), 0);
        days += previousMonth.getDate();
    }

    if (months < 0) {
        years -= 1;
        months += 12;
    }

    let result = [];
    if (years > 0) result.push(`${years} Tahun`);
    if (months > 0) result.push(`${months} Bulan`);
    if (days > 0) result.push(`${days} Hari`);

    return result.join(', ') || '0 Hari';
}

// Apply calculation to all table rows
document.querySelectorAll('#employeeTable tbody tr').forEach(row => {
    const start = row.cells[4].innerText.trim(); // Tanggal Awal
    const end = row.cells[5].innerText.trim();   // Tanggal Akhir
    row.cells[6].innerText = calculateDuration(start, end); // Waktu
});
</script>
@endsection
