<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Identity;
use App\Models\IdentityDetail;
use App\Models\Pkwt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with([
            'identity',
            'identityDetail',
            'pkwts'
        ])->latest()->get();

        return view('employees.index', compact('employees'));
    }

    public function fsi()
    {
        $employees = Employee::with([
            'identity',
            'identityDetail',
            'pkwts'
        ])
        ->where('branch', 'FSI')
        ->latest()
        ->get();

        return view('employees.fsi', compact('employees'));
    }

    public function isti()
    {
        $employees = Employee::with([
            'identity',
            'identityDetail',
            'pkwts'
        ])
        ->where('branch', 'ISTI')
        ->latest()
        ->get();

        return view('employees.isti', compact('employees'));
    }

    public function create(Request $request)
    {
        $branch = $request->query('branch');

        return view('employees.create', compact('branch'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id'     => 'required|unique:employees',
            'name'            => 'required',
            'email'           => 'required|email|unique:employees',
            'position'        => 'required',
            'department'      => 'required',
            'date_of_joining' => 'required|date',
            'branch'          => 'required',
            'status'          => 'required',
        ]);

        DB::transaction(function () use ($request) {

            /**
             * COMPANY MAPPING (INI FIX UTAMA)
             */
            $company = match ($request->branch) {
                'FSI'  => 'PT Frogs Solusi Indonesia',
                'ISTI' => 'PT Inovasi Solusi Transportasi Indonesia',
                default => null,
            };

            /**
             * CREATE EMPLOYEE
             */
            $employee = Employee::create([
                'employee_id'        => $request->employee_id,
                'name'               => $request->name,
                'email'              => $request->email,
                'company'            => $company,
                'branch'             => $request->branch,
                'status'             => $request->status,
                'employee_condition' => 'Active',
                'position'           => $request->position,
                'department'         => $request->department,
                'date_of_joining'    => $request->date_of_joining,
            ]);

            /**
             * CREATE PKWT (PAKAI COMPANY YANG SUDAH BENAR)
             */
            Pkwt::create([
                'employee_id'     => $employee->id,
                'contract_number' => null,
                'start_date'      => $employee->date_of_joining,
                'end_date'        => null,
                'company'         => $employee->company,
                'file_path'       => null,
            ]);

            /**
             * IDENTITY
             */
            Identity::create([
                'employee_id'           => $employee->id,
                'pendidikan'            => $request->pendidikan,
                'jurusan'               => $request->jurusan,
                'ktp'                   => $request->ktp,
                'kk'                    => $request->kk,
                'alamat_ktp'            => $request->alamat_ktp,
                'alamat_tempat_tinggal' => $request->alamat_tempat_tinggal,
                'no_hp'                 => $request->no_hp,
                'no_hp_keluarga'        => $request->no_hp_keluarga,
                'agama'                 => $request->agama,
                'tempat_tanggal_lahir'  => $request->tempat_tanggal_lahir,
                'status_perkawinan'     => $request->status_perkawinan,
                'jenis_kelamin'         => $request->jenis_kelamin,
                'umur'                  => $request->umur,
            ]);

            /**
             * IDENTITY DETAIL
             */
            IdentityDetail::create([
                'employee_id'          => $employee->id,
                'bpjs_ketenagakerjaan' => $request->bpjs_ketenagakerjaan,
                'no_kpj'               => $request->no_kpj,
                'bpjs_kesehatan'       => $request->bpjs_kesehatan,
                'npwp'                 => $request->npwp,
                'nama_bank'            => $request->nama_bank,
                'no_rekening'          => $request->no_rekening,
                'gaji_pokok'           => str_replace('.', '', $request->gaji_pokok),
                'tunjangan_jabatan'    => str_replace('.', '', $request->tunjangan_jabatan),
                'tunjangan_makan'      => str_replace('.', '', $request->tunjangan_makan),
                'tunjangan_transport'  => str_replace('.', '', $request->tunjangan_transport),
            ]);
        });

        return redirect()
            ->route($request->branch == 'FSI' ? 'employee.fsi' : 'employee.isti')
            ->with('success', 'Employee created successfully');
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'employee_id'     => 'required|unique:employees,employee_id,' . $employee->id,
            'name'            => 'required',
            'email'           => 'required|email',
            'position'        => 'required',
            'department'      => 'required',
            'date_of_joining' => 'required|date',
            'branch'          => 'required',
            'status'          => 'required',
        ]);

        $company = match ($request->branch) {
            'FSI'  => 'PT Frogs Solusi Indonesia',
            'ISTI' => 'PT Inovasi Solusi Transportasi Indonesia',
            default => null,
        };

        $employee->update([
            'employee_id'        => $request->employee_id,
            'name'               => $request->name,
            'email'              => $request->email,
            'company'            => $company,
            'position'           => $request->position,
            'department'         => $request->department,
            'date_of_joining'    => $request->date_of_joining,
            'branch'             => $request->branch,
            'status'             => $request->status,
            'employee_condition' => $request->employee_condition,
        ]);

        return redirect()
            ->route($employee->branch == 'FSI' ? 'employee.fsi' : 'employee.isti')
            ->with('success', 'Employee updated successfully');
    }

    public function destroy(Employee $employee)
    {
        Identity::where('employee_id', $employee->id)->delete();
        IdentityDetail::where('employee_id', $employee->id)->delete();

        $employee->delete();

        return back()->with('success', 'Employee deleted successfully');
    }

    public function resign(Employee $employee)
    {
        $employee->update([
            'employee_condition' => 'Resigned'
        ]);

        return back()->with('success', 'Employee resigned successfully');
    }

    public function show($id)
    {
        $employee = Employee::with([
            'identity',
            'identityDetail',
            'pkwts'
        ])->findOrFail($id);

        return view('employees.show', compact('employee'));
    }
}