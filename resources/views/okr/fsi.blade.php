@extends('layouts.app')

@section('title', 'OKR Operasional FI')

@section('content')
<div class="container mx-auto p-6 space-y-6">

    {{-- CARD UTAMA --}}
    <div class="bg-white shadow-lg rounded-lg p-6">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-xl font-bold text-gray-800">
                OBJECTIVES & KEY RESULTS (OKR) DIVISI OPERATIONAL FI
            </h1>

            <button class="px-4 py-2 bg-[#3db5ff] text-white rounded font-semibold hover:bg-[#33a0e0]">
                ADD NEW
            </button>
        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded">
                <thead class="bg-[#3db5ff] text-white text-sm">
                    <tr>
                        <th class="px-3 py-2 text-center">ID</th>
                        <th class="px-3 py-2">OBJECTIVE NAME</th>
                        <th class="px-3 py-2">KEY RESULT</th>
                        <th class="px-3 py-2">OWNER</th>
                        <th class="px-3 py-2 text-center">WEIGHT (%)</th>
                        <th class="px-3 py-2 text-center">TARGET (%)</th>
                        <th class="px-3 py-2 text-center">ACTUAL (%)</th>
                        <th class="px-3 py-2 text-center">PROGRESS (%)</th>
                        <th class="px-3 py-2 text-center">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    <tr class="border-b">
                        <td class="px-3 py-2 text-center">1</td>
                        <td class="px-3 py-2">Meningkatkan Efisiensi Operasional</td>
                        <td class="px-3 py-2">Pengurangan waktu proses</td>
                        <td class="px-3 py-2">Andi</td>
                        <td class="px-3 py-2 text-center">30</td>
                        <td class="px-3 py-2 text-center">100</td>
                        <td class="px-3 py-2 text-center">70</td>
                        <td class="px-3 py-2 text-center font-semibold text-yellow-600">70%</td>
                        <td class="px-3 py-2 text-center">
                            <button class="text-blue-600 hover:underline">Edit</button>
                        </td>
                    </tr>

                    <tr class="border-b">
                        <td class="px-3 py-2 text-center">2</td>
                        <td class="px-3 py-2">Meningkatkan Kualitas Layanan</td>
                        <td class="px-3 py-2">Penurunan komplain pelanggan</td>
                        <td class="px-3 py-2">Budi</td>
                        <td class="px-3 py-2 text-center">40</td>
                        <td class="px-3 py-2 text-center">100</td>
                        <td class="px-3 py-2 text-center">85</td>
                        <td class="px-3 py-2 text-center font-semibold text-green-600">85%</td>
                        <td class="px-3 py-2 text-center">
                            <button class="text-blue-600 hover:underline">Edit</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- 3 CARD BAWAH --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- CARD 1 : GRAFIK --}}
        <div class="bg-white shadow-lg rounded-lg p-4">
            <h2 class="font-semibold mb-4">Progress per Objective</h2>
            <canvas id="okrChart" height="200"></canvas>
        </div>

   {{-- CARD 2 : RESULT --}}
<div class="bg-white shadow-lg rounded-lg p-4">
    <h2 class="font-semibold mb-4">Result</h2>

    {{-- HEADER --}}
    <div class="grid grid-cols-3 text-xs font-bold text-gray-500 mb-3">
        <div class="col-span-2">OBJECTIVE NAME</div>
        <div class="text-right">PROGRESS</div>
    </div>

    {{-- ROW 1 --}}
    <div class="grid grid-cols-3 items-center mb-4">
        <div class="col-span-2 text-sm">
            Efisiensi Operasional
        </div>
        <div class="flex justify-end">
            <div class="flex flex-col items-center">
                <div class="w-16 bg-gray-200 rounded h-1.5">
                    <div class="bg-yellow-400 h-1.5 rounded" style="width:70%"></div>
                </div>
                <div class="text-xs text-gray-600 mt-1">
                    70%
                </div>
            </div>
        </div>
    </div>

    {{-- ROW 2 --}}
    <div class="grid grid-cols-3 items-center">
        <div class="col-span-2 text-sm">
            Kualitas Layanan
        </div>
        <div class="flex justify-end">
            <div class="flex flex-col items-center">
                <div class="w-16 bg-gray-200 rounded h-1.5">
                    <div class="bg-green-500 h-1.5 rounded" style="width:85%"></div>
                </div>
                <div class="text-xs text-gray-600 mt-1">
                    85%
                </div>
            </div>
        </div>
    </div>
</div>




        {{-- CARD 3 : KETERANGAN --}}
        <div class="bg-white shadow-lg rounded-lg p-4">
            <h2 class="font-semibold mb-4">Keterangan</h2>

            <ul class="text-sm space-y-2">
                <li class="flex items-center">
                    <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                    Tidak Berjalan &lt; 30%
                </li>
                <li class="flex items-center">
                    <span class="w-3 h-3 bg-yellow-400 rounded-full mr-2"></span>
                    Sedang Berjalan 30–69%
                </li>
                <li class="flex items-center">
                    <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                    Target Tercapai 70–99%
                </li>
                <li class="flex items-center">
                    <span class="w-3 h-3 bg-blue-600 rounded-full mr-2"></span>
                    Melampaui Target 100%
                </li>
            </ul>
        </div>

    </div>

</div>

{{-- CHART --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('okrChart');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Efisiensi Operasional', 'Kualitas Layanan'],
        datasets: [{
            label: 'Progress (%)',
            data: [70, 85],
            backgroundColor: ['#facc15', '#22c55e']
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                max: 100
            }
        }
    }
});
</script>
@endsection
