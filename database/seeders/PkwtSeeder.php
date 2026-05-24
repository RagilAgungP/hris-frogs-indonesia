<?php

namespace Database\Seeders;

use App\Models\Pkwt;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PkwtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | GET EMPLOYEES WITH CONTRACT STATUS
        |--------------------------------------------------------------------------
        */

        $employees = Employee::where('status', 'Contract')->get();

        if ($employees->count() == 0) {

            $this->command->info('Contract employee data not found.');

            return;
        }

        foreach ($employees as $index => $employee) {

            /*
            |--------------------------------------------------------------------------
            | RANDOM CONTRACT DATES
            |--------------------------------------------------------------------------
            */

            $startDate = Carbon::now()
                ->subMonths(rand(1, 12));

            $endDate = (clone $startDate)
                ->addMonths(rand(3, 12));

            /*
            |--------------------------------------------------------------------------
            | CREATE PKWT
            |--------------------------------------------------------------------------
            */

            Pkwt::create([

                'employee_id' => $employee->id,

                'contract_number' =>
                    'PKWT-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),

                'start_date' => $startDate,

                'end_date' => $endDate,

                /*
                |--------------------------------------------------------------------------
                | COMPANY FOLLOW EMPLOYEE
                |--------------------------------------------------------------------------
                */

                'company' => $employee->company,

                'file_path' => null,

            ]);
        }

        $this->command->info('PKWT Seeder Successfully Added.');
    }
}