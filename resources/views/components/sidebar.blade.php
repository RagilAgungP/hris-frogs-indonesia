@php
$name   = $name ?? 'John Doe';
$role   = $role ?? 'Administrator';

// Mapping menu label ke route
$menuRoutes = [
    'Dashboard' => 'dashboard',
    'OKR' => 'okr',
    'Employee' => 'employee',
    'PKWT' => 'pkwt',
    'Surat' => 'surat',
    'Ticket' => 'ticket',
    'Form' => 'form',
    'SOP' => 'sop',
    'Memo' => 'memo',
    'General Settings' => 'settings',
];

// Dropdown submenu
$sub_employee = ['FSI', 'ISTI'];
$sub_department = ['Operasional', 'FI', 'FSI', 'Technology', 'Business Development', 'Finance', 'HRGA'];
$sub_settings = ['Company Division', 'Menu Access'];

// Icon sets
$submenuIcons = [
    'Operasional' => 'heroicon-o-wrench',
    'FI' => 'heroicon-o-chart-pie',
    'FSI' => 'heroicon-o-shield-check',
    'Technology' => 'heroicon-o-cpu-chip',
    'Business Development' => 'heroicon-o-briefcase',
    'Finance' => 'heroicon-o-banknotes',
    'HRGA' => 'heroicon-o-users',
];

$submenuIconsEmployee = [
    'FSI' => 'heroicon-o-building-office',
    'ISTI' => 'heroicon-o-building-office',
];

$submenuIconsPKWT = [
    'FSI' => 'heroicon-o-building-office',
    'ISTI' => 'heroicon-o-building-office',
];

$submenuIconsSettings = [
    'Company Division' => 'heroicon-o-building-office',
    'Menu Access' => 'heroicon-o-lock-closed',
];

// Menu utama
$menu = [
    'DASHBOARD' => [
        ['icon' => 'heroicon-o-home', 'label' => 'Dashboard', 'dropdown' => false]
    ],
    'PERFORMANCE' => [
        ['icon' => 'heroicon-o-chart-bar', 'label' => 'OKR', 'dropdown' => $sub_department]
    ],
    'EMPLOYEE' => [
        ['icon' => 'heroicon-o-users', 'label' => 'Employee', 'dropdown' => $sub_employee],
        ['icon' => 'heroicon-o-document-text', 'label' => 'PKWT', 'dropdown' => $sub_employee],
    ],
    'COMPLIANCE' => [
        ['icon' => 'heroicon-o-envelope', 'label' => 'Surat', 'dropdown' => false],
        ['icon' => 'heroicon-o-ticket', 'label' => 'Ticket', 'dropdown' => false],
        ['icon' => 'heroicon-o-clipboard-document', 'label' => 'Form', 'dropdown' => $sub_department],
        ['icon' => 'heroicon-o-book-open', 'label' => 'SOP', 'dropdown' => $sub_department],
        ['icon' => 'heroicon-o-document-duplicate', 'label' => 'Memo', 'dropdown' => $sub_department],
    ],
    'SETTINGS' => [
        ['icon' => 'heroicon-o-cog-6-tooth', 'label' => 'General Settings', 'dropdown' => $sub_settings],
    ],
];
@endphp

<aside class="w-64 h-screen fixed top-0 left-0 bg-white shadow-lg rounded-r-3xl border-r border-blue-200 flex flex-col justify-between overflow-hidden">

    {{-- PROFILE --}}
    <div class="px-4 pt-6">
        <div class="flex items-center mb-4">
            <img src="https://randomuser.me/api/portraits/men/15.jpg" class="w-12 h-12 rounded-full border shadow-sm">
            <div class="ml-3">
                <h2 class="font-semibold text-gray-800 text-sm">{{ $name }}</h2>
                <p class="text-xs font-bold text-blue-600 flex items-center">
                    <span class="flex-grow border-b border-gray-300"></span>
                    <span class="px-1">{{ strtoupper($role) }}</span>
                    <span class="flex-grow border-b border-gray-300"></span>
                </p>
            </div>
        </div>
    </div>

    {{-- MENU --}}
    <div class="text-sm px-2 flex-1 overflow-y-auto">
        @foreach($menu as $section => $items)
            {{-- SECTION TITLE --}}
            <div class="flex items-center my-2">
                <span class="flex-grow border-b border-gray-300"></span>
                <span class="text-gray-500 text-xs font-bold px-2">{{ $section }}</span>
                <span class="flex-grow border-b border-gray-300"></span>
            </div>

            {{-- MENU ITEMS --}}
            @foreach($items as $item)
                @php
                    $route = $menuRoutes[$item['label']] ?? '#';
                    $isActive = request()->is($route) || request()->is("$route/*");
                @endphp

                <div x-data="{ open: {{ $isActive && $item['dropdown'] ? 'true' : 'false' }} }">

                    {{-- MAIN ITEM --}}
                    @if(!$item['dropdown'])
    {{-- MENU TANPA DROPDOWN --}}
    <a href="{{ url($route) }}"
       class="flex items-center w-full px-3 py-2 rounded-full mb-1 transition
       {{ $isActive ? 'bg-[#3db5ff] text-white font-semibold shadow' : 'text-gray-700 hover:bg-[#3db5ff] hover:text-white' }}">

        <x-dynamic-component :component="$item['icon']" class="w-5 h-5 mr-2" />
        <span class="flex-1 text-left">{{ $item['label'] }}</span>
    </a>
@else
    {{-- MENU DENGAN DROPDOWN --}}
    <button 
        @click="open = !open"
        class="flex items-center w-full px-3 py-2 rounded-full mb-1 transition
        {{ $isActive ? 'bg-[#3db5ff] text-white font-semibold shadow' : 'text-gray-700 hover:bg-[#3db5ff] hover:text-white' }}">

        <x-dynamic-component :component="$item['icon']" class="w-5 h-5 mr-2" />
        <span class="flex-1 text-left">{{ $item['label'] }}</span>

        <x-heroicon-o-chevron-down 
            class="w-4 h-4 transition-transform"
            x-bind:class="open ? 'rotate-180' : ''" />
    </button>
@endif


                    {{-- SUBMENU --}}
                    @if($item['dropdown'])
                        <div x-show="open" x-collapse class="ml-6 mb-2">

                            @foreach($item['dropdown'] as $sub)
                                @php
                                    $subRoute = $route . '/' . strtolower(str_replace(' ', '-', $sub));
                                    $isSubActive = request()->is($subRoute) || request()->is("$subRoute/*");

                                    // Pilih icon berdasarkan label menu utama
                                    $iconSet = match($item['label']) {
                                        'Employee' => $submenuIconsEmployee,
                                        'PKWT' => $submenuIconsPKWT,
                                        'General Settings' => $submenuIconsSettings,
                                        default => $submenuIcons,
                                    };
                                    $subIcon = $iconSet[$sub] ?? 'heroicon-o-circle-stack';
                                @endphp

                                <a href="{{ url($subRoute) }}"
                                   class="flex items-center w-full px-3 py-2 rounded-full mb-1 transition
                                   {{ $isSubActive 
                                        ? 'bg-blue-100 text-blue-700 font-semibold' 
                                        : 'text-gray-700 hover:bg-gray-100 hover:text-blue-600' 
                                   }}">

                                    <x-dynamic-component :component="$subIcon" class="w-4 h-4 mr-2" />
                                    <span>{{ $sub }}</span>
                                </a>
                            @endforeach

                        </div>
                    @endif

                </div>

            @endforeach
        @endforeach
{{-- LOGOUT --}}
<div class="flex items-center mt-4 mb-2">
    <span class="flex-grow border-b border-gray-300"></span>
    <span class="text-gray-500 text-xs font-bold px-2">LOGOUT</span>
    <span class="flex-grow border-b border-gray-300"></span>
</div>

<form method="POST" action="{{ route('logout') }}">
    @csrf

    <button type="submit"
        class="flex items-center px-3 py-2 rounded-full bg-red-600 hover:bg-red-700 text-white font-semibold w-56">

        <x-heroicon-o-arrow-right-on-rectangle class="w-5 h-5 mr-2" />
        Logout
    </button>

</form>
</aside>
