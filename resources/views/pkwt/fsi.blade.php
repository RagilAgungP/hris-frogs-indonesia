@extends('layouts.app')

@section('title', 'PKWT Employees | PT Inovasi Solusi Transportasi Indonesia')

@section('content')

@php
    use Carbon\Carbon;
@endphp

<div class="container mx-auto p-6">

    <div class="bg-white shadow-lg rounded-lg p-6">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 space-y-4 md:space-y-0">

            {{-- Tabs --}}
            <div class="flex space-x-2 border-b border-gray-200">

                <button id="activeTab"
                    onclick="switchTab('active')"
                    class="px-4 py-2 font-semibold transition border-b-4 -mb-1">
                    Active
                </button>

                <button id="resignTab"
                    onclick="switchTab('resign')"
                    class="px-4 py-2 font-semibold transition border-b-4 -mb-1">
                    Resign
                </button>

            </div>

            {{-- Add --}}
            <a href="{{ route('pkwt.create') }}"
                class="px-4 py-2 bg-[#3db5ff] text-white rounded hover:bg-[#33a0e0] font-semibold">
                Add New PKWT Employee
            </a>

        </div>

        {{-- Search --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 space-y-4 md:space-y-0">

            <input
                type="text"
                id="searchInput"
                onkeyup="filterTable()"
                placeholder="Search employee..."
                class="border border-gray-300 rounded px-3 py-2 w-full md:w-1/3">

            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">

                {{-- Department --}}
                <select id="departmentFilter"
                    onchange="filterTable()"
                    class="border border-gray-300 rounded px-3 py-2">

                    <option value="">All Department</option>

                    @foreach($pkwts->pluck('employee.department')->unique() as $department)

                        @if($department)
                            <option value="{{ strtolower($department) }}">
                                {{ $department }}
                            </option>
                        @endif

                    @endforeach

                </select>

                {{-- Position --}}
                <select id="positionFilter"
                    onchange="filterTable()"
                    class="border border-gray-300 rounded px-3 py-2">

                    <option value="">All Position</option>

                    @foreach($pkwts->pluck('employee.position')->unique() as $position)

                        @if($position)
                            <option value="{{ strtolower($position) }}">
                                {{ $position }}
                            </option>
                        @endif

                    @endforeach

                </select>

            </div>

        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">

            <table id="employeeTable" class="min-w-full border border-gray-200 rounded">

                <thead class="bg-[#3db5ff] text-white">

                    <tr>
                        <th class="py-3 px-4 border-b text-center">No PKWT</th>
                        <th class="py-3 px-4 border-b">Employee Name</th>
                        <th class="py-3 px-4 border-b">Position</th>
                        <th class="py-3 px-4 border-b">Department</th>
                        <th class="py-3 px-4 border-b">Tanggal Awal</th>
                        <th class="py-3 px-4 border-b">Tanggal Akhir</th>
                        <th class="py-3 px-4 border-b">Waktu</th>
                        <th class="py-3 px-4 border-b">File PKWT</th>
                        <th class="py-3 px-4 border-b text-center">Action</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($pkwts as $pkwt)

                        @php

                            $today = Carbon::today();

                            $endDate = Carbon::parse($pkwt->end_date);

                            $status = $endDate->gte($today) ? 'active' : 'resign';

                            $start = Carbon::parse($pkwt->start_date);

                            $end = Carbon::parse($pkwt->end_date);

                            $diff = $start->diff($end);

                            $duration = '';

                            if ($diff->y > 0) {
                                $duration .= $diff->y . ' Tahun ';
                            }

                            if ($diff->m > 0) {
                                $duration .= $diff->m . ' Bulan ';
                            }

                            if ($diff->d > 0) {
                                $duration .= $diff->d . ' Hari';
                            }

                            $duration = trim($duration);

                            if ($duration == '') {
                                $duration = '0 Hari';
                            }

                        @endphp

                        <tr
                            class="employee-row hover:bg-gray-50"
                            data-status="{{ $status }}"
                            data-department="{{ strtolower($pkwt->employee->department ?? '') }}"
                            data-position="{{ strtolower($pkwt->employee->position ?? '') }}">

                            {{-- Contract Number --}}
                            <td class="py-3 px-4 border-b text-center">
                                {{ $pkwt->contract_number ?? '-' }}
                            </td>

                            {{-- Employee Name --}}
                            <td class="py-3 px-4 border-b">
                                {{ $pkwt->employee->name ?? '-' }}
                            </td>

                            {{-- Position --}}
                            <td class="py-3 px-4 border-b">
                                {{ $pkwt->employee->position ?? '-' }}
                            </td>

                            {{-- Department --}}
                            <td class="py-3 px-4 border-b">
                                {{ $pkwt->employee->department ?? '-' }}
                            </td>

                            {{-- Start Date --}}
                            <td class="py-3 px-4 border-b">
                                {{ Carbon::parse($pkwt->start_date)->format('d M Y') }}
                            </td>

                            {{-- End Date --}}
                            <td class="py-3 px-4 border-b">
                                {{ Carbon::parse($pkwt->end_date)->format('d M Y') }}
                            </td>

                            {{-- Duration --}}
                            <td class="py-3 px-4 border-b">
                                {{ $duration }}
                            </td>

                            {{-- File --}}
                            <td class="py-3 px-4 border-b">

                                @if($pkwt->file_path)

                                    <a href="{{ asset('storage/' . $pkwt->file_path) }}"
                                        target="_blank"
                                        class="text-blue-600 hover:underline">

                                        Download

                                    </a>

                                @else

                                    <span class="text-gray-400">
                                        No File
                                    </span>

                                @endif

                            </td>

                            {{-- Action --}}
                            <td class="py-3 px-4 border-b text-center">

                                <div class="relative inline-block text-left">

                                    <button onclick="toggleDropdown(this)"
                                        class="bg-gray-200 px-3 py-1 rounded hover:bg-gray-300">

                                        Actions

                                    </button>

                                    <div class="dropdown hidden absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded shadow-lg z-10">

                                        <a href="{{ route('pkwt.edit', $pkwt->id) }}"
                                            class="block px-4 py-2 hover:bg-gray-100 text-left">

                                            Edit

                                        </a>

                                        <form action="{{ route('pkwt.destroy', $pkwt->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Delete this data?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="block w-full text-left px-4 py-2 hover:bg-gray-100">

                                                Delete

                                            </button>

                                        </form>

                                    </div>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="9"
                                class="py-6 text-center text-gray-500">

                                No PKWT employee data found.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<script>

// Dropdown
function toggleDropdown(button) {

    document.querySelectorAll('.dropdown').forEach(dropdown => {

        if (dropdown !== button.nextElementSibling) {
            dropdown.classList.add('hidden');
        }

    });

    const dropdown = button.nextElementSibling;

    dropdown.classList.toggle('hidden');

}

// Close outside
document.addEventListener('click', function(e) {

    if (!e.target.closest('.relative')) {

        document.querySelectorAll('.dropdown').forEach(dropdown => {
            dropdown.classList.add('hidden');
        });

    }

});

// Tab
let currentTab = 'active';

function switchTab(tab) {

    currentTab = tab;

    const activeBtn = document.getElementById('activeTab');

    const resignBtn = document.getElementById('resignTab');

    const activeClass = 'border-b-4 border-[#3db5ff] text-[#3db5ff]';

    const inactiveClass = 'border-b-4 border-transparent text-gray-700';

    if (tab === 'active') {

        activeBtn.className = `px-4 py-2 font-semibold transition ${activeClass}`;

        resignBtn.className = `px-4 py-2 font-semibold transition ${inactiveClass}`;

    } else {

        resignBtn.className = `px-4 py-2 font-semibold transition ${activeClass}`;

        activeBtn.className = `px-4 py-2 font-semibold transition ${inactiveClass}`;

    }

    filterTable();

}

// Filter
function filterTable() {

    const search = document.getElementById('searchInput').value.toLowerCase();

    const department = document.getElementById('departmentFilter').value.toLowerCase();

    const position = document.getElementById('positionFilter').value.toLowerCase();

    document.querySelectorAll('.employee-row').forEach(row => {

        const name = row.cells[1].innerText.toLowerCase();

        const rowStatus = row.dataset.status;

        const rowDepartment = row.dataset.department;

        const rowPosition = row.dataset.position;

        if (
            name.includes(search) &&
            (department === '' || department === rowDepartment) &&
            (position === '' || position === rowPosition) &&
            rowStatus === currentTab
        ) {

            row.style.display = '';

        } else {

            row.style.display = 'none';

        }

    });

}

// Init
switchTab('active');

</script>

@endsection