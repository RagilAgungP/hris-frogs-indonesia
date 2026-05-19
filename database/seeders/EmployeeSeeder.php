<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Identity;
use App\Models\IdentityDetail;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            'FSI',
            'ISTI',
        ];

        $departments = [
            'HR',
            'IT',
            'Finance',
            'Marketing',
            'Operational',
        ];

        $positions = [
            'Staff',
            'Senior Staff',
            'Supervisor',
            'Manager',
        ];

        for ($i = 1; $i <= 30; $i++) {

            /*
            |--------------------------------------------------------------------------
            | EMPLOYEE
            |--------------------------------------------------------------------------
            */

            $employee = Employee::create([

                'employee_id' =>
                    'EMP' . str_pad($i, 4, '0', STR_PAD_LEFT),

                'name' =>
                    fake()->name(),

                'email' =>
                    'employee' . $i . '@company.com',

                'company' =>
                    'PT Future Strategy Indonesia',

                'branch' =>
                    fake()->randomElement($branches),

                /*
                |--------------------------------------------------------------------------
                | EMPLOYMENT STATUS
                |--------------------------------------------------------------------------
                | Permanent / Contract
                */

                'status' =>
                    fake()->randomElement([
                        'Permanent',
                        'Contract',
                    ]),

                /*
                |--------------------------------------------------------------------------
                | EMPLOYEE CONDITION
                |--------------------------------------------------------------------------
                | Active / Resigned
                */

                'employee_condition' =>
                    fake()->randomElement([
                        'Active',
                        'Active',
                        'Active',
                        'Resigned',
                    ]),

                'position' =>
                    fake()->randomElement($positions),

                'department' =>
                    fake()->randomElement($departments),

                'date_of_joining' =>
                    fake()
                        ->dateTimeBetween('-5 years', 'now')
                        ->format('Y-m-d'),
            ]);

            /*
            |--------------------------------------------------------------------------
            | IDENTITY
            |--------------------------------------------------------------------------
            */

            Identity::create([

                'employee_id' => $employee->id,

                'pendidikan' =>
                    fake()->randomElement([
                        'SMA',
                        'D3',
                        'S1',
                        'S2',
                    ]),

                'jurusan' =>
                    fake()->randomElement([
                        'Teknik Informatika',
                        'Sistem Informasi',
                        'Manajemen',
                        'Akuntansi',
                        'Teknik Industri',
                    ]),

                'ktp' =>
                    fake()->numerify('################'),

                'kk' =>
                    fake()->numerify('################'),

                'alamat_ktp' =>
                    fake()->address(),

                'alamat_tempat_tinggal' =>
                    fake()->address(),

                'no_hp' =>
                    fake()->phoneNumber(),

                'no_hp_keluarga' =>
                    fake()->phoneNumber(),

                'agama' =>
                    fake()->randomElement([
                        'Islam',
                        'Kristen',
                        'Katolik',
                        'Hindu',
                        'Budha',
                    ]),

                'tempat_tanggal_lahir' =>
                    fake()->city() . ', ' .
                    fake()->date('d-m-Y'),

                'status_perkawinan' =>
                    fake()->randomElement([
                        'Belum Menikah',
                        'Menikah',
                    ]),

                'jenis_kelamin' =>
                    fake()->randomElement([
                        'Laki-laki',
                        'Perempuan',
                    ]),

                'umur' =>
                    fake()->numberBetween(20, 50),
            ]);

            /*
            |--------------------------------------------------------------------------
            | IDENTITY DETAIL
            |--------------------------------------------------------------------------
            */

            IdentityDetail::create([

                'employee_id' =>
                    $employee->id,

                'bpjs_ketenagakerjaan' =>
                    fake()->numerify('###########'),

                'no_kpj' =>
                    fake()->numerify('###########'),

                'bpjs_kesehatan' =>
                    fake()->numerify('###########'),

                'npwp' =>
                    fake()->numerify('##.###.###.#-###.###'),

                'nama_bank' =>
                    fake()->randomElement([
                        'BCA',
                        'BRI',
                        'BNI',
                        'Mandiri',
                        'CIMB',
                    ]),

                'no_rekening' =>
                    fake()->bankAccountNumber(),

                'gaji_pokok' =>
                    fake()->numberBetween(4000000, 10000000),

                'tunjangan_jabatan' =>
                    fake()->numberBetween(500000, 3000000),

                'tunjangan_makan' =>
                    fake()->numberBetween(300000, 1000000),

                'tunjangan_transport' =>
                    fake()->numberBetween(300000, 1500000),
            ]);
        }
    }
}
