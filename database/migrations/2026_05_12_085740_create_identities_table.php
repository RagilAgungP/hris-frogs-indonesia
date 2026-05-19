<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('identities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_id')
                ->constrained('employees')
                ->onDelete('cascade');

            $table->string('pendidikan')->nullable();
            $table->string('jurusan')->nullable();

            $table->string('ktp')->nullable();
            $table->string('kk')->nullable();

            $table->text('alamat_ktp')->nullable();
            $table->text('alamat_tempat_tinggal')->nullable();

            $table->string('no_hp')->nullable();
            $table->string('no_hp_keluarga')->nullable();

            $table->string('agama')->nullable();
            $table->string('tempat_tanggal_lahir')->nullable();

            $table->string('status_perkawinan')->nullable();
            $table->string('jenis_kelamin')->nullable();

            $table->integer('umur')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('identities');
    }
};