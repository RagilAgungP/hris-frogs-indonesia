<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class IdentityDetail extends Model
{
    protected $table = 'identities_detail';

    protected $fillable = [
        'employee_id',
        'bpjs_ketenagakerjaan',
        'no_kpj',
        'bpjs_kesehatan',
        'npwp',
        'nama_bank',
        'no_rekening',
        'gaji_pokok',
        'tunjangan_jabatan',
        'tunjangan_makan',
        'tunjangan_transport',
    ];

    /**
     * FIX RELASI WAJIB
     */
public function employee()
{
    return $this->belongsTo(Employee::class, 'employee_id', 'id');
}
}