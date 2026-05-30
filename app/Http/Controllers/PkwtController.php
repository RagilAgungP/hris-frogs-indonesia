<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Pkwt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PkwtController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX (BY BRANCH)
    |--------------------------------------------------------------------------
    */
    public function index($branch)
    {
        $branch = strtoupper($branch);

        $pkwts = Pkwt::with('employee')
            ->whereHas('employee', function ($query) use ($branch) {
                $query->where('branch', $branch);
            })
            ->latest()
            ->get();

        $employees = Employee::where('branch', $branch)
            ->orderBy('name')
            ->get();

        return view('pkwt.index', compact('pkwts', 'branch', 'employees'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE FORM
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $employees = Employee::orderBy('name')->get();

        return view('pkwt.create', compact('employees'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id'     => 'required|exists:employees,id',
            'contract_number' => 'nullable|string|max:255',
            'start_date'      => 'nullable|date',
            'end_date'        => 'nullable|date',
            'company'         => 'nullable|string|max:255',
            'file_path'       => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $employee = Employee::findOrFail($validated['employee_id']);

        $filePath = null;

        if ($request->hasFile('file_path')) {
            $filePath = $request->file('file_path')
                ->store('pkwt_files', 'public');
        }

        Pkwt::create([
            'employee_id'     => $validated['employee_id'],
            'contract_number' => $validated['contract_number'] ?? null,
            'start_date'      => $validated['start_date'],
            'end_date'        => $validated['end_date'],
            'company'         => $validated['company'] ?? null,
            'file_path'       => $filePath,
        ]);

        return redirect()
            ->route('pkwt.branch', strtolower($employee->branch))
            ->with('success', 'PKWT berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | JSON (FOR MODAL AJAX)
    |--------------------------------------------------------------------------
    */
    public function show(Pkwt $pkwt)
{
    $pkwt->load('employee');

    return response()->json([
        'id'              => $pkwt->id,
        'employee_id'     => $pkwt->employee_id,
        'employee_name'   => $pkwt->employee->name ?? '',
        'contract_number' => $pkwt->contract_number,
        'start_date'      => optional($pkwt->start_date)->format('Y-m-d'),
        'end_date'        => optional($pkwt->end_date)->format('Y-m-d'),
        'company'         => $pkwt->company,
    ]);
}

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Pkwt $pkwt)
    {
        $validated = $request->validate([
            'employee_id'     => 'required|exists:employees,id',
            'contract_number' => 'nullable|string|max:255',
            'start_date'      => 'required|date',
            'end_date'        => 'required|date',
            'company'         => 'nullable|string|max:255',
            'file_path'       => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $employee = Employee::findOrFail($validated['employee_id']);

        $filePath = $pkwt->file_path;

        if ($request->hasFile('file_path')) {

            if ($pkwt->file_path && Storage::disk('public')->exists($pkwt->file_path)) {
                Storage::disk('public')->delete($pkwt->file_path);
            }

            $filePath = $request->file('file_path')
                ->store('pkwt_files', 'public');
        }

        $pkwt->update([
            'employee_id'     => $validated['employee_id'],
            'contract_number' => $validated['contract_number'] ?? null,
            'start_date'      => $validated['start_date'],
            'end_date'        => $validated['end_date'],
            'company'         => $validated['company'] ?? null,
            'file_path'       => $filePath,
        ]);

        return redirect()
            ->route('pkwt.branch', strtolower($employee->branch))
            ->with('success', 'PKWT berhasil diupdate.');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy(Pkwt $pkwt)
    {
        $branch = strtolower($pkwt->employee->branch);

        if ($pkwt->file_path && Storage::disk('public')->exists($pkwt->file_path)) {
            Storage::disk('public')->delete($pkwt->file_path);
        }

        $pkwt->delete();

        return redirect()
            ->route('pkwt.branch', $branch)
            ->with('success', 'PKWT berhasil dihapus.');
    }

    public function download(Pkwt $pkwt)
{
    if (!$pkwt->file_path || !Storage::disk('public')->exists($pkwt->file_path)) {
        abort(404);
    }

    $path = storage_path('app/public/' . $pkwt->file_path);

    return response()->download(
        $path,
        basename($pkwt->file_path) // nama file tetap
    );
}

public function deleteFile(Pkwt $pkwt)
{
    if ($pkwt->file_path && Storage::disk('public')->exists($pkwt->file_path)) {
        Storage::disk('public')->delete($pkwt->file_path);
    }

    $pkwt->update([
        'file_path' => null
    ]);

    return back()->with('success', 'File PKWT berhasil dihapus.');
}
}