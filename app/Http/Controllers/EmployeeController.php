<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Identity;
use App\Models\IdentityDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Semua employee
     */
    public function index()
    {
        $employees = Employee::with([
            'identity',
            'identityDetail',
            'pkwts'
        ])->latest()->get();

        return view('employees.index', compact('employees'));
    }

    /**
     * Halaman FSI
     */
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

    /**
     * Halaman ISTI
     */
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

    /**
     * Form create employee
     */
    public function create(Request $request)
    {
        $branch = $request->query('branch');

        return view('employees.create', compact('branch'));
    }

    /**
     * Simpan employee + identities + identities_detail
     */
    public function store(Request $request)
    {
        $request->validate([

            /*
            |--------------------------------------------------------------------------
            | EMPLOYEES
            |--------------------------------------------------------------------------
            */

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

            /*
            |--------------------------------------------------------------------------
            | SAVE EMPLOYEE
            |--------------------------------------------------------------------------
            */

            $employee = Employee::create([

                'employee_id'        => $request->employee_id,
                'name'               => $request->name,
                'email'              => $request->email,
                'company'            => 'PT Inovasi Solusi Transportasi Indonesia',
                'branch'             => $request->branch,
                'status'             => $request->status,
                'employee_condition' => 'Active',
                'position'           => $request->position,
                'department'         => $request->department,
                'date_of_joining'    => $request->date_of_joining,

            ]);

            /*
            |--------------------------------------------------------------------------
            | SAVE IDENTITIES
            |--------------------------------------------------------------------------
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

            /*
            |--------------------------------------------------------------------------
            | SAVE IDENTITIES DETAIL
            |--------------------------------------------------------------------------
            */

            IdentityDetail::create([

                'employee_id'          => $employee->id,

                'bpjs_ketenagakerjaan' => $request->bpjs_ketenagakerjaan,
                'no_kpj'               => $request->no_kpj,
                'bpjs_kesehatan'       => $request->bpjs_kesehatan,
                'npwp'                 => $request->npwp,
                'nama_bank'            => $request->nama_bank,
                'no_rekening'          => $request->no_rekening,
                'gaji_pokok' => str_replace('.', '', $request->gaji_pokok),

'tunjangan_jabatan' => str_replace('.', '', $request->tunjangan_jabatan),

'tunjangan_makan' => str_replace('.', '', $request->tunjangan_makan),

'tunjangan_transport' => str_replace('.', '', $request->tunjangan_transport),

            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        if ($request->branch == 'FSI') {

            return redirect()
                ->route('employee.fsi')
                ->with('success', 'Employee created successfully');
        }

        return redirect()
            ->route('employee.isti')
            ->with('success', 'Employee created successfully');
    }

    /**
     * Form edit
     */
    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update employee
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([

            'employee_id'     => 'required|unique:employees,employee_id,' . $employee->id,
            'name'            => 'required',
            'email'           => 'required|email|unique:employees,email,' . $employee->id,
            'position'        => 'required',
            'department'      => 'required',
            'date_of_joining' => 'required|date',
            'branch'          => 'required',
            'status'          => 'required',

        ]);

        $employee->update([

            'employee_id'        => $request->employee_id,
            'name'               => $request->name,
            'email'              => $request->email,
            'position'           => $request->position,
            'department'         => $request->department,
            'date_of_joining'    => $request->date_of_joining,
            'branch'             => $request->branch,
            'status'             => $request->status,
            'employee_condition' => $request->employee_condition,

        ]);

        if ($employee->branch == 'FSI') {

            return redirect()
                ->route('employee.fsi')
                ->with('success', 'Employee updated successfully');
        }

        return redirect()
            ->route('employee.isti')
            ->with('success', 'Employee updated successfully');
    }

    /**
     * Delete employee
     */
    public function destroy(Employee $employee)
    {
        Identity::where('employee_id', $employee->id)->delete();

        IdentityDetail::where('employee_id', $employee->id)->delete();

        $employee->delete();

        return redirect()->back()
            ->with('success', 'Employee deleted successfully');
    }

    /**
     * Resign employee
     */
    public function resign(Employee $employee)
    {
        $employee->update([

            'employee_condition' => 'Resigned'

        ]);

        return redirect()->back()
            ->with('success', 'Employee resigned successfully');
    }

    /**
     * Show employee detail
     */
    public function show($id)
    {
        $employee = Employee::with([
            'identity',
            'identityDetail',
            'pkwts'
        ])->findOrFail($id);

        $identity = $employee->identity;

        $identityDetail = $employee->identityDetail;

        return view('employees.show', compact(
            'employee',
            'identity',
            'identityDetail'
        ));
    }

    /**
     * Update main employee
     */
    public function updateMain(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $employee->update([

            'employee_id'        => $request->employee_id,
            'name'               => $request->name,
            'email'              => $request->email,
            'company'            => $request->company,
            'branch'             => $request->branch,
            'status'             => $request->status,
            'employee_condition' => $request->employee_condition,
            'position'           => $request->position,
            'department'         => $request->department,
            'date_of_joining'    => $request->date_of_joining,

        ]);

        return back()->with(
            'success',
            'Employee updated successfully'
        );
    }

    /**
     * Update identity detail
     */
    public function updateIdentityDetail(Request $request, $id)
    {
        IdentityDetail::updateOrCreate(

            ['employee_id' => $id],

            [

                'bpjs_ketenagakerjaan' => $request->bpjs_ketenagakerjaan,
                'no_kpj'               => $request->no_kpj,
                'bpjs_kesehatan'       => $request->bpjs_kesehatan,
                'npwp'                 => $request->npwp,
                'nama_bank'            => $request->nama_bank,
                'no_rekening'          => $request->no_rekening,
                'gaji_pokok'           => $request->gaji_pokok,
                'tunjangan_jabatan'    => $request->tunjangan_jabatan,
                'tunjangan_makan'      => $request->tunjangan_makan,
                'tunjangan_transport'  => $request->tunjangan_transport,

            ]
        );

        return back()->with(
            'success',
            'Identity detail updated successfully'
        );
    }

    /**
     * Update identity
     */
    public function updateIdentity(Request $request, $id)
    {
        Identity::updateOrCreate(

            ['employee_id' => $id],

            [

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

            ]
        );

        return back()->with(
            'success',
            'Identity updated successfully'
        );
    }
}