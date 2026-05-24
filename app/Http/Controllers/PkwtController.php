<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Pkwt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PkwtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pkwts = Pkwt::with('employee')
            ->latest()
            ->get();

        return view('pkwt.fsi', compact('pkwts'));
    }

    /**
     * Show the form for creating the resource.
     */
    public function create()
    {
        $employees = Employee::orderBy('name')->get();

        return view('pkwt.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'contract_number' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'company' => 'nullable|string|max:255',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $filePath = null;

        if ($request->hasFile('file_path')) {

            $filePath = $request->file('file_path')
                ->store('pkwt_files', 'public');
        }

        Pkwt::create([
            'employee_id' => $request->employee_id,
            'contract_number' => $request->contract_number,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'company' => $request->company,
            'file_path' => $filePath,
        ]);

        return redirect()
            ->route('pkwt.index')
            ->with('success', 'PKWT employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pkwt $pkwt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pkwt $pkwt)
    {
        $employees = Employee::orderBy('name')->get();

        return view('pkwt.edit', compact('pkwt', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pkwt $pkwt)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'contract_number' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'company' => 'nullable|string|max:255',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $filePath = $pkwt->file_path;

        if ($request->hasFile('file_path')) {

            if (
                $pkwt->file_path &&
                Storage::disk('public')->exists($pkwt->file_path)
            ) {

                Storage::disk('public')->delete($pkwt->file_path);
            }

            $filePath = $request->file('file_path')
                ->store('pkwt_files', 'public');
        }

        $pkwt->update([
            'employee_id' => $request->employee_id,
            'contract_number' => $request->contract_number,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'company' => $request->company,
            'file_path' => $filePath,
        ]);

        return redirect()
            ->route('pkwt.index')
            ->with('success', 'PKWT employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pkwt $pkwt)
    {
        if (
            $pkwt->file_path &&
            Storage::disk('public')->exists($pkwt->file_path)
        ) {

            Storage::disk('public')->delete($pkwt->file_path);
        }

        $pkwt->delete();

        return redirect()
            ->route('pkwt.index')
            ->with('success', 'PKWT employee deleted successfully.');
    }
}