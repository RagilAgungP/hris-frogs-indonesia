@extends('layouts.app')

@section('title', 'Add New Employee | PT Inovasi Solusi Transportasi Indonesia')

@section('content')

<div class="container mx-auto p-6">

    <div class="bg-white shadow-md rounded-2xl p-8 max-w-6xl mx-auto">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">

            <div>
                <h2 class="text-3xl font-bold text-gray-800">
                    Create New Employee
                </h2>

                <p class="text-gray-500 mt-1">
                    Complete employee information, identity, and payroll details.
                </p>
            </div>

            <a href="{{ url()->previous() }}"
               class="mt-4 md:mt-0 px-5 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg font-semibold transition">

                Back

            </a>

        </div>

        {{-- Validation Error --}}
        @if ($errors->any())

            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">

                <ul class="list-disc pl-5 space-y-1">

                    @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif

        {{-- FORM --}}
        <form action="{{ route('employee.store') }}" method="POST">

            @csrf

            {{-- ================= EMPLOYEE INFORMATION ================= --}}
            <div class="mb-10">

                <div class="flex items-center mb-5">

                    <div class="w-2 h-8 bg-[#3db5ff] rounded mr-3"></div>

                    <div>

                        <h3 class="text-xl font-bold text-gray-800">
                            Employee Information
                        </h3>

                        <p class="text-sm text-gray-500">
                            Main employee information
                        </p>

                    </div>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- Employee ID --}}
                    <div>

                        <label class="font-semibold text-gray-700">
                            Employee ID *
                        </label>

                        <input type="text"
                               name="employee_id"
                               value="{{ old('employee_id') }}"
                               class="w-full border border-gray-300 rounded-lg p-3 mt-2 focus:ring-2 focus:ring-[#3db5ff] focus:outline-none"
                               placeholder="EMP0001"
                               required>

                    </div>

                    {{-- Employee Name --}}
                    <div>

                        <label class="font-semibold text-gray-700">
                            Employee Name *
                        </label>

                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               class="w-full border border-gray-300 rounded-lg p-3 mt-2 focus:ring-2 focus:ring-[#3db5ff] focus:outline-none"
                               placeholder="Full Name"
                               required>

                    </div>

                    {{-- Email --}}
                    <div>

                        <label class="font-semibold text-gray-700">
                            Email *
                        </label>

                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="w-full border border-gray-300 rounded-lg p-3 mt-2 focus:ring-2 focus:ring-[#3db5ff] focus:outline-none"
                               placeholder="employee@email.com"
                               required>

                    </div>

                    {{-- Entry Date --}}
                    <div>

                        <label class="font-semibold text-gray-700">
                            Entry Date *
                        </label>

                        <input type="date"
                               name="date_of_joining"
                               value="{{ old('date_of_joining') }}"
                               class="w-full border border-gray-300 rounded-lg p-3 mt-2 focus:ring-2 focus:ring-[#3db5ff] focus:outline-none"
                               required>

                    </div>

                    {{-- Branch --}}
                    <div>

                        <label class="font-semibold text-gray-700">
                            Branch *
                        </label>

                        <select name="branch"
                                class="w-full border border-gray-300 rounded-lg p-3 mt-2 focus:ring-2 focus:ring-[#3db5ff] focus:outline-none"
                                required>

                            <option value="">Select Branch</option>

                            <option value="FSI"
                                {{ old('branch', $branch ?? '') == 'FSI' ? 'selected' : '' }}>

                                FSI

                            </option>

                            <option value="ISTI"
                                {{ old('branch', $branch ?? '') == 'ISTI' ? 'selected' : '' }}>

                                ISTI

                            </option>

                        </select>

                    </div>

                    {{-- Department --}}
                    <div>

                        <label class="font-semibold text-gray-700">
                            Department *
                        </label>

                        <select name="department"
                                class="w-full border border-gray-300 rounded-lg p-3 mt-2 focus:ring-2 focus:ring-[#3db5ff] focus:outline-none"
                                required>

                            <option value="">Select Department</option>

                            <option value="Operational ISTI"
                                {{ old('department') == 'Operational ISTI' ? 'selected' : '' }}>

                                Operational ISTI

                            </option>

                            <option value="Operational FSI"
                                {{ old('department') == 'Operational FSI' ? 'selected' : '' }}>

                                Operational FSI

                            </option>

                            <option value="Sales & Marketing"
                                {{ old('department') == 'Sales & Marketing' ? 'selected' : '' }}>

                                Sales & Marketing

                            </option>

                            <option value="Finance, Accounting, and Tax"
                                {{ old('department') == 'Finance, Accounting, and Tax' ? 'selected' : '' }}>

                                Finance, Accounting, and Tax

                            </option>

                            <option value="Technology"
                                {{ old('department') == 'Technology' ? 'selected' : '' }}>

                                Technology

                            </option>

                            <option value="Management"
                                {{ old('department') == 'Management' ? 'selected' : '' }}>

                                Management

                            </option>

                            <option value="Chief"
                                {{ old('department') == 'Chief' ? 'selected' : '' }}>

                                Chief

                            </option>

                            <option value="Business Development"
                                {{ old('department') == 'Business Development' ? 'selected' : '' }}>

                                Business Development

                            </option>

                            <option value="HRGA"
                                {{ old('department') == 'HRGA' ? 'selected' : '' }}>

                                HRGA

                            </option>

                        </select>

                    </div>

                    {{-- Position --}}
                    <div>

                        <label class="font-semibold text-gray-700">
                            Position *
                        </label>

                        <select name="position"
                                class="w-full border border-gray-300 rounded-lg p-3 mt-2 focus:ring-2 focus:ring-[#3db5ff] focus:outline-none"
                                required>

                            <option value="">Select Position</option>

                            <option value="Chief Operating Officer"
                                {{ old('position') == 'Chief Operating Officer' ? 'selected' : '' }}>

                                Chief Operating Officer

                            </option>

                            <option value="Chief Sales & Marketing"
                                {{ old('position') == 'Chief Sales & Marketing' ? 'selected' : '' }}>

                                Chief Sales & Marketing

                            </option>

                            <option value="Head of Operation"
                                {{ old('position') == 'Head of Operation' ? 'selected' : '' }}>

                                Head of Operation

                            </option>

                            <option value="HRGA Staff"
                                {{ old('position') == 'HRGA Staff' ? 'selected' : '' }}>

                                HRGA Staff

                            </option>

                            <option value="IT Engineer Staff"
                                {{ old('position') == 'IT Engineer Staff' ? 'selected' : '' }}>

                                IT Engineer Staff

                            </option>

                            <option value="Sales Staff"
                                {{ old('position') == 'Sales Staff' ? 'selected' : '' }}>

                                Sales Staff

                            </option>

                            <option value="Quality Assurance Engineer Staff"
                                {{ old('position') == 'Quality Assurance Engineer Staff' ? 'selected' : '' }}>

                                Quality Assurance Engineer Staff

                            </option>

                            <option value="Warehouse & Admin Staff"
                                {{ old('position') == 'Warehouse & Admin Staff' ? 'selected' : '' }}>

                                Warehouse & Admin Staff

                            </option>

                            <option value="Office Boy"
                                {{ old('position') == 'Office Boy' ? 'selected' : '' }}>

                                Office Boy

                            </option>

                        </select>

                    </div>

                    {{-- Status --}}
                    <div>

                        <label class="font-semibold text-gray-700">
                            Employee Status *
                        </label>

                        <select name="status"
                                class="w-full border border-gray-300 rounded-lg p-3 mt-2 focus:ring-2 focus:ring-[#3db5ff] focus:outline-none"
                                required>

                            <option value="">Select Status</option>

                            <option value="Permanent"
                                {{ old('status') == 'Permanent' ? 'selected' : '' }}>

                                Permanent

                            </option>

                            <option value="Contract"
                                {{ old('status') == 'Contract' ? 'selected' : '' }}>

                                Contract

                            </option>

                        </select>

                    </div>

                </div>

            </div>

            {{-- ================= IDENTITY INFORMATION ================= --}}
            <div class="mb-10">

                <div class="flex items-center mb-5">

                    <div class="w-2 h-8 bg-green-500 rounded mr-3"></div>

                    <div>

                        <h3 class="text-xl font-bold text-gray-800">
                            Identity Information
                        </h3>

                        <p class="text-sm text-gray-500">
                            Employee personal identity information
                        </p>

                    </div>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>

                        <label class="font-semibold text-gray-700">
                            Pendidikan
                        </label>

                        <input type="text"
                               name="pendidikan"
                               value="{{ old('pendidikan') }}"
                               class="w-full border border-gray-300 rounded-lg p-3 mt-2">

                    </div>

                    <div>

                        <label class="font-semibold text-gray-700">
                            Jurusan
                        </label>

                        <input type="text"
                               name="jurusan"
                               value="{{ old('jurusan') }}"
                               class="w-full border border-gray-300 rounded-lg p-3 mt-2">

                    </div>

                    <div>

                        <label class="font-semibold text-gray-700">
                            KTP Number
                        </label>

                        <input type="text"
                               name="ktp"
                               value="{{ old('ktp') }}"
                               class="w-full border border-gray-300 rounded-lg p-3 mt-2">

                    </div>

                    <div>

                        <label class="font-semibold text-gray-700">
                            KK Number
                        </label>

                        <input type="text"
                               name="kk"
                               value="{{ old('kk') }}"
                               class="w-full border border-gray-300 rounded-lg p-3 mt-2">

                    </div>

                    <div>

                        <label class="font-semibold text-gray-700">
                            Phone Number
                        </label>

                        <input type="text"
                               name="no_hp"
                               value="{{ old('no_hp') }}"
                               class="w-full border border-gray-300 rounded-lg p-3 mt-2">

                    </div>

                    <div>

                        <label class="font-semibold text-gray-700">
                            Family Phone Number
                        </label>

                        <input type="text"
                               name="no_hp_keluarga"
                               value="{{ old('no_hp_keluarga') }}"
                               class="w-full border border-gray-300 rounded-lg p-3 mt-2">

                    </div>

                    <div>

                        <label class="font-semibold text-gray-700">
                            Religion
                        </label>

                        <input type="text"
                               name="agama"
                               value="{{ old('agama') }}"
                               class="w-full border border-gray-300 rounded-lg p-3 mt-2">

                    </div>

                    <div>

                        <label class="font-semibold text-gray-700">
                            Birth Place & Date
                        </label>

                        <input type="text"
                               name="tempat_tanggal_lahir"
                               value="{{ old('tempat_tanggal_lahir') }}"
                               class="w-full border border-gray-300 rounded-lg p-3 mt-2"
                               placeholder="Yogyakarta, 12 January 2000">

                    </div>

                    {{-- Gender --}}
                    <div>

                        <label class="font-semibold text-gray-700">
                            Gender
                        </label>

                        <select name="jenis_kelamin"
                                class="w-full border border-gray-300 rounded-lg p-3 mt-2">

                            <option value="">Select Gender</option>

                            <option value="Laki-laki"
                                {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>

                                Laki-laki

                            </option>

                            <option value="Perempuan"
                                {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>

                                Perempuan

                            </option>

                        </select>

                    </div>

                    {{-- Marital --}}
                    <div>

                        <label class="font-semibold text-gray-700">
                            Marital Status
                        </label>

                        <select name="status_perkawinan"
                                class="w-full border border-gray-300 rounded-lg p-3 mt-2">

                            <option value="">Select Status</option>

                            <option value="Belum Menikah"
                                {{ old('status_perkawinan') == 'Belum Menikah' ? 'selected' : '' }}>

                                Belum Menikah

                            </option>

                            <option value="Menikah"
                                {{ old('status_perkawinan') == 'Menikah' ? 'selected' : '' }}>

                                Menikah

                            </option>

                        </select>

                    </div>

                    <div>

                        <label class="font-semibold text-gray-700">
                            Age
                        </label>

                        <input type="number"
                               name="umur"
                               min="0"
                               value="{{ old('umur') }}"
                               class="w-full border border-gray-300 rounded-lg p-3 mt-2">

                    </div>

                    <div class="md:col-span-2">

                        <label class="font-semibold text-gray-700">
                            KTP Address
                        </label>

                        <textarea name="alamat_ktp"
                                  rows="3"
                                  class="w-full border border-gray-300 rounded-lg p-3 mt-2">{{ old('alamat_ktp') }}</textarea>

                    </div>

                    <div class="md:col-span-2">

                        <label class="font-semibold text-gray-700">
                            Current Address
                        </label>

                        <textarea name="alamat_tempat_tinggal"
                                  rows="3"
                                  class="w-full border border-gray-300 rounded-lg p-3 mt-2">{{ old('alamat_tempat_tinggal') }}</textarea>

                    </div>

                </div>

            </div>

            {{-- ================= DETAIL INFORMATION ================= --}}
            <div class="mb-10">

                <div class="flex items-center mb-5">

                    <div class="w-2 h-8 bg-orange-500 rounded mr-3"></div>

                    <div>

                        <h3 class="text-xl font-bold text-gray-800">
                            Detail Information
                        </h3>

                        <p class="text-sm text-gray-500">
                            Payroll and bank information
                        </p>

                    </div>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>
                        <label class="font-semibold text-gray-700">
                            BPJS Ketenagakerjaan
                        </label>

                        <input type="text"
                               name="bpjs_ketenagakerjaan"
                               value="{{ old('bpjs_ketenagakerjaan') }}"
                               class="w-full border border-gray-300 rounded-lg p-3 mt-2">
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700">
                            No KPJ
                        </label>

                        <input type="text"
                               name="no_kpj"
                               value="{{ old('no_kpj') }}"
                               class="w-full border border-gray-300 rounded-lg p-3 mt-2">
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700">
                            BPJS Kesehatan
                        </label>

                        <input type="text"
                               name="bpjs_kesehatan"
                               value="{{ old('bpjs_kesehatan') }}"
                               class="w-full border border-gray-300 rounded-lg p-3 mt-2">
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700">
                            NPWP
                        </label>

                        <input type="text"
                               name="npwp"
                               value="{{ old('npwp') }}"
                               class="w-full border border-gray-300 rounded-lg p-3 mt-2">
                    </div>

                    {{-- Bank --}}
                    <div>

                        <label class="font-semibold text-gray-700">
                            Nama Bank
                        </label>

                        <select name="nama_bank"
                                class="w-full border border-gray-300 rounded-lg p-3 mt-2">

                            <option value="">Select Bank</option>

                            <option value="Bank Mandiri"
                                {{ old('nama_bank') == 'Bank Mandiri' ? 'selected' : '' }}>

                                Bank Mandiri

                            </option>

                            <option value="BRI"
                                {{ old('nama_bank') == 'BRI' ? 'selected' : '' }}>

                                BRI

                            </option>

                            <option value="BNI"
                                {{ old('nama_bank') == 'BNI' ? 'selected' : '' }}>

                                BNI

                            </option>

                            <option value="BTN"
                                {{ old('nama_bank') == 'BTN' ? 'selected' : '' }}>

                                BTN

                            </option>

                            <option value="BCA"
                                {{ old('nama_bank') == 'BCA' ? 'selected' : '' }}>

                                BCA

                            </option>

                            <option value="BSI"
                                {{ old('nama_bank') == 'BSI' ? 'selected' : '' }}>

                                BSI

                            </option>

                        </select>

                    </div>

                    <div>

                        <label class="font-semibold text-gray-700">
                            No Rekening
                        </label>

                        <input type="text"
                               name="no_rekening"
                               value="{{ old('no_rekening') }}"
                               class="w-full border border-gray-300 rounded-lg p-3 mt-2">

                    </div>

                    {{-- Base Salary --}}
<div>

    <label class="font-semibold text-gray-700">
        Base Salary
    </label>

    <input type="text"
           name="gaji_pokok"
           value="{{ old('gaji_pokok') }}"
           class="currency-input w-full border border-gray-300 rounded-lg p-3 mt-2"
           >

</div>

{{-- Position Allowance --}}
<div>

    <label class="font-semibold text-gray-700">
        Position Allowance
    </label>

    <input type="text"
           name="tunjangan_jabatan"
           value="{{ old('tunjangan_jabatan') }}"
           class="currency-input w-full border border-gray-300 rounded-lg p-3 mt-2"
          >

</div>

{{-- Meal Allowance --}}
<div>

    <label class="font-semibold text-gray-700">
        Meal Allowance
    </label>

    <input type="text"
           name="tunjangan_makan"
           value="{{ old('tunjangan_makan') }}"
           class="currency-input w-full border border-gray-300 rounded-lg p-3 mt-2"
          >

</div>

{{-- Transport Allowance --}}
<div>

    <label class="font-semibold text-gray-700">
        Transport Allowance
    </label>

    <input type="text"
           name="tunjangan_transport"
           value="{{ old('tunjangan_transport') }}"
           class="currency-input w-full border border-gray-300 rounded-lg p-3 mt-2"
          >

</div>

                </div>

            </div>

            {{-- BUTTON --}}
            <div class="flex justify-end">

                <button type="submit"
                        class="px-8 py-3 bg-[#3db5ff] hover:bg-[#2da3eb] text-white rounded-xl font-semibold transition duration-200 shadow-md">

                    Save Employee

                </button>

            </div>

        </form>

    </div>

</div>
<script>

    document.querySelectorAll('.currency-input').forEach(input =>
    {
        input.addEventListener('input', function(e)
        {
            let value = this.value.replace(/\D/g, '');

            this.value = new Intl.NumberFormat('id-ID').format(value);
        });
    });

</script>

@endsection
