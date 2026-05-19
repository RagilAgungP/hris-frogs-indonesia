<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Identity;
use App\Models\IdentityDetail;
use Illuminate\Http\Request;

class SeeDetailController extends Controller
{
    /**
     * SHOW DETAIL
     */
    public function show($id)
    {
        $employee = Employee::with(['identity', 'identityDetail'])
            ->findOrFail($id);

        return view('employees.show', compact('employee'));
    }

    /**
     * UPDATE EMPLOYEE (termasuk salary ONLY number)
     */
    public function updateEmployee(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $validated = $request->validate([
            'employee_id' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'company' => 'nullable',
            'branch' => 'required',
            'department' => 'required',
            'position' => 'required',
            'status' => 'required',
            'employee_condition' => 'nullable',
            'date_of_joining' => 'nullable|date',

            // FIX SALARY (ONLY MONEY)
            'salary' => 'nullable|numeric|min:0',
        ]);

        $employee->update($validated);

        return back()->with('success', 'Employee updated successfully');
    }

    /**
     * UPDATE IDENTITY (PERSONAL INFO)
     */
    public function updateIdentity(Request $request, $id)
    {
        $validated = $request->validate([
            'pendidikan' => 'nullable',
            'jurusan' => 'nullable',
            'ktp' => 'nullable',
            'kk' => 'nullable',
            'agama' => 'nullable',
            'tempat_tanggal_lahir' => 'nullable',
            'status_perkawinan' => 'nullable',
            'jenis_kelamin' => 'nullable',
            'umur' => 'nullable|integer',
            'alamat_ktp' => 'nullable',
            'alamat_tempat_tinggal' => 'nullable',
            'no_hp' => 'nullable',
            'no_hp_keluarga' => 'nullable',
        ]);

        Identity::updateOrCreate(
            ['employee_id' => $id],
            $validated
        );

        return back()->with('success', 'Identity updated successfully');
    }

    /**
     * UPDATE CONTACT DETAIL
     */
    public function updateIdentityDetail(Request $request, $id)
    {
        $validated = $request->validate([
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'emergency_name' => 'nullable',
            'emergency_phone' => 'nullable',
            'address' => 'nullable',
            'city' => 'nullable',
            'province' => 'nullable',
            'postal_code' => 'nullable',
        ]);

        IdentityDetail::updateOrCreate(
            ['employee_id' => $id],
            $validated
        );

        return back()->with('success', 'Contact updated successfully');
    }


 
    public function inlineUpdate(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $section = $request->section;

        // ================= EMPLOYEE =================
        if ($section === 'employee') {
            $employee->update($request->only([
                'name',
                'email',
                'branch',
                'department',
                'position'
            ]));

            return response()->json([
                'status' => 'success',
                'message' => 'Employee updated'
            ]);
        }

        // ================= SALARY =================
        if ($section === 'salary') {
            $detail = IdentityDetail::updateOrCreate(
                ['employee_id' => $id],
                $request->only([
                    'gaji_pokok',
                    'tunjangan_jabatan',
                    'tunjangan_makan',
                    'tunjangan_transport'
                ])
            );

            $total =
                (int)$detail->gaji_pokok +
                (int)$detail->tunjangan_jabatan +
                (int)$detail->tunjangan_makan +
                (int)$detail->tunjangan_transport;

            return response()->json([
                'status' => 'success',
                'total' => $total
            ]);
        }

        // ================= IDENTITY =================
        if ($section === 'identity') {
            Identity::updateOrCreate(
                ['employee_id' => $id],
                $request->all()
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Identity updated'
            ]);
        }

        return response()->json(['status' => 'error'], 400);
    }
}
