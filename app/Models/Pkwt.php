<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pkwt extends Model
{
    use HasFactory;

    protected $table = 'pkwt';

    protected $fillable = [
        'employee_id',
        'contract_number',
        'start_date',
        'end_date',
        'company',
        'file_path',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}