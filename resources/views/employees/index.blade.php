@extends('layouts.app')

@section('title', 'Employee | PT Inovasi Solusi Transportasi Indonesia')

@section('content')

<div class="container mx-auto p-6">

    {{-- Card --}}
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

            {{-- Add Employee --}}
            <a href="{{ route('employee.create', ['branch' => 'FSI']) }}"
                class="px-4 py-2 bg-[#3db5ff] text-white rounded hover:bg-[#33a0e0] font-semibold">

                Add New Employee

            </a>

        </div>

        {{-- Search & Filters --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4 space-y-4 md:space-y-0">

            {{-- Search --}}
            <input type="text"
                id="searchInput"
                onkeyup="filterTable()"
                placeholder="Search employee..."
                class="border border-gray-300 rounded px-3 py-2 w-full md:w-1/3">

            {{-- Filters --}}
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2">

                {{-- Department --}}
                <select id="departmentFilter"
                    onchange="filterTable()"
                    class="border border-gray-300 rounded px-4 py-2 w-48 md:w-52">

                    <option value="">All Department</option>
                    <option value="operational isti">Operational ISTI</option>
                    <option value="operational fsi">Operational FSI</option>
                    <option value="sales & marketing">Sales & Marketing</option>
                    <option value="finance, accounting, and tax">Finance, Accounting, and Tax</option>
                    <option value="technology">Technology</option>
                    <option value="management">Management</option>
                    <option value="chief">Chief</option>
                    <option value="business development">Business Development</option>
                    <option value="hrga">HRGA</option>

                </select>

                {{-- Position --}}
                <select id="positionFilter"
                    onchange="filterTable()"
                    class="border border-gray-300 rounded px-4 py-2 w-48 md:w-52">

                    <option value="">All Position</option>
                    <option value="chief operating officer">Chief Operating Officer</option>
                    <option value="head of operation">Head of Operation</option>
                    <option value="hrga staff">HRGA Staff</option>
                    <option value="it engineer staff">IT Engineer Staff</option>
                    <option value="sales staff">Sales Staff</option>

                </select>

            </div>

        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">

            <table id="employeeTable"
                class="min-w-full border border-gray-200 rounded">

                {{-- Head --}}
                <thead class="bg-[#3db5ff] text-white">

                    <tr>
                        <th class="py-3 px-4 border-b text-center">No</th>
                        <th class="py-3 px-4 border-b text-left">Employee Name / ID</th>
                        <th class="py-3 px-4 border-b text-left">Status</th>
                        <th class="py-3 px-4 border-b text-left">Branch</th>
                        <th class="py-3 px-4 border-b text-left">Department</th>
                        <th class="py-3 px-4 border-b text-left">Position</th>
                        <th class="py-3 px-4 border-b text-left">Join Date</th>
                        <th class="py-3 px-4 border-b text-center">Actions</th>
                    </tr>

                </thead>

                {{-- Body --}}
                <tbody id="employeeTableBody">

                    @forelse($employees as $employee)

                    <tr class="employee-row"
                        data-status="{{ strtolower($employee->employee_condition) }}"
                        data-department="{{ strtolower($employee->department) }}"
                        data-position="{{ strtolower($employee->position) }}">

                        {{-- No --}}
                        <td class="py-3 px-4 border-b text-center row-number">
                            {{ $loop->iteration }}
                        </td>

                        {{-- Employee --}}
                        <td class="py-3 px-4 border-b">

                            <div class="font-semibold">
                                {{ $employee->name }}
                            </div>

                            <div class="text-sm text-gray-500">
                                ID: {{ $employee->employee_id }}
                            </div>

                        </td>

                        {{-- Status --}}
                        <td class="py-3 px-4 border-b">

                            @if($employee->status == 'Permanent')

                                <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                                    Permanent
                                </span>

                            @else

                                <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700">
                                    Contract
                                </span>

                            @endif

                        </td>

                        {{-- Branch --}}
                        <td class="py-3 px-4 border-b">
                            {{ $employee->branch }}
                        </td>

                        {{-- Department --}}
                        <td class="py-3 px-4 border-b">
                            {{ $employee->department }}
                        </td>

                        {{-- Position --}}
                        <td class="py-3 px-4 border-b">
                            {{ $employee->position }}
                        </td>

                        {{-- Join Date --}}
                        <td class="py-3 px-4 border-b">
                            {{ \Carbon\Carbon::parse($employee->date_of_joining)->format('d M Y') }}
                        </td>

                        {{-- Actions --}}
                        <td class="py-3 px-4 border-b text-center">

                            <div class="relative inline-block text-left">

                                {{-- Button --}}
                                <button onclick="toggleDropdown(this)"
                                    class="bg-gray-200 px-3 py-1 rounded hover:bg-gray-300">

                                    Actions

                                </button>

                               {{-- Dropdown --}}
<div class="dropdown hidden absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded shadow-lg z-10">

    {{-- See Detail --}}
    <a href="{{ route('employee.show', $employee->id) }}"
        class="block px-4 py-2 hover:bg-gray-100">

        See Detail

    </a>

    {{-- Resign --}}
    @if($employee->employee_condition == 'Active')

    <form action="{{ route('employee.resign', $employee->id) }}"
        method="POST"
        onsubmit="return confirm('Employee will be resigned?')">

        @csrf
        @method('PUT')

        <button type="submit"
            class="w-full text-left px-4 py-2 hover:bg-red-100 text-red-600">

            Resign

        </button>

    </form>

    @endif

    {{-- Delete --}}
    <form action="{{ route('employee.destroy', $employee->id) }}"
        method="POST"
        onsubmit="return confirm('Delete this employee?')">

        @csrf
        @method('DELETE')

        <button type="submit"
            class="w-full text-left px-4 py-2 hover:bg-gray-100 text-red-500">

            Delete

        </button>

    </form>

</div>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="8"
                            class="py-6 text-center text-gray-500">

                            No employee data found

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

{{-- SCRIPT --}}
<script>

    /*
    |--------------------------------------------------------------------------
    | DROPDOWN
    |--------------------------------------------------------------------------
    */
    function toggleDropdown(button)
    {
        const dropdown = button.nextElementSibling;

        document.querySelectorAll('.dropdown').forEach(item =>
        {
            if(item !== dropdown)
            {
                item.classList.add('hidden');
            }
        });

        dropdown.classList.toggle('hidden');

        document.addEventListener('click', function handler(e)
        {
            if (!button.contains(e.target) && !dropdown.contains(e.target))
            {
                dropdown.classList.add('hidden');
                document.removeEventListener('click', handler);
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | TAB
    |--------------------------------------------------------------------------
    */
    let currentTab = 'active';

    function switchTab(tab)
    {
        currentTab = tab;

        const activeBtn = document.getElementById('activeTab');
        const resignBtn = document.getElementById('resignTab');

        const activeClass =
            'px-4 py-2 font-semibold transition border-b-4 border-[#3db5ff] text-[#3db5ff] -mb-1';

        const inactiveClass =
            'px-4 py-2 font-semibold transition border-b-4 border-transparent text-gray-700 -mb-1';

        if(tab === 'active')
        {
            activeBtn.className = activeClass;
            resignBtn.className = inactiveClass;
        }
        else
        {
            resignBtn.className = activeClass;
            activeBtn.className = inactiveClass;
        }

        filterTable();
    }

    /*
    |--------------------------------------------------------------------------
    | FILTER TABLE
    |--------------------------------------------------------------------------
    */
    function filterTable()
    {
        const search =
            document.getElementById('searchInput').value.toLowerCase();

        const department =
            document.getElementById('departmentFilter').value.toLowerCase();

        const position =
            document.getElementById('positionFilter').value.toLowerCase();

        let visibleIndex = 1;

        document.querySelectorAll('.employee-row').forEach(row =>
        {
            const name =
                row.cells[1].innerText.toLowerCase();

            const rowStatus =
                row.dataset.status;

            const rowDepartment =
                row.dataset.department;

            const rowPosition =
                row.dataset.position;

            if (
                name.includes(search) &&
                (department === '' || department === rowDepartment) &&
                (position === '' || position === rowPosition) &&
                (rowStatus === currentTab)
            )
            {
                row.style.display = '';

                row.querySelector('.row-number').innerText = visibleIndex;

                visibleIndex++;
            }
            else
            {
                row.style.display = 'none';
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | DEFAULT TAB
    |--------------------------------------------------------------------------
    */
    switchTab('active');

</script>

@endsection