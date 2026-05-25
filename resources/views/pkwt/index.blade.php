@extends('layouts.app')

@section('title', 'PKWT ' . $branch . ' Employees')

@section('content')

@php
    use Illuminate\Support\Facades\Storage;
@endphp

<style>
    [x-cloak] {
        display: none !important;
    }
</style>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div class="container mx-auto p-6" x-data="pkwtModal()">
    <div class="bg-white shadow-lg rounded-2xl p-6">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    PKWT {{ $branch }} Employees
                </h1>
                <p class="text-gray-500 mt-1">
                    Management data kontrak karyawan {{ $branch }}
                </p>
            </div>

            <a href="{{ route('pkwt.create') }}"
               class="px-5 py-2.5 bg-[#3db5ff] text-white rounded-xl hover:bg-[#33a0e0] font-semibold transition duration-200 shadow-sm">
                Add New PKWT Employee
            </a>
        </div>

        {{-- FILTER --}}
        <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4 mb-6">

            {{-- SEARCH --}}
            <div class="w-full xl:w-1/3">
                <input type="text"
                       id="searchInput"
                       onkeyup="filterTable()"
                       placeholder="Search employee..."
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#3db5ff]">
            </div>

            {{-- DROPDOWN FILTER --}}
            <div class="flex flex-col sm:flex-row gap-3">

                {{-- STATUS --}}
                <select id="statusFilter"
                        onchange="filterTable()"
                        class="w-56 border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#3db5ff]">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="almost expired">Almost Expired</option>
                    <option value="expired">Expired</option>
                </select>

                {{-- DEPARTMENT --}}
                <select id="departmentFilter"
                        onchange="filterTable()"
                        class="w-56 border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#3db5ff]">
                    <option value="">All Department</option>

                    @foreach($pkwts->pluck('employee.department')->filter()->unique() as $department)
                        <option value="{{ strtolower($department) }}">
                            {{ $department }}
                        </option>
                    @endforeach
                </select>

                {{-- POSITION --}}
                <select id="positionFilter"
                        onchange="filterTable()"
                        class="w-56 border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#3db5ff]">
                    <option value="">All Position</option>

                    @foreach($pkwts->pluck('employee.position')->filter()->unique() as $position)
                        <option value="{{ strtolower($position) }}">
                            {{ $position }}
                        </option>
                    @endforeach
                </select>

            </div>
        </div>

        {{-- TABLE WRAPPER --}}
        <div class="overflow-x-auto rounded-xl border border-gray-200">
            <div class="min-w-[1200px]">

                <table id="employeeTable" class="w-full table-auto">

                    <thead class="bg-[#3db5ff] text-white">
                        <tr>
                            <th class="py-3 px-4 border-b text-center whitespace-nowrap min-w-[120px]">No PKWT</th>
                            <th class="py-3 px-4 border-b whitespace-nowrap min-w-[220px]">Employee Name</th>
                            <th class="py-3 px-4 border-b whitespace-nowrap min-w-[180px]">Position</th>
                            <th class="py-3 px-4 border-b whitespace-nowrap min-w-[180px]">Department</th>
                            <th class="py-3 px-4 border-b whitespace-nowrap min-w-[140px]">Tanggal Awal</th>
                            <th class="py-3 px-4 border-b whitespace-nowrap min-w-[140px]">Tanggal Akhir</th>
                            <th class="py-3 px-4 border-b whitespace-nowrap min-w-[160px]">Duration</th>
                            <th class="py-3 px-4 border-b whitespace-nowrap min-w-[140px]">Remaining</th>
                            <th class="py-3 px-4 border-b whitespace-nowrap min-w-[140px]">Status</th>
                            <th class="py-3 px-4 border-b whitespace-nowrap min-w-[140px]">File PKWT</th>
                            <th class="py-3 px-4 border-b text-center whitespace-nowrap min-w-[140px]">Action</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white">
                        @forelse($pkwts as $pkwt)
                            <tr class="employee-row transition {{ $pkwt->status === 'Expired' ? 'bg-red-50 hover:bg-red-100' : ($pkwt->status === 'Almost Expired' ? 'bg-yellow-50 hover:bg-yellow-100' : 'hover:bg-gray-50') }}"
                                data-status="{{ strtolower($pkwt->status) }}"
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
                                    {{ $pkwt->start_date ? $pkwt->start_date->format('d M Y') : '-' }}
                                </td>

                                <td class="py-3 px-4 border-b whitespace-nowrap">
                                    {{ $pkwt->end_date ? $pkwt->end_date->format('d M Y') : '-' }}
                                </td>

                                <td class="py-3 px-4 border-b whitespace-nowrap">
                                    {{ $pkwt->duration }}
                                </td>

                                <td class="py-3 px-4 border-b whitespace-nowrap font-medium">
                                    @if(is_null($pkwt->remaining_days))
                                        -
                                    @elseif($pkwt->remaining_days < 0)
                                        <span class="text-red-600">Expired</span>
                                    @else
                                        {{ $pkwt->remaining_days }} Hari
                                    @endif
                                </td>

                                <td class="py-3 px-4 border-b whitespace-nowrap">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $pkwt->status_class }}">
                                        {{ $pkwt->status }}
                                    </span>
                                </td>

                                <td class="py-3 px-4 border-b whitespace-nowrap">
                                    @if($pkwt->file_path)
                                        <a href="{{ route('pkwt.download', $pkwt->id) }}"
   class="text-blue-600 hover:underline font-medium">
    Download
</a>
                                    @else
                                        <span class="text-gray-400">No File</span>
                                    @endif
                                </td>

                                <td class="py-3 px-4 border-b text-center whitespace-nowrap">
                                    <div class="relative inline-block">

                                       <button onclick="toggleDropdown(this)"
        class="flex items-center gap-2 px-3 py-1.5 rounded-lg border border-[#3DB5FF] text-[#3DB5FF] bg-white hover:bg-blue-50 transition relative z-10">

    <span class="font-medium">Actions</span>

    <svg xmlns="http://www.w3.org/2000/svg"
         class="w-4 h-4 text-[#3DB5FF] transition-transform duration-200 dropdown-icon"
         viewBox="0 0 20 20"
         fill="currentColor">
        <path fill-rule="evenodd"
              d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
              clip-rule="evenodd" />
    </svg>
</button>

<div class="dropdown hidden absolute right-0 mt-2 w-44 bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden z-50">

    {{-- EDIT --}}
    <button type="button"
            class="block w-full text-left px-4 py-2 hover:bg-gray-100"
            @click="openEditModal({{ $pkwt->id }})">
        Edit Data
    </button>

    {{-- DELETE DATA --}}
    <form action="{{ route('pkwt.destroy', $pkwt->id) }}"
          method="POST"
          onsubmit="return confirm('Delete PKWT ini?')">
        @csrf
        @method('DELETE')

        <button type="submit"
                class="block w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
            Delete Data
        </button>
    </form>

    {{-- DELETE FILE ONLY --}}
    @if($pkwt->file_path)
    <form action="{{ route('pkwt.deleteFile', $pkwt->id) }}"
          method="POST"
          onsubmit="return confirm('Hapus file saja?')">
        @csrf
        @method('DELETE')

        <button type="submit"
                class="block w-full text-left px-4 py-2 text-orange-600 hover:bg-orange-50">
            Delete File Only
        </button>
    </form>
    @endif

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

    {{-- MODAL --}}
    <div x-cloak
         x-show="open"
         @click.self="open = false"
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
         x-transition>

        <div class="bg-white w-full max-w-2xl rounded-xl p-6 shadow-lg">

            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold">Edit PKWT</h2>

                <button type="button" @click="open = false" class="text-gray-500 hover:text-gray-700">
                    ✕
                </button>
            </div>

            <form :action="`/pkwt/${form.id}`" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Employee</label>
                        <select name="employee_id"
                                x-model="form.employee_id"
                                class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#3db5ff]">
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">
                                    {{ $employee->name }} - {{ $employee->position }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contract Number</label>
                        <input type="text"
                               name="contract_number"
                               x-model="form.contract_number"
                               class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#3db5ff]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Company</label>
                        <input type="text"
                               name="company"
                               x-model="form.company"
                               class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#3db5ff]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                        <input type="date"
                               name="start_date"
                               x-model="form.start_date"
                               class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#3db5ff]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                        <input type="date"
                               name="end_date"
                               x-model="form.end_date"
                               class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#3db5ff]">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">File PKWT</label>
                        <input type="file"
                               name="file_path"
                               class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#3db5ff]">

                        <p class="text-xs text-gray-500 mt-1">
                            Kosongkan jika tidak ingin mengganti file.
                        </p>
                    </div>

                </div>

                <div class="flex justify-end gap-2 mt-5">
                    <button type="button"
                            @click="open = false"
                            class="px-4 py-2 bg-gray-300 rounded-xl">
                        Cancel
                    </button>

                    <button type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded-xl">
                        Save
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

<script>
function toggleDropdown(button) {
    const dropdown = button.nextElementSibling;
    const icon = button.querySelector('.dropdown-icon');

    document.querySelectorAll('.dropdown').forEach(d => {
        if (d !== dropdown) {
            d.classList.add('hidden');

            // reset semua icon
            const btn = d.parentElement.querySelector('button');
            if (btn) {
                const ic = btn.querySelector('.dropdown-icon');
                if (ic) ic.classList.remove('rotate-180');
            }
        }
    });

    dropdown.classList.toggle('hidden');

    // rotate icon
    if (icon) {
        icon.classList.toggle('rotate-180');
    }
}

document.addEventListener('click', function (e) {
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

        const match =
            name.includes(search) &&
            (status === '' || status === rowStatus) &&
            (department === '' || department === rowDepartment) &&
            (position === '' || position === rowPosition);

        row.style.display = match ? '' : 'none';
    });
}
</script>

<script>
function pkwtModal() {
    return {
        open: false,
        form: {
            id: null,
            employee_id: '',
            contract_number: '',
            start_date: '',
            end_date: '',
            company: ''
        },

        openEditModal(id) {
            fetch(`/pkwt/${id}/json`)
                .then(res => res.json())
                .then(data => {
                    this.form.id = data.id;
                    this.form.employee_id = data.employee_id ?? '';
                    this.form.contract_number = data.contract_number ?? '';
                    this.form.start_date = data.start_date ?? '';
                    this.form.end_date = data.end_date ?? '';
                    this.form.company = data.company ?? '';
                    this.open = true;
                });
        }
    }
}
</script>

@endsection