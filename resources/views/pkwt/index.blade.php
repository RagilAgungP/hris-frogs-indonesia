@extends('layouts.app')

@section('title', 'PKWT ' . $branch . ' Employees')
@section('content')

@php
    use Carbon\Carbon;
    use Illuminate\Support\Facades\Storage;
@endphp

<div class="container mx-auto p-6">

    <div class="bg-white shadow-lg rounded-2xl p-6">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">

            <div>

           <h1 class="text-2xl font-bold text-gray-800">
    PKWT {{ $branch }} Employees
</h1>

            <p class="text-gray-500 mt-1">
    Management data kontrak karyawan {{ $branch }}
</p>

            </div>

            {{-- Add --}}
            <a href="{{ route('pkwt.create') }}"
                class="px-5 py-2.5 bg-[#3db5ff] text-white rounded-xl hover:bg-[#33a0e0] font-semibold transition duration-200 shadow-sm">

                Add New PKWT Employee

            </a>

        </div>

        {{-- Filter --}}
        <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4 mb-6">

            {{-- Search --}}
            <div class="w-full xl:w-1/3">

                <input
                    type="text"
                    id="searchInput"
                    onkeyup="filterTable()"
                    placeholder="Search employee..."
                    class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#3db5ff]">

            </div>

            {{-- Filters --}}
            <div class="flex flex-col sm:flex-row gap-3">

                {{-- Status --}}
                <select id="statusFilter"
                    onchange="filterTable()"
                    class="border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#3db5ff]">

                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="almost expired">Almost Expired</option>
                    <option value="expired">Expired</option>

                </select>

                {{-- Department --}}
                <select id="departmentFilter"
                    onchange="filterTable()"
                    class="border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#3db5ff]">

                    <option value="">All Department</option>

                    @foreach($pkwts->pluck('employee.department')->filter()->unique() as $department)

                        <option value="{{ strtolower($department) }}">
                            {{ $department }}
                        </option>

                    @endforeach

                </select>

                {{-- Position --}}
                <select id="positionFilter"
                    onchange="filterTable()"
                    class="border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#3db5ff]">

                    <option value="">All Position</option>

                    @foreach($pkwts->pluck('employee.position')->filter()->unique() as $position)

                        <option value="{{ strtolower($position) }}">
                            {{ $position }}
                        </option>

                    @endforeach

                </select>

            </div>

        </div>

        {{-- Table --}}
        <div class="overflow-x-auto rounded-xl border border-gray-200">

            <table id="employeeTable" class="min-w-full">

                <thead class="bg-[#3db5ff] text-white">

                    <tr>

                        <th class="py-3 px-4 border-b text-center whitespace-nowrap">
                            No PKWT
                        </th>

                        <th class="py-3 px-4 border-b whitespace-nowrap">
                            Employee Name
                        </th>

                        <th class="py-3 px-4 border-b whitespace-nowrap">
                            Position
                        </th>

                        <th class="py-3 px-4 border-b whitespace-nowrap">
                            Department
                        </th>

                        <th class="py-3 px-4 border-b whitespace-nowrap">
                            Tanggal Awal
                        </th>

                        <th class="py-3 px-4 border-b whitespace-nowrap">
                            Tanggal Akhir
                        </th>

                        <th class="py-3 px-4 border-b whitespace-nowrap">
                            Duration
                        </th>

                        <th class="py-3 px-4 border-b whitespace-nowrap">
                            Remaining
                        </th>

                        <th class="py-3 px-4 border-b whitespace-nowrap">
                            Status
                        </th>

                        <th class="py-3 px-4 border-b whitespace-nowrap">
                            File PKWT
                        </th>

                        <th class="py-3 px-4 border-b text-center whitespace-nowrap">
                            Action
                        </th>

                    </tr>

                </thead>

                <tbody class="bg-white">

                    @forelse($pkwts as $pkwt)

                        @php
                            $today = Carbon::today();

                            $startDate = $pkwt->start_date ? Carbon::parse($pkwt->start_date) : null;
                            $endDate = $pkwt->end_date ? Carbon::parse($pkwt->end_date) : null;

                            /*
                            |--------------------------------------------------------------------------
                            | STATUS
                            |--------------------------------------------------------------------------
                            */
                            if (!$endDate) {

                                $status = 'Active';
                                $statusClass = 'bg-green-100 text-green-700';
                                $rowClass = 'hover:bg-gray-50';

                            } elseif ($endDate->isPast()) {

                                $status = 'Expired';
                                $statusClass = 'bg-red-100 text-red-700';
                                $rowClass = 'bg-red-50 hover:bg-red-100';

                            } elseif ($today->diffInDays($endDate, false) <= 30) {

                                $status = 'Almost Expired';
                                $statusClass = 'bg-yellow-100 text-yellow-700';
                                $rowClass = 'bg-yellow-50 hover:bg-yellow-100';

                            } else {

                                $status = 'Active';
                                $statusClass = 'bg-green-100 text-green-700';
                                $rowClass = 'hover:bg-gray-50';

                            }

                            /*
                            |--------------------------------------------------------------------------
                            | DURATION
                            |--------------------------------------------------------------------------
                            */
                            if ($startDate && $endDate) {

                                $diff = $startDate->diff($endDate);

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

                            } else {
                                $duration = 'Belum ditentukan';
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | REMAINING DAYS
                            |--------------------------------------------------------------------------
                            */
                            $remainingDays = $endDate
                                ? $today->diffInDays($endDate, false)
                                : null;
                        @endphp

                        <tr class="employee-row transition {{ $rowClass }}"
                            data-status="{{ strtolower($status) }}"
                            data-department="{{ strtolower($pkwt->employee->department ?? '') }}"
                            data-position="{{ strtolower($pkwt->employee->position ?? '') }}">

                            <td class="py-3 px-4 border-b text-center whitespace-nowrap">
                                {{ $pkwt->contract_number ?? '-' }}
                            </td>

                            <td class="py-3 px-4 border-b whitespace-nowrap font-medium text-gray-800">
                                {{ $pkwt->employee->name ?? '-' }}
                            </td>

                            <td class="py-3 px-4 border-b whitespace-nowrap">
                                {{ $pkwt->employee->position ?? '-' }}
                            </td>

                            <td class="py-3 px-4 border-b whitespace-nowrap">
                                {{ $pkwt->employee->department ?? '-' }}
                            </td>

                            <td class="py-3 px-4 border-b whitespace-nowrap">
                                {{ $startDate ? $startDate->format('d M Y') : '-' }}
                            </td>

                            <td class="py-3 px-4 border-b whitespace-nowrap">
                                {{ $endDate ? $endDate->format('d M Y') : '-' }}
                            </td>

                            <td class="py-3 px-4 border-b whitespace-nowrap">
                                {{ $duration }}
                            </td>

                            <td class="py-3 px-4 border-b whitespace-nowrap font-medium">

                                @if(is_null($remainingDays))
                                    -
                                @elseif($remainingDays < 0)
                                    <span class="text-red-600">Expired</span>
                                @else
                                    {{ $remainingDays }} Hari
                                @endif

                            </td>

                            <td class="py-3 px-4 border-b whitespace-nowrap">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
                                    {{ $status }}
                                </span>
                            </td>

                            <td class="py-3 px-4 border-b whitespace-nowrap">

                                @if($pkwt->file_path)

                                    <a href="{{ Storage::url($pkwt->file_path) }}"
                                        target="_blank"
                                        class="text-blue-600 hover:underline font-medium">
                                        Download
                                    </a>

                                @else
                                    <span class="text-gray-400">No File</span>
                                @endif

                            </td>

                            <td class="py-3 px-4 border-b text-center whitespace-nowrap">

                                <div class="relative inline-block text-left z-20">

                                    <button onclick="toggleDropdown(this)"
                                        class="bg-gray-200 px-3 py-1.5 rounded-lg hover:bg-gray-300 transition">
                                        Actions
                                    </button>

                                    <div class="dropdown hidden absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">

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
                            <td colspan="11" class="py-8 text-center text-gray-500">
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
function toggleDropdown(button) {
    document.querySelectorAll('.dropdown').forEach(dropdown => {
        if (dropdown !== button.nextElementSibling) {
            dropdown.classList.add('hidden');
        }
    });

    button.nextElementSibling.classList.toggle('hidden');
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('.relative')) {
        document.querySelectorAll('.dropdown').forEach(dropdown => {
            dropdown.classList.add('hidden');
        });
    }
});

function filterTable() {

    const search = document.getElementById('searchInput').value.toLowerCase();
    const status = document.getElementById('statusFilter').value.toLowerCase();
    const department = document.getElementById('departmentFilter').value.toLowerCase();
    const position = document.getElementById('positionFilter').value.toLowerCase();

    document.querySelectorAll('.employee-row').forEach(row => {

        const name = row.cells[1].innerText.toLowerCase();
        const rowStatus = row.dataset.status || '';
        const rowDepartment = row.dataset.department || '';
        const rowPosition = row.dataset.position || '';

        if (
            name.includes(search) &&
            (status === '' || status === rowStatus) &&
            (department === '' || department === rowDepartment) &&
            (position === '' || position === rowPosition)
        ) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }

    });
}
</script>

@endsection