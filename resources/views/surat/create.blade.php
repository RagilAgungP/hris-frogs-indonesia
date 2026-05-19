@extends('layouts.app')

@section('title', 'Create Surat | FROGS Indonesia')

@section('content')
<div class="container mx-auto p-6">

    <h2 class="text-2xl font-semibold mb-6">Create New Surat (Frontend Dummy)</h2>

    <form id="createSuratForm" class="space-y-4 bg-white shadow p-6 rounded">

        <div>
            <label class="block mb-1 font-semibold">Perihal</label>
            <input type="text" id="perihal" class="border border-gray-300 rounded px-3 py-2 w-full" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold">Kepada</label>
            <input type="text" id="kepada" class="border border-gray-300 rounded px-3 py-2 w-full" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold">Division</label>
            <select id="division" class="border border-gray-300 rounded px-3 py-2 w-full" required>
                <option value="">-- Select Division --</option>
                <option value="Board of Directors">Board of Directors</option>
                <option value="Operational">Operational</option>
                <option value="Technology">Technology</option>
                <option value="Business Development">Business Development</option>
                <option value="Finance">Finance</option>
                <option value="HRGA">HRGA</option>
                <option value="Legal">Legal</option>
            </select>
        </div>

        <div>
            <label class="block mb-1 font-semibold">Jenis Surat</label>
            <select id="jenis_surat" class="border border-gray-300 rounded px-3 py-2 w-full" required>
                <option value="">-- Select Jenis Surat --</option>
                <option value="Addendum">Addendum</option>
                <option value="Berita Acara">Berita Acara</option>
                <option value="Job Order">Job Order</option>
                <option value="PKK">PKK</option>
                <option value="Perjanjian Kerja Sama">Perjanjian Kerja Sama</option>
                <option value="Kwitansi/Penagihan">Kwitansi/Penagihan</option>
                <option value="Memorandum">Memorandum</option>
                <option value="Nota Dinas">Nota Dinas</option>
                <option value="Pemberitahuan">Pemberitahuan</option>
                <option value="Permohonan">Permohonan</option>
                <option value="Perjanjian Kerahasiaan">Perjanjian Kerahasiaan</option>
                <option value="Penawaran">Penawaran</option>
                <option value="Purchase Order">Purchase Order</option>
                <option value="Surat Keputusan">Surat Keputusan</option>
                <option value="Surat Rekomendasi">Surat Rekomendasi</option>
                <option value="Surat Tugas">Surat Tugas</option>
                <option value="SOP">SOP</option>
                <option value="Surat Kuasa">Surat Kuasa</option>
                <option value="Perjanjian Jual Beli">Perjanjian Jual Beli</option>
                <option value="Surat Pengajuan">Surat Pengajuan</option>
                <option value="Surat Keterangan">Surat Keterangan</option>
                <option value="Delivery Order">Delivery Order</option>
                <option value="Surat Peringatan">Surat Peringatan</option>
            </select>
        </div>

        <div>
            <label class="block mb-1 font-semibold">No Surat</label>
            <input type="text" id="no_surat" class="border border-gray-300 rounded px-3 py-2 w-full" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold">Tanggal Surat</label>
            <input type="date" id="tanggal_surat" class="border border-gray-300 rounded px-3 py-2 w-full" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold">Berkas Surat (PDF/DOC)</label>
            <input type="file" id="file_surat" class="border border-gray-300 rounded px-3 py-2 w-full">
        </div>

        <button type="submit" class="px-4 py-2 bg-[#3db5ff] text-white rounded hover:bg-[#33a0e0] font-semibold">Submit</button>
    </form>
</div>

<script>
document.getElementById('createSuratForm').addEventListener('submit', function(e){
    e.preventDefault();

    const perihal = document.getElementById('perihal').value;
    const kepada = document.getElementById('kepada').value;
    const division = document.getElementById('division').value;
    const jenis = document.getElementById('jenis_surat').value;
    const noSurat = document.getElementById('no_surat').value;
    const tanggal = document.getElementById('tanggal_surat').value;
    const file = document.getElementById('file_surat').files[0];

    alert(
        `Surat Dummy Created!\n\n` +
        `Perihal: ${perihal}\n` +
        `Kepada: ${kepada}\n` +
        `Division: ${division}\n` +
        `Jenis Surat: ${jenis}\n` +
        `No Surat: ${noSurat}\n` +
        `Tanggal: ${tanggal}\n` +
        `File: ${file ? file.name : 'No file uploaded'}`
    );

    this.reset();
});
</script>
@endsection
