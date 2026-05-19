<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('identities_detail', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_id')
                ->constrained('employees')
                ->onDelete('cascade');

            $table->string('bpjs_ketenagakerjaan')->nullable();
            $table->string('no_kpj')->nullable();
            $table->string('bpjs_kesehatan')->nullable();
            $table->string('npwp')->nullable();

            $table->string('nama_bank')->nullable();
            $table->string('no_rekening')->nullable();

            $table->decimal('gaji_pokok', 15, 2)->nullable();
            $table->decimal('tunjangan_jabatan', 15, 2)->nullable();
            $table->decimal('tunjangan_makan', 15, 2)->nullable();
            $table->decimal('tunjangan_transport', 15, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('identities_detail');
    }
};