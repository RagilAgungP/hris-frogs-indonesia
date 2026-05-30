<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PkwtController;
use App\Models\Pkwt;
use App\Http\Controllers\SeeDetailController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| AUTH MIDDLEWARE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | OKR
    |--------------------------------------------------------------------------
    */
    Route::prefix('okr')->group(function () {
        Route::view('/', 'okr.index')->name('okr');
        Route::view('/operasional', 'okr.operasional');
        Route::view('/fi', 'okr.fi');
        Route::view('/fsi', 'okr.fsi');
        Route::view('/technology', 'okr.technology');
        Route::view('/business-development', 'okr.business-development');
        Route::view('/finance', 'okr.finance');
        Route::view('/hrga', 'okr.hrga');
    });

    /*
    |--------------------------------------------------------------------------
    | EMPLOYEE
    |--------------------------------------------------------------------------
    */
    Route::get('/employee/fsi', [EmployeeController::class, 'fsi'])->name('employee.fsi');
    Route::get('/employee/isti', [EmployeeController::class, 'isti'])->name('employee.isti');

    Route::put('/employee/{employee}/resign', [EmployeeController::class, 'resign'])->name('employee.resign');


Route::get('/employees/{id}', [SeeDetailController::class, 'show'])->name('employee.show');

Route::put('/employees/{id}/update-main', [SeeDetailController::class, 'updateEmployee'])->name('employee.updateMain');

Route::put('/employees/{id}/update-identity', [SeeDetailController::class, 'updateIdentity'])->name('employee.updateIdentity');

Route::put('/employees/{id}/update-identity-detail', [SeeDetailController::class, 'updateIdentityDetail'])->name('employee.updateIdentityDetail');
    Route::resource('employee', EmployeeController::class);

    /*
    |--------------------------------------------------------------------------
    | PKWT
    |--------------------------------------------------------------------------
    */

    Route::get('/pkwt/{branch}', [PkwtController::class, 'index'])->name('pkwt.branch');

    Route::resource('pkwt', PkwtController::class)->except(['index']);

    /*
    |--------------------------------------------------------------------------
    | PKWT JSON (FIXED - hanya 1 route)
    |--------------------------------------------------------------------------
    */
    Route::get('/pkwt/{id}/json', function ($id) {

    $pkwt = \App\Models\Pkwt::with('employee')->find($id);

    return response()->json([
        'id' => $pkwt?->id,
        'employee_id' => $pkwt?->employee_id,
        'employee_name' => $pkwt?->employee?->name,
        'contract_number' => $pkwt?->contract_number,
        'start_date' => optional($pkwt?->start_date)->format('Y-m-d'),
        'end_date' => optional($pkwt?->end_date)->format('Y-m-d'),
        'company' => $pkwt?->company,
    ]);
});

    /*
    |--------------------------------------------------------------------------
    | SURAT
    |--------------------------------------------------------------------------
    */
    Route::prefix('surat')->group(function () {
        Route::view('/', 'surat.index')->name('surat');
        Route::view('/create', 'surat.create')->name('surat.create');
    });

    /*
    |--------------------------------------------------------------------------
    | TICKET
    |--------------------------------------------------------------------------
    */
    Route::prefix('ticket')->group(function () {
        Route::view('/', 'ticket.index')->name('ticket');
        Route::view('/create', 'ticket.create')->name('ticket.create');
    });

    /*
    |--------------------------------------------------------------------------
    | FORM
    |--------------------------------------------------------------------------
    */
    Route::prefix('form')->group(function () {
        Route::view('/', 'form.index')->name('form');
        Route::view('/operasional', 'form.operasional');
        Route::view('/fi', 'form.fi');
        Route::view('/fsi', 'form.fsi');
        Route::view('/technology', 'form.technology');
        Route::view('/business-development', 'form.business-development');
        Route::view('/finance', 'form.finance');
        Route::view('/hrga', 'form.hrga');
    });

    /*
    |--------------------------------------------------------------------------
    | SOP
    |--------------------------------------------------------------------------
    */
    Route::prefix('sop')->group(function () {
        Route::view('/', 'sop.index')->name('sop');
        Route::view('/operasional', 'sop.operasional');
        Route::view('/fi', 'sop.fi');
        Route::view('/fsi', 'sop.fsi');
        Route::view('/technology', 'sop.technology');
        Route::view('/business-development', 'sop.business-development');
        Route::view('/finance', 'sop.finance');
        Route::view('/hrga', 'sop.hrga');
    });

    /*
    |--------------------------------------------------------------------------
    | MEMO
    |--------------------------------------------------------------------------
    */
    Route::prefix('memo')->group(function () {
        Route::view('/', 'memo.index')->name('memo');
        Route::view('/operasional', 'memo.operasional');
        Route::view('/fi', 'memo.fi');
        Route::view('/fsi', 'memo.fsi');
        Route::view('/technology', 'memo.technology');
        Route::view('/business-development', 'memo.business-development');
        Route::view('/finance', 'memo.finance');
        Route::view('/hrga', 'memo.hrga');
    });

    /*
    |--------------------------------------------------------------------------
    | SETTINGS
    |--------------------------------------------------------------------------
    */
    Route::prefix('settings')->group(function () {
        Route::view('/', 'settings.index')->name('settings');
        Route::view('/company-division', 'settings.company-division');
        Route::view('/menu-access', 'settings.menu-access');
    });
Route::get('/pkwt/download/{pkwt}', [PkwtController::class, 'download'])
    ->name('pkwt.download');
});


Route::delete('/pkwt/{pkwt}/file', [PkwtController::class, 'deleteFile'])
    ->name('pkwt.deleteFile');