@extends('layouts.app')

@section('title', 'Menu Access | FROGS Indonesia')

@section('content')
<div class="container mx-auto p-6">

    {{-- Card --}}
    <div class="bg-white shadow-lg rounded-lg p-6">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Menu Access Users</h2>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded">
                <thead class="bg-[#3db5ff] text-white">
                    <tr>
                        <th class="py-2 px-4 border-b text-center">#</th>
                        <th class="py-2 px-4 border-b text-left">Name</th>
                        <th class="py-2 px-4 border-b text-left">Email</th>
                        <th class="py-2 px-4 border-b text-left">Role</th>
                        <th class="py-2 px-4 border-b text-left">Status</th>
                        <th class="py-2 px-4 border-b text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ([
                        ['name' => 'Admin', 'email' => 'admin@gmail.com', 'role' => 'Administrator', 'status' => 'Approved'],
                        ['name' => 'Thofa Hesa Alfauzi', 'email' => 'thofahesa@gmail.com', 'role' => 'Technologi', 'status' => 'Approved'],
                        ['name' => 'Adnan Silvan Erusani', 'email' => 'adnansilvan@gmail.com', 'role' => 'FI', 'status' => 'Approved'],
                        ['name' => 'Ragil Agung Pamungkas', 'email' => 'ragilagung@gmail.com', 'role' => 'FSI', 'status' => 'Not Approved'],
                    ] as $i => $user)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b text-center">{{ $i + 1 }}</td>
                        <td class="py-2 px-4 border-b">{{ $user['name'] }}</td>
                        <td class="py-2 px-4 border-b">{{ $user['email'] }}</td>
                        <td class="py-2 px-4 border-b">{{ $user['role'] }}</td>
                        <td class="py-2 px-4 border-b">
                            @if($user['status'] == 'Approved')
                                <span class="px-2 py-1 rounded bg-green-500 text-white text-sm">Approved</span>
                            @else
                                <span class="px-2 py-1 rounded bg-red-500 text-white text-sm">Not Approved</span>
                            @endif
                        </td>
                        <td class="py-2 px-4 border-b text-center">
                            <div class="relative inline-block text-left">
                                <button onclick="toggleDropdown(this)" class="bg-gray-200 px-2 py-1 rounded hover:bg-gray-300">&#8942;</button>
                                <div class="dropdown hidden absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded shadow-lg z-10">
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100">Edit Status</a>
                                    <a href="#" class="block px-4 py-2 hover:bg-gray-100 text-red-600">Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</div>

<script>
    // Dropdown toggle
    function toggleDropdown(button) {
        const dropdown = button.nextElementSibling;
        dropdown.classList.toggle('hidden');
    }

    // Click outside closes dropdown
    document.addEventListener('click', function(e) {
        document.querySelectorAll('.dropdown').forEach(d => {
            if (!d.previousElementSibling.contains(e.target)) {
                d.classList.add('hidden');
            }
        });
    });
</script>
@endsection
