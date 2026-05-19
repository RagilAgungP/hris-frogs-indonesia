@extends('layouts.app')

@section('title', 'General Setting | FROGS Indonesia')

@section('content')
<div class="container mx-auto p-6 space-y-6">

    {{-- Judul SAJA --}}
    <h2 class="text-2xl font-semibold text-gray-800 text-center">
        General Setting
    </h2>

    {{-- Card Kecil : Add --}}
    <div class="bg-white shadow rounded-lg p-4 w-fit mx-auto">
        <div class="flex flex-col sm:flex-row items-center gap-3">

            <select class="border border-gray-300 rounded px-3 py-2 w-44">
                <option value="">Type</option>
                <option value="branch">Branch</option>
                <option value="department">Department</option>
                <option value="position">Position</option>
            </select>

            <input
                type="text"
                placeholder="Enter name"
                class="border border-gray-300 rounded px-3 py-2 w-56 focus:ring-2 focus:ring-[#3db5ff]"
            >

            <button class="px-4 py-2 bg-[#3db5ff] text-white rounded hover:bg-[#33a0e0] font-semibold">
                Add
            </button>

        </div>
    </div>

    {{-- Cards Data --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">

 <div class="bg-white shadow rounded-lg p-4">
    <h3 class="bg-[#3db5ff] text-white font-semibold text-lg px-4 py-2 rounded mb-4">
        Branch
    </h3>

    <ul class="space-y-2">
        <li class="flex justify-between items-center">
            <span>PT Frogs Solusi Indonesia</span>
            @include('settings.partials.action-menu')
        </li>
    </ul>
</div>


       <div class="bg-white shadow rounded-lg p-4">
    <h3 class="bg-[#3db5ff] text-white font-semibold text-lg px-4 py-2 rounded mb-4">
        Department
    </h3>

    <ul class="space-y-2">
        @foreach ([
            'Oprational ISTI',
            'Oprational FSI',
            'Sales & Marketing',
            'Finance, Accounting, and Tax',
            'Technology',
            'Management',
            'Chief',
            'Business Development',
            'HRGA'
        ] as $dept)
        <li class="flex justify-between items-center">
            <span>{{ $dept }}</span>
            @include('settings.partials.action-menu')
        </li>
        @endforeach
    </ul>
</div>


       <div class="bg-white shadow rounded-lg p-4">
    <h3 class="bg-[#3db5ff] text-white font-semibold text-lg px-4 py-2 rounded mb-4">
        Position
    </h3>

    <ul class="space-y-2">
        @foreach ([
            'Chief Operating Officer',
            'Chief Sales & Marketing',
            'Head of Operation',
            'Head of HRGA',
            'Manufacturing Engineering Supervisor',
            'Quality Assurance Staff',
            'Inbound CS Staff',
            'Chief Technology Officer',
            'Chief Financial Officer',
            'Head of Project Business Development',
            'Head of FAT',
            'Chief Support Operation (FSI)',
            'Head of Technology',
            'Head of Operation (FSI)',
            'IT Supervisor',
            'Project Academy Supervisor',
            'Digital Marketing Staff',
            'Production Staff',
            'Flight Systems Engineer Supervisor',
            'FAT Staff',
            'Co-Founder & Direktur',
            'Head of Production',
            'Marketing & Admin Staff',
            'Structure Engineer Staff',
            'Avionics Engineer Staff',
            'Purchasing Staff',
            'Assembly Staff',
            'Security',
            'Office Boy',
            'Sales Supervisor',
            'Warehouse & Admin Staff',
            'Chief Executive Officer',
            'Quality Assurance Engineer Staff',
            'Head of Sales',
            'Sales Staff',
            'HRGA Supervisor',
            'Mechanical Design Engineer Staff',
            'Sales Engineer Staff',
            'IT Engineer Staff',
            'HRGA Staff',
            'Legal & Compliance',
            'Operations Manager',
            'Business Staff',
            'Helper',
            'Area Coordinator'
        ] as $pos)
        <li class="flex justify-between items-center">
            <span>{{ $pos }}</span>
            @include('settings.partials.action-menu')
        </li>
        @endforeach
    </ul>
</div>


{{-- Dropdown --}}
<script>
function toggleDropdown(button) {
    const dropdown = button.nextElementSibling;
    dropdown.classList.toggle('hidden');
}

document.addEventListener('click', function(e) {
    document.querySelectorAll('.dropdown').forEach(d => {
        if (!d.previousElementSibling.contains(e.target)) {
            d.classList.add('hidden');
        }
    });
});
</script>
@endsection
