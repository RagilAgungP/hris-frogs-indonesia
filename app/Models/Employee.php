<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';

    protected $fillable = [
        'employee_id',
        'name',
        'email',
        'company',
        'branch',
        'status',
        'employee_condition',
        'position',
        'department',
        'date_of_joining',
    ];

    protected $casts = [
        'date_of_joining' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function identity()
    {
        return $this->hasOne(Identity::class, 'employee_id', 'id');
    }

    public function identityDetail()
    {
        return $this->hasOne(IdentityDetail::class, 'employee_id', 'id');
    }

    public function pkwts()
    {
        return $this->hasMany(Pkwt::class, 'employee_id', 'id');
    }
}