<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;

class Identity extends Model
{
    protected $table = 'identities';

    protected $fillable = [
        'employee_id',
        'pendidikan',
        'jurusan',
        'ktp',
        'kk',
        'alamat_ktp',
        'alamat_tempat_tinggal',
        'no_hp',
        'no_hp_keluarga',
        'agama',
        'tempat_tanggal_lahir',
        'status_perkawinan',
        'jenis_kelamin',
        'umur',
    ];

    /**
     * FIX RELASI WAJIB
     */
public function employee()
{
    return $this->belongsTo(Employee::class, 'employee_id', 'id');
}
}