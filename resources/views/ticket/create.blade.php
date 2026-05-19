@extends('layouts.app')

@section('title', 'Create New | Tambah Ticket')

@section('content')
<div class="container mx-auto p-6">

    {{-- Card --}}
    <div class="bg-white shadow-lg rounded-lg p-6 max-w-3xl mx-auto">

        {{-- Header --}}
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">
            Create New | Tambah TICKET
        </h2>

        {{-- Form --}}
        <form action="#" method="POST" class="space-y-6">
            @csrf

            {{-- Nama --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Nama
                </label>
                <input type="text"
                       placeholder="Masukkan nama"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
            </div>

            {{-- Asal Divisi --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Asal Divisi
                </label>
                <select class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    <option value="">-- Pilih Divisi --</option>
                    <option>Board of Directors</option>
                    <option>Operational</option>
                    <option>Technology</option>
                    <option>Business Development</option>
                    <option>Finance, Accounting, Tax</option>
                    <option>Human Resource General Affairs</option>
                    <option>Legal</option>
                </select>
            </div>

            {{-- Jenis Ticket --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Jenis Ticket
                </label>
                <select class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none">
                    <option value="">Pilih Jenis Ticket</option>
                    <option>Addendum</option>
                    <option>Berita Acara</option>
                    <option>Job Order</option>
                    <option>PKK</option>
                    <option>Perjanjian Kerja Sama</option>
                    <option>Kwitansi/Penagihan</option>
                    <option>Memorandum of Understandings</option>
                    <option>Memorandum of Agreement</option>
                    <option>Minutes of Meeting</option>
                    <option>Nota Dinas</option>
                    <option>Pemberitahuan</option>
                    <option>Permohonan</option>
                    <option>Perjanjian Kerahasiaan</option>
                    <option>Penawaran</option>
                    <option>Purchase Order</option>
                    <option>Surat Keputusan</option>
                    <option>Surat Rekomendasi</option>
                    <option>Surat Tugas</option>
                    <option>Standard Operational Procedure</option>
                    <option>Surat Kuasa</option>
                    <option>Perjanjian Jual Beli</option>
                    <option>Surat Pengajuan</option>
                    <option>Surat Keterangan</option>
                    <option>Delivery Order</option>
                    <option>Surat Peringatan</option>
                </select>
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Deskripsi
                </label>
                <textarea rows="4"
                          placeholder="Masukkan deskripsi ticket"
                          class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200 focus:outline-none"></textarea>
            </div>

            {{-- Action --}}
            <div class="flex justify-end space-x-3 pt-4">
                <a href="{{ route('ticket.index') }}"
                   class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    Batal
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-[#3db5ff] text-white rounded hover:bg-[#33a0e0] font-semibold">
                    Submit Ticket
                </button>
            </div>

        </form>

    </div>
</div>
@endsection
