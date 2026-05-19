<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {

            $table->id();

            $table->string('employee_id')->unique();

            $table->string('name');

            $table->string('email')->unique();

            $table->string('company')->nullable();

            $table->string('branch')->nullable();

            /*
            |--------------------------------------------------------------------------
            | EMPLOYMENT STATUS
            |--------------------------------------------------------------------------
            | Permanent / Contract
            */
            $table->enum('status', [
                'Permanent',
                'Contract'
            ])->default('Contract');

            /*
            |--------------------------------------------------------------------------
            | EMPLOYEE CONDITION
            |--------------------------------------------------------------------------
            | Active / Resigned
            */
            $table->enum('employee_condition', [
                'Active',
                'Resigned'
            ])->default('Active');

            $table->string('position');

            $table->string('department');

            $table->date('date_of_joining');

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | INDEXES
            |--------------------------------------------------------------------------
            */

            $table->index('branch');
            $table->index('status');
            $table->index('employee_condition');
            $table->index('department');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};