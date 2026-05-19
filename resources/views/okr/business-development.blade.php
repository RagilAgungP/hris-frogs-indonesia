@extends('layouts.app')

@section('title', 'OKR Operasional FI')

@section('content')




<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>OKR Operasional FI</title>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

<div class="container mx-auto space-y-6">

    <!-- CARD UTAMA -->
    <div class="bg-white shadow-lg rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-xl font-bold text-gray-800">OBJECTIVES & KEY RESULTS (OKR) DIVISI OPERATIONAL FI</h1>
            <button class="px-4 py-2 bg-[#3db5ff] text-white rounded font-semibold hover:bg-[#33a0e0]">ADD NEW</button>
        </div>

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
                        <td class="px-3 py-2">Efisiensi Operasional</td>
                        <td class="px-3 py-2">Pengurangan waktu proses</td>
                        <td class="px-3 py-2">Andi</td>
                        <td class="px-3 py-2 text-center">30</td>
                        <td class="px-3 py-2 text-center target">100</td>
                        <td class="px-3 py-2 text-center">
                            <input type="number" class="okr-input w-16 text-center border rounded" value="70" min="0" max="100">
                        </td>
                        <td class="px-3 py-2 text-center font-semibold progress" style="color:#facc15">70%</td>
                        <td class="px-3 py-2 text-center">
                            <button class="text-blue-600 hover:underline">Edit</button>
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-3 py-2 text-center">2</td>
                        <td class="px-3 py-2">Kualitas Layanan</td>
                        <td class="px-3 py-2">Penurunan komplain pelanggan</td>
                        <td class="px-3 py-2">Budi</td>
                        <td class="px-3 py-2 text-center">40</td>
                        <td class="px-3 py-2 text-center target">100</td>
                        <td class="px-3 py-2 text-center">
                            <input type="number" class="okr-input w-16 text-center border rounded" value="85" min="0" max="100">
                        </td>
                        <td class="px-3 py-2 text-center font-semibold progress" style="color:#22c55e">85%</td>
                        <td class="px-3 py-2 text-center">
                            <button class="text-blue-600 hover:underline">Edit</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 3 CARD BAWAH -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- CARD 1 : CHART -->
        <div class="bg-white shadow-lg rounded-lg p-4">
            <h2 class="font-semibold mb-4">Progress per Objective</h2>
            <canvas id="okrChart" height="200"></canvas>
        </div>

        <!-- CARD 2 : RESULT -->
        <div class="bg-white shadow-lg rounded-lg p-4">
            <h2 class="font-semibold mb-4">Result</h2>
            <div class="result-bars space-y-4">
                <div class="flex justify-between items-center">
                    <span>Efisiensi Operasional</span>
                    <div class="w-32 bg-gray-200 rounded h-2 relative">
                        <div class="h-2 rounded bg-yellow-400" style="width:70%"></div>
                        <span class="absolute right-0 top-0 text-xs text-gray-600">70%</span>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <span>Kualitas Layanan</span>
                    <div class="w-32 bg-gray-200 rounded h-2 relative">
                        <div class="h-2 rounded bg-green-500" style="width:85%"></div>
                        <span class="absolute right-0 top-0 text-xs text-gray-600">85%</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD 3 : KETERANGAN -->
        <div class="bg-white shadow-lg rounded-lg p-4">
            <h2 class="font-semibold mb-4">Keterangan</h2>
            <ul class="text-sm space-y-2">
                <li class="flex items-center">
                    <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span> Tidak Berjalan &lt; 30%
                </li>
                <li class="flex items-center">
                    <span class="w-3 h-3 bg-yellow-400 rounded-full mr-2"></span> Sedang Berjalan 30–69%
                </li>
                <li class="flex items-center">
                    <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span> Target Tercapai 70–99%
                </li>
                <li class="flex items-center">
                    <span class="w-3 h-3 bg-blue-600 rounded-full mr-2"></span> Melampaui Target 100%
                </li>
            </ul>
        </div>

    </div>

</div>

<script>
// Chart.js setup
const ctx = document.getElementById('okrChart');
const okrChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Efisiensi Operasional','Kualitas Layanan'],
        datasets: [{
            label: 'Progress (%)',
            data: [70,85],
            backgroundColor: ['#facc15','#22c55e']
        }]
    },
    options: {
        scales: { y: { beginAtZero:true, max:100 } }
    }
});

// Input interaktif
const inputs = document.querySelectorAll('.okr-input');
inputs.forEach((input, index) => {
    input.addEventListener('input', () => {
        const tr = input.closest('tr');
        const target = parseFloat(tr.querySelector('.target').innerText);
        let actual = parseFloat(input.value);
        if(actual > target) actual = target; // optional clamp
        const progress = Math.round((actual / target) * 100);

        // Update table progress
        const progressTd = tr.querySelector('.progress');
        let color;
        if(progress < 30) color = '#ef4444';
        else if(progress < 70) color = '#facc15';
        else if(progress < 100) color = '#22c55e';
        else color = '#3b82f6';
        progressTd.innerText = progress+'%';
        progressTd.style.color = color;

        // Update chart
        okrChart.data.datasets[0].data[index] = progress;
        okrChart.data.datasets[0].backgroundColor[index] = color;
        okrChart.update();

        // Update mini progress bars
        const resultBar = document.querySelectorAll('.result-bars div .h-2')[index];
        resultBar.style.width = progress+'%';
        resultBar.style.backgroundColor = color;
        const resultText = resultBar.nextElementSibling;
        if(resultText) resultText.innerText = progress+'%';
    });
});
</script>

</body>
</html>
@endsection
