@extends('layouts.app')

@section('title', 'Employee | PT Inovasi Solusi Transportasi Indonesia')

@section('content')
<div class="container mx-auto p-6">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 space-y-4 md:space-y-0">
        {{-- Active / Resign Tabs --}}
        <div class="flex space-x-2">
            <button id="activeTab" onclick="switchTab('active')" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Active</button>
            <button id="resignTab" onclick="switchTab('resign')" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Resign</button>
        </div>

        {{-- Add New Employee --}}
        <button class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Add New Employee</button>
    </div>

    {{-- Search & Filters --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 space-y-4 md:space-y-0">
        <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Search employee..." class="border border-gray-300 rounded px-3 py-2 w-full md:w-1/3">

        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">
            <select id="branchFilter" onchange="filterTable()" class="border border-gray-300 rounded px-3 py-2">
                <option value="">All Branch</option>
                <option value="Jakarta">Jakarta</option>
                <option value="Bandung">Bandung</option>
            </select>
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
        <table id="employeeTable" class="min-w-full bg-white border border-gray-200 rounded">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 border-b text-center">No</th>
                    <th class="py-2 px-4 border-b">Employee Name / ID</th>
                    <th class="py-2 px-4 border-b">Status</th>
                    <th class="py-2 px-4 border-b">Branch</th>
                    <th class="py-2 px-4 border-b">Department</th>
                    <th class="py-2 px-4 border-b">Position</th>
                    <th class="py-2 px-4 border-b">Join Date</th>
                    <th class="py-2 px-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr class="employee-row" data-status="active" data-branch="Jakarta" data-department="IT" data-position="Developer">
                    <td class="py-2 px-4 border-b text-center">1</td>
                    <td class="py-2 px-4 border-b">
                        John Doe <br>
                        <span class="text-gray-500 text-sm">ID: 12345</span>
                    </td>
                    <td class="py-2 px-4 border-b">Active</td>
                    <td class="py-2 px-4 border-b">Jakarta</td>
                    <td class="py-2 px-4 border-b">IT</td>
                    <td class="py-2 px-4 border-b">Developer</td>
                    <td class="py-2 px-4 border-b">01 Jan 2023</td>
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

                <tr class="employee-row" data-status="resign" data-branch="Bandung" data-department="HR" data-position="Manager">
                    <td class="py-2 px-4 border-b text-center">2</td>
                    <td class="py-2 px-4 border-b">
                        Jane Smith <br>
                        <span class="text-gray-500 text-sm">ID: 54321</span>
                    </td>
                    <td class="py-2 px-4 border-b">Resign</td>
                    <td class="py-2 px-4 border-b">Bandung</td>
                    <td class="py-2 px-4 border-b">HR</td>
                    <td class="py-2 px-4 border-b">Manager</td>
                    <td class="py-2 px-4 border-b">15 Feb 2022</td>
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
            </tbody>
        </table>
    </div>
</div>

<script>
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

// Toggle Active / Resign
let currentTab = 'active';
function switchTab(tab) {
    currentTab = tab;
    document.getElementById('activeTab').classList.toggle('bg-blue-500', tab === 'active');
    document.getElementById('activeTab').classList.toggle('text-white', tab === 'active');
    document.getElementById('activeTab').classList.toggle('bg-gray-200', tab !== 'active');
    document.getElementById('activeTab').classList.toggle('text-gray-700', tab !== 'active');

    document.getElementById('resignTab').classList.toggle('bg-blue-500', tab === 'resign');
    document.getElementById('resignTab').classList.toggle('text-white', tab === 'resign');
    document.getElementById('resignTab').classList.toggle('bg-gray-200', tab !== 'resign');
    document.getElementById('resignTab').classList.toggle('text-gray-700', tab !== 'resign');

    filterTable();
}

// Search & Filter
function filterTable() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    const branch = document.getElementById('branchFilter').value.toLowerCase();
    const department = document.getElementById('departmentFilter').value.toLowerCase();
    const position = document.getElementById('positionFilter').value.toLowerCase();

    document.querySelectorAll('.employee-row').forEach(row => {
        const name = row.cells[1].innerText.toLowerCase();
        const rowStatus = row.dataset.status;
        const rowBranch = row.dataset.branch.toLowerCase();
        const rowDepartment = row.dataset.department.toLowerCase();
        const rowPosition = row.dataset.position.toLowerCase();

        if ((name.includes(search)) &&
            (branch === "" || branch === rowBranch) &&
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

// Inisialisasi default
switchTab('active');
</script>
@endsection
