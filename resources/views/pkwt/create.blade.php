@extends('layouts.app')

@section('title', 'Add PKWT Employee | PT Inovasi Solusi Transportasi Indonesia')

@section('content')

<div class="container mx-auto p-6">

    <div class="bg-white shadow-lg rounded-2xl p-8 max-w-5xl mx-auto">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">

            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Add PKWT Employee
                </h1>

                <p class="text-gray-500 mt-1">
                    Fill in employee PKWT information below.
                </p>
            </div>

            {{-- Back --}}
            <a href="{{ route('pkwt.index') }}"
                class="mt-4 md:mt-0 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                Back
            </a>

        </div>

        {{-- Validation Errors --}}
        @if ($errors->any())

            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">

                <ul class="list-disc list-inside space-y-1">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif

        {{-- Form --}}
        <form action="{{ route('pkwt.store') }}"
            method="POST"
            enctype="multipart/form-data">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Employee Name --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Employee Name
                    </label>

                    <input type="text"
                        name="employee_name"
                        value="{{ old('employee_name') }}"
                        placeholder="Enter employee name"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#3db5ff]"
                        required>
                </div>

                {{-- Contract Number --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Contract Number
                    </label>

                    <input type="text"
                        name="contract_number"
                        value="{{ old('contract_number') }}"
                        placeholder="Enter contract number"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#3db5ff]">
                </div>

                {{-- Position --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Position
                    </label>

                    <input type="text"
                        name="position"
                        value="{{ old('position') }}"
                        placeholder="Enter position"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#3db5ff]"
                        required>
                </div>

                {{-- Department --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Department
                    </label>

                    <input type="text"
                        name="department"
                        value="{{ old('department') }}"
                        placeholder="Enter department"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#3db5ff]"
                        required>
                </div>

                {{-- Company --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Company
                    </label>

                    <input type="text"
                        name="company"
                        value="{{ old('company') }}"
                        placeholder="Enter company name"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#3db5ff]">
                </div>

                {{-- Start Date --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Start Date
                    </label>

                    <input type="date"
                        name="start_date"
                        value="{{ old('start_date') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#3db5ff]"
                        required>
                </div>

                {{-- End Date --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        End Date
                    </label>

                    <input type="date"
                        name="end_date"
                        value="{{ old('end_date') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#3db5ff]"
                        required>
                </div>

                {{-- Upload File --}}
                <div>
                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                        Upload PKWT File
                    </label>

                    <input type="file"
                        name="file_path"
                        accept=".pdf,.doc,.docx"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 bg-white focus:outline-none focus:ring-2 focus:ring-[#3db5ff]">
                </div>

            </div>

            {{-- Submit --}}
            <div class="mt-8 flex justify-end">

                <button type="submit"
                    class="px-6 py-3 bg-[#3db5ff] text-white rounded-lg hover:bg-[#2fa4ec] transition font-semibold shadow">
                    Save PKWT Employee
                </button>

            </div>

        </form>

    </div>

</div>

@endsection