<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    /*
    |--------------------------------------------------------------------------
    | CASTING
    |--------------------------------------------------------------------------
    */
    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | BUSINESS LOGIC (CLEAN ARCHITECTURE)
    |--------------------------------------------------------------------------
    */

    // STATUS PKWT
    public function getStatusAttribute()
    {
        if (!$this->end_date) {
            return 'Active';
        }

        $today = Carbon::today();

        if ($this->end_date->isPast()) {
            return 'Expired';
        }

        if ($today->diffInDays($this->end_date, false) <= 30) {
            return 'Almost Expired';
        }

        return 'Active';
    }

    // STYLE STATUS
    public function getStatusClassAttribute()
    {
        return match ($this->status) {
            'Expired' => 'bg-red-100 text-red-700',
            'Almost Expired' => 'bg-yellow-100 text-yellow-700',
            default => 'bg-green-100 text-green-700',
        };
    }

    // SISA HARI
    public function getRemainingDaysAttribute()
    {
        if (!$this->end_date) {
            return null;
        }

        return Carbon::today()->diffInDays($this->end_date, false);
    }

    // DURASI KONTRAK
    public function getDurationAttribute()
    {
        if (!$this->start_date || !$this->end_date) {
            return 'Belum ditentukan';
        }

        $diff = $this->start_date->diff($this->end_date);

        $result = [];

        if ($diff->y > 0) {
            $result[] = $diff->y . ' Tahun';
        }

        if ($diff->m > 0) {
            $result[] = $diff->m . ' Bulan';
        }

        if ($diff->d > 0) {
            $result[] = $diff->d . ' Hari';
        }

        return $result ? implode(' ', $result) : '0 Hari';
    }
}