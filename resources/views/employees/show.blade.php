@extends('layouts.app')

@section('title', 'Employee Detail | PT Inovasi Solusi Transportasi Indonesia')

@section('content')

@php
    $identity = $employee->identity;
    $detail = $employee->identityDetail;

    $gajiPokok = (int) ($detail->gaji_pokok ?? 0);
    $tunjanganJabatan = (int) ($detail->tunjangan_jabatan ?? 0);
    $tunjanganMakan = (int) ($detail->tunjangan_makan ?? 0);
    $tunjanganTransport = (int) ($detail->tunjangan_transport ?? 0);

    $totalSalary = $gajiPokok + $tunjanganJabatan + $tunjanganMakan + $tunjanganTransport;

    // FORMAT RUPIAH
    $formatRupiah = fn($value) => 'Rp ' . number_format($value, 0, ',', '.');
@endphp

<div class="container mx-auto p-6">

    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ url()->previous() }}"
            class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg font-medium transition">
            ← Back
        </a>
    </div>

    <div class="bg-white shadow-lg rounded-2xl overflow-hidden">

        {{-- Header Profile --}}
        <div class="bg-[#3db5ff] px-6 md:px-8 py-6 text-white">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

                <div class="flex items-center gap-5">
                    <div class="w-20 h-20 md:w-24 md:h-24 rounded-full bg-white/20 flex items-center justify-center overflow-hidden border border-white/30">
                        @if(!empty($employee->photo))
                            <img src="{{ asset('storage/' . $employee->photo) }}"
                                alt="Profile Photo"
                                class="w-full h-full object-cover">
                        @else
                            <span class="text-3xl md:text-4xl font-bold">
                                {{ strtoupper(substr($employee->name ?? 'E', 0, 1)) }}
                            </span>
                        @endif
                    </div>

                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold">
                            {{ $employee->name }}
                        </h1>
                        <p class="text-blue-100 mt-1">
                            Employee ID: {{ $employee->employee_id }}
                        </p>
                        <p class="text-blue-100">
                            {{ $employee->branch }} • {{ $employee->department }} • {{ $employee->position }}
                        </p>
                    </div>
                </div>

                <div>
                    @if(($employee->employee_condition ?? 'Active') === 'Active')
                        <span class="px-4 py-2 rounded-full bg-green-100 text-green-700 text-sm font-semibold">
                            Active
                        </span>
                    @else
                        <span class="px-4 py-2 rounded-full bg-red-100 text-red-700 text-sm font-semibold">
                            Resigned
                        </span>
                    @endif
                </div>

            </div>
        </div>

        <div class="p-6 md:p-8">

            {{-- Tabs --}}
            <div class="flex gap-2 border-b border-gray-200 mb-6">
                <button id="employmentTabBtn"
                    type="button"
                    onclick="openTab('employment')"
                    class="px-4 py-2 font-semibold border-b-4 border-[#3db5ff] text-[#3db5ff] -mb-px transition">
                    Employment & Salary
                </button>

                <button id="personalTabBtn"
                    type="button"
                    onclick="openTab('personal')"
                    class="px-4 py-2 font-semibold border-b-4 border-transparent text-gray-600 -mb-px transition">
                    Personal Info
                </button>
            </div>

            {{-- TAB 1: EMPLOYMENT --}}
            <div id="employmentTab" class="space-y-6">

                {{-- Employment Info --}}
                <form id="employeeForm"
                    action="{{ route('employee.updateMain', $employee->id) }}"
                    method="POST"
                    class="editable-form bg-gray-50 border border-gray-200 rounded-2xl p-6">
                    @csrf
                    @method('PUT')

                    <div class="flex items-center justify-between gap-4 mb-5">
                        <h2 class="text-lg font-bold text-gray-800">
                            Employment Info
                        </h2>

                        <button type="button"
                            class="js-edit-btn px-4 py-2 rounded-lg bg-[#3db5ff] text-white font-semibold hover:bg-[#33a0e0] transition"
                            data-form="employeeForm">
                            Edit
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Employee ID</label>
                            <input type="text" name="employee_id" value="{{ old('employee_id', $employee->employee_id) }}"
                                disabled
                                class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 focus:ring-2 focus:ring-[#3db5ff] focus:border-[#3db5ff] disabled:opacity-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $employee->name) }}"
                                disabled
                                class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 focus:ring-2 focus:ring-[#3db5ff] focus:border-[#3db5ff] disabled:opacity-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email', $employee->email) }}"
                                disabled
                                class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 focus:ring-2 focus:ring-[#3db5ff] focus:border-[#3db5ff] disabled:opacity-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Company</label>
                            <input type="text" name="company" value="{{ old('company', $employee->company) }}"
                                disabled
                                class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 focus:ring-2 focus:ring-[#3db5ff] focus:border-[#3db5ff] disabled:opacity-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Branch</label>
                            <input type="text" name="branch" value="{{ old('branch', $employee->branch) }}"
                                disabled
                                class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 focus:ring-2 focus:ring-[#3db5ff] focus:border-[#3db5ff] disabled:opacity-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Department</label>
                            <input type="text" name="department" value="{{ old('department', $employee->department) }}"
                                disabled
                                class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 focus:ring-2 focus:ring-[#3db5ff] focus:border-[#3db5ff] disabled:opacity-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Position</label>
                            <input type="text" name="position" value="{{ old('position', $employee->position) }}"
                                disabled
                                class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 focus:ring-2 focus:ring-[#3db5ff] focus:border-[#3db5ff] disabled:opacity-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Employment Status</label>
                            <input type="text" name="status" value="{{ old('status', $employee->status) }}"
                                disabled
                                class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 focus:ring-2 focus:ring-[#3db5ff] focus:border-[#3db5ff] disabled:opacity-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Employee Condition</label>
                            <input type="text" name="employee_condition" value="{{ old('employee_condition', $employee->employee_condition) }}"
                                disabled
                                class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 focus:ring-2 focus:ring-[#3db5ff] focus:border-[#3db5ff] disabled:opacity-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Join Date</label>
                            <input type="date" name="date_of_joining"
                                value="{{ old('date_of_joining', $employee->date_of_joining ? \Carbon\Carbon::parse($employee->date_of_joining)->format('Y-m-d') : '') }}"
                                disabled
                                class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 focus:ring-2 focus:ring-[#3db5ff] focus:border-[#3db5ff] disabled:opacity-100">
                        </div>

                    </div>
                </form>

                {{-- Salary Info --}}
                
               <form id="salaryForm"
    action="{{ route('employee.updateIdentityDetail', $employee->id) }}"
    method="POST"
    class="editable-form bg-gray-50 border border-gray-200 rounded-2xl p-6">
    @csrf
    @method('PUT')

    <div class="flex items-center justify-between gap-4 mb-5">
        <h2 class="text-lg font-bold text-gray-800">
            Salary Info
        </h2>

        <button type="button"
            class="js-edit-btn px-4 py-2 rounded-lg bg-[#3db5ff] text-white font-semibold hover:bg-[#33a0e0] transition"
            data-form="salaryForm">
            Edit
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

        {{-- Gaji Pokok --}}
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Gaji Pokok</label>

            <input type="text"
                class="salary-format w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2"
                value="{{ number_format($detail->gaji_pokok ?? 0, 0, ',', '.') }}"
                disabled>

            <input type="hidden" name="gaji_pokok"
                value="{{ $detail->gaji_pokok ?? 0 }}">
        </div>

        {{-- Tunjangan Jabatan --}}
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Tunjangan Jabatan</label>

            <input type="text"
                class="salary-format w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2"
                value="{{ number_format($detail->tunjangan_jabatan ?? 0, 0, ',', '.') }}"
                disabled>

            <input type="hidden" name="tunjangan_jabatan"
                value="{{ $detail->tunjangan_jabatan ?? 0 }}">
        </div>

        {{-- Tunjangan Makan --}}
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Tunjangan Makan</label>

            <input type="text"
                class="salary-format w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2"
                value="{{ number_format($detail->tunjangan_makan ?? 0, 0, ',', '.') }}"
                disabled>

            <input type="hidden" name="tunjangan_makan"
                value="{{ $detail->tunjangan_makan ?? 0 }}">
        </div>

        {{-- Tunjangan Transport --}}
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Tunjangan Transport</label>

            <input type="text"
                class="salary-format w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2"
                value="{{ number_format($detail->tunjangan_transport ?? 0, 0, ',', '.') }}"
                disabled>

            <input type="hidden" name="tunjangan_transport"
                value="{{ $detail->tunjangan_transport ?? 0 }}">
        </div>

        {{-- Total --}}
        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Total Salary</label>

            <input type="text"
                value="Rp {{ number_format($totalSalary, 0, ',', '.') }}"
                disabled
                class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 font-semibold text-gray-800">
        </div>

    </div>
</form>

            </div>

            {{-- TAB 2: PERSONAL INFO --}}
            <div id="personalTab" class="space-y-6 hidden">

                {{-- Basic Info --}}
                <form id="identityForm"
                    action="{{ route('employee.updateIdentity', $employee->id) }}"
                    method="POST"
                    class="editable-form bg-gray-50 border border-gray-200 rounded-2xl p-6">
                    @csrf
                    @method('PUT')

                    <div class="flex items-center justify-between gap-4 mb-5">
                        <h2 class="text-lg font-bold text-gray-800">
                            Basic Info
                        </h2>

                        <button type="button"
                            class="js-edit-btn px-4 py-2 rounded-lg bg-[#3db5ff] text-white font-semibold hover:bg-[#33a0e0] transition"
                            data-form="identityForm">
                            Edit
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Pendidikan</label>
                            <input type="text" name="pendidikan" value="{{ old('pendidikan', $identity->pendidikan ?? '') }}"
                                disabled
                                class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 focus:ring-2 focus:ring-[#3db5ff] focus:border-[#3db5ff] disabled:opacity-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Jurusan</label>
                            <input type="text" name="jurusan" value="{{ old('jurusan', $identity->jurusan ?? '') }}"
                                disabled
                                class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 focus:ring-2 focus:ring-[#3db5ff] focus:border-[#3db5ff] disabled:opacity-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">KTP</label>
                            <input type="text" name="ktp" value="{{ old('ktp', $identity->ktp ?? '') }}"
                                disabled
                                class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 focus:ring-2 focus:ring-[#3db5ff] focus:border-[#3db5ff] disabled:opacity-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">KK</label>
                            <input type="text" name="kk" value="{{ old('kk', $identity->kk ?? '') }}"
                                disabled
                                class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 focus:ring-2 focus:ring-[#3db5ff] focus:border-[#3db5ff] disabled:opacity-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Agama</label>
                            <input type="text" name="agama" value="{{ old('agama', $identity->agama ?? '') }}"
                                disabled
                                class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 focus:ring-2 focus:ring-[#3db5ff] focus:border-[#3db5ff] disabled:opacity-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Tempat Tanggal Lahir</label>
                            <input type="text" name="tempat_tanggal_lahir" value="{{ old('tempat_tanggal_lahir', $identity->tempat_tanggal_lahir ?? '') }}"
                                disabled
                                class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 focus:ring-2 focus:ring-[#3db5ff] focus:border-[#3db5ff] disabled:opacity-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Status Perkawinan</label>
                            <input type="text" name="status_perkawinan" value="{{ old('status_perkawinan', $identity->status_perkawinan ?? '') }}"
                                disabled
                                class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 focus:ring-2 focus:ring-[#3db5ff] focus:border-[#3db5ff] disabled:opacity-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Jenis Kelamin</label>
                            <input type="text" name="jenis_kelamin" value="{{ old('jenis_kelamin', $identity->jenis_kelamin ?? '') }}"
                                disabled
                                class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 focus:ring-2 focus:ring-[#3db5ff] focus:border-[#3db5ff] disabled:opacity-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Umur</label>
                            <input type="number" name="umur" value="{{ old('umur', $identity->umur ?? '') }}"
                                disabled
                                class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 focus:ring-2 focus:ring-[#3db5ff] focus:border-[#3db5ff] disabled:opacity-100">
                        </div>

                    </div>

                    <div class="mt-5">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Alamat KTP</label>
                        <textarea name="alamat_ktp" rows="3"
                            disabled
                            class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 focus:ring-2 focus:ring-[#3db5ff] focus:border-[#3db5ff] disabled:opacity-100">{{ old('alamat_ktp', $identity->alamat_ktp ?? '') }}</textarea>
                    </div>

                    <div class="mt-5">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Alamat Tempat Tinggal</label>
                        <textarea name="alamat_tempat_tinggal" rows="3"
                            disabled
                            class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 focus:ring-2 focus:ring-[#3db5ff] focus:border-[#3db5ff] disabled:opacity-100">{{ old('alamat_tempat_tinggal', $identity->alamat_tempat_tinggal ?? '') }}</textarea>
                    </div>
                </form>

                {{-- Contact Info --}}
                <form id="contactForm"
                    action="{{ route('employee.updateIdentity', $employee->id) }}"
                    method="POST"
                    class="editable-form bg-gray-50 border border-gray-200 rounded-2xl p-6">
                    @csrf
                    @method('PUT')

                    <div class="flex items-center justify-between gap-4 mb-5">
                        <h2 class="text-lg font-bold text-gray-800">
                            Contact Info
                        </h2>

                        <button type="button"
                            class="js-edit-btn px-4 py-2 rounded-lg bg-[#3db5ff] text-white font-semibold hover:bg-[#33a0e0] transition"
                            data-form="contactForm">
                            Edit
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">No HP</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp', $identity->no_hp ?? '') }}"
                                disabled
                                class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 focus:ring-2 focus:ring-[#3db5ff] focus:border-[#3db5ff] disabled:opacity-100">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">No HP Keluarga</label>
                            <input type="text" name="no_hp_keluarga" value="{{ old('no_hp_keluarga', $identity->no_hp_keluarga ?? '') }}"
                                disabled
                                class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 focus:ring-2 focus:ring-[#3db5ff] focus:border-[#3db5ff] disabled:opacity-100">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-600 mb-1">Alamat Tempat Tinggal</label>
                            <textarea name="alamat_tempat_tinggal" rows="3"
                                disabled
                                class="w-full rounded-lg border border-gray-300 bg-gray-100 px-4 py-2 focus:ring-2 focus:ring-[#3db5ff] focus:border-[#3db5ff] disabled:opacity-100">{{ old('alamat_tempat_tinggal', $identity->alamat_tempat_tinggal ?? '') }}</textarea>
                        </div>

                    </div>
                </form>

            </div>

        </div>
    </div>
</div>

<script>
    function openTab(tab) {
        const employmentTab = document.getElementById('employmentTab');
        const personalTab = document.getElementById('personalTab');
        const employmentTabBtn = document.getElementById('employmentTabBtn');
        const personalTabBtn = document.getElementById('personalTabBtn');

        const activeClass = 'px-4 py-2 font-semibold border-b-4 border-[#3db5ff] text-[#3db5ff] -mb-px transition';
        const inactiveClass = 'px-4 py-2 font-semibold border-b-4 border-transparent text-gray-600 -mb-px transition';

        if (tab === 'employment') {
            employmentTab.classList.remove('hidden');
            personalTab.classList.add('hidden');
            employmentTabBtn.className = activeClass;
            personalTabBtn.className = inactiveClass;
        } else {
            employmentTab.classList.add('hidden');
            personalTab.classList.remove('hidden');
            personalTabBtn.className = activeClass;
            employmentTabBtn.className = inactiveClass;
        }
    }

    function formatRupiah(angka) {
        return angka.replace(/\D/g, '')
            .replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function unformatRupiah(angka) {
        return angka.replace(/\./g, '');
    }

    function initSalaryFormat(form) {
        const inputs = form.querySelectorAll('.salary-format');

        inputs.forEach(input => {
            input.addEventListener('input', function () {
                let raw = unformatRupiah(this.value);
                this.value = formatRupiah(raw);

                const hidden = this.parentElement.querySelector('input[type="hidden"]');
                if (hidden) hidden.value = raw;
            });
        });
    }

    function setFormEditable(form, editable) {
        const fields = form.querySelectorAll('input, textarea, select');

        fields.forEach(field => {
            // ❗ jangan disable hidden input
            if (field.type === 'hidden') return;

            field.disabled = !editable;

            if (editable) {
                field.classList.remove('bg-gray-100');
                field.classList.add('bg-white');
            } else {
                field.classList.add('bg-gray-100');
                field.classList.remove('bg-white');
            }
        });

        form.dataset.editing = editable ? '1' : '0';

        const btn = form.querySelector('.js-edit-btn');
        if (btn) {
            btn.textContent = editable ? 'Save' : 'Edit';
        }

        // aktifkan formatter hanya saat edit
        if (editable) {
            initSalaryFormat(form);
        }
    }

    document.querySelectorAll('.js-edit-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const form = document.getElementById(this.dataset.form);
            const editing = form.dataset.editing === '1';

            if (!editing) {
                setFormEditable(form, true);
            } else {
                form.submit();
            }
        });
    });

    document.querySelectorAll('.editable-form').forEach(form => {
        form.dataset.editing = '0';
        setFormEditable(form, false);
    });

    openTab('employment');
</script>

@endsection