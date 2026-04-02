<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Presensi Subcontractor - @yield('title', 'Dashboard')</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; display: none; }
        .sidebar-scroll:hover::-webkit-scrollbar-thumb { display: block; }
    </style>
    @stack('styles')
</head>
<body class="bg-[#f8f9fb] min-h-screen flex overflow-hidden">

    <!-- Pure CSS Auto-Hover Sidebar (White/Blue Theme) -->
    <!-- Collapsed default state: w-[80px]. Expands on Hover to w-72 -->
    <aside id="mainSidebar" class="group/sidebar w-[80px] hover:w-72 bg-white border-r border-[#f1f5f9] flex flex-col shrink-0 z-20 h-screen transition-all duration-300 ease-out relative overflow-hidden">
        
        <!-- Application Brands Block -->
        <div class="px-5 py-6 flex items-center">
            <div class="flex items-center gap-0 group-hover/sidebar:gap-3 overflow-hidden w-full transition-all duration-300">
                <div class="w-10 h-10 group-hover/sidebar:w-8 group-hover/sidebar:h-8 rounded-xl group-hover/sidebar:rounded-lg bg-gradient-to-br from-[#0052cc] to-blue-500 flex items-center justify-center text-white shrink-0 shadow-md shadow-blue-500/20 transition-all duration-300 relative left-[-2px] group-hover/sidebar:left-0">
                    <i class="w-5 h-5 group-hover/sidebar:w-4 group-hover/sidebar:h-4" data-lucide="activity"></i>
                </div>
                <!-- Brand Text (Hidden fully until hover) -->
                <div class="flex flex-col whitespace-nowrap overflow-hidden transition-all duration-300 max-w-0 opacity-0 group-hover/sidebar:max-w-[200px] group-hover/sidebar:opacity-100">
                    <span class="text-[12px] font-[900] text-[#111827] tracking-wider uppercase leading-tight">PAMA SUBCONT</span>
                    <span class="text-[10px] font-semibold text-slate-400">Portal Management</span>
                </div>
            </div>
        </div>

        <!-- Inline Search -->
        <div class="px-4 group-hover/sidebar:px-5 mb-4 transition-all duration-300">
            <div class="relative flex items-center justify-center group-hover/sidebar:justify-start bg-transparent group-hover/sidebar:bg-slate-50 border border-transparent group-hover/sidebar:border-slate-100 rounded-lg transition-all px-2 group-hover/sidebar:px-3 py-2 cursor-pointer group-hover/sidebar:cursor-text">
                <i class="w-5 h-5 group-hover/sidebar:w-4 group-hover/sidebar:h-4 text-slate-400 shrink-0" data-lucide="search"></i>
                <input type="text" placeholder="Quick search..." class="bg-transparent border-none p-0 text-[12px] text-[#2c3e50] font-medium outline-none overflow-hidden transition-all duration-300 w-0 opacity-0 group-hover/sidebar:w-full group-hover/sidebar:ml-2 group-hover/sidebar:opacity-100 placeholder-slate-400 focus:ring-0 shadow-none">
            </div>
        </div>

        <!-- Navigation List -->
        <div class="flex-1 overflow-y-auto sidebar-scroll px-3 flex flex-col gap-6 pt-2">
            
            <!-- Section: Overview -->
            <div class="flex flex-col gap-1">
                <div class="px-3 overflow-hidden transition-all duration-300 max-h-0 opacity-0 group-hover/sidebar:max-h-[20px] group-hover/sidebar:mb-1 group-hover/sidebar:opacity-100">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Overview</span>
                </div>
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" title="Dashboard" class="flex items-center justify-center group-hover/sidebar:justify-start gap-0 group-hover/sidebar:gap-3 px-3 py-3 group-hover/sidebar:py-2.5 rounded-lg font-bold text-[13px] transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-50/80 text-[#0052cc]' : 'text-slate-500 hover:bg-slate-50 hover:text-[#2c3e50]' }}">
                    <i class="w-5 h-5 group-hover/sidebar:w-4 group-hover/sidebar:h-4 shrink-0 transition-all duration-200" data-lucide="layout-grid"></i>
                    <span class="whitespace-nowrap overflow-hidden transition-all duration-300 max-w-0 opacity-0 group-hover/sidebar:max-w-[150px] group-hover/sidebar:opacity-100">Dashboard</span>
                </a>
            </div>

            <!-- Section: Analytics -->
            <div class="flex flex-col gap-1">
                <div class="px-3 overflow-hidden transition-all duration-300 max-h-0 opacity-0 group-hover/sidebar:max-h-[20px] group-hover/sidebar:mb-1 group-hover/sidebar:opacity-100">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Analytics</span>
                </div>
                
                <!-- Report Accordion -->
                <div>
                    <button onclick="toggleReportMenu()" title="Report Analytics" class="flex items-center justify-center group-hover/sidebar:justify-between w-full px-3 py-3 group-hover/sidebar:py-2.5 rounded-lg font-bold text-[13px] transition-colors group {{ request()->routeIs('report.*') ? 'bg-blue-50/80 text-[#0052cc]' : 'text-slate-500 hover:bg-slate-50 hover:text-[#2c3e50]' }}">
                        <div class="flex items-center gap-0 group-hover/sidebar:gap-3 overflow-hidden justify-center group-hover/sidebar:justify-start">
                            <i class="w-5 h-5 group-hover/sidebar:w-4 group-hover/sidebar:h-4 shrink-0 transition-all duration-200" data-lucide="bar-chart-2"></i>
                            <span class="whitespace-nowrap overflow-hidden transition-all duration-300 max-w-0 opacity-0 group-hover/sidebar:max-w-[150px] group-hover/sidebar:opacity-100">Report Analytics</span>
                        </div>
                        <i id="reportChevron" class="shrink-0 transition-all duration-300 overflow-hidden max-w-0 opacity-0 group-hover/sidebar:max-w-[16px] group-hover/sidebar:w-4 group-hover/sidebar:h-4 group-hover/sidebar:opacity-100 {{ request()->routeIs('report.*') ? 'rotate-180' : '' }}" data-lucide="chevron-down"></i>
                    </button>
                    
                    <!-- Sub Menu -->
                    <!-- We add 'group-hover/sidebar:grid' trick to completely hide submenu when sidebar is collapsed, preventing child squishing -->
                    <div id="reportSubMenu" class="transition-all duration-300 ease-in-out {{ request()->routeIs('report.*') && !request()->routeIs('report.geofence') ? 'grid-rows-[1fr] opacity-100 mt-1' : 'grid-rows-[0fr] opacity-0' }} hidden group-hover/sidebar:grid">
                        <div class="overflow-hidden flex flex-col gap-0.5 transition-all duration-300 px-1 group-hover/sidebar:pl-9 group-hover/sidebar:pr-2">
                            <a href="{{ route('report.history') }}" title="History Attendance" class="py-2.5 px-3 rounded-lg text-[12px] font-semibold transition-colors flex items-center justify-center group-hover/sidebar:justify-start gap-0 group-hover/sidebar:gap-2 {{ request()->routeIs('report.history') ? 'text-[#0052cc] bg-blue-50/50' : 'text-slate-500 hover:text-[#2c3e50] hover:bg-slate-50' }}">
                                <i class="w-4 h-4 group-hover/sidebar:w-3.5 group-hover/sidebar:h-3.5 shrink-0 transition-all duration-200" data-lucide="clipboard-list"></i>
                                <span class="whitespace-nowrap overflow-hidden transition-all duration-300 max-w-0 opacity-0 group-hover/sidebar:max-w-[150px] group-hover/sidebar:opacity-100">History Attendance</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section: Data Management -->
            <div class="flex flex-col gap-1">
                <div class="px-3 overflow-hidden transition-all duration-300 max-h-0 opacity-0 group-hover/sidebar:max-h-[20px] group-hover/sidebar:mb-1 group-hover/sidebar:opacity-100">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Data Management</span>
                </div>
                
                <!-- Master Data Accordion -->
                <div>
                    <button onclick="toggleMasterMenu()" title="Master Data" class="flex items-center justify-center group-hover/sidebar:justify-between w-full px-3 py-3 group-hover/sidebar:py-2.5 rounded-lg font-bold text-[13px] transition-colors group {{ request()->routeIs('master.*') || request()->routeIs('report.geofence') ? 'bg-blue-50/80 text-[#0052cc]' : 'text-slate-500 hover:bg-slate-50 hover:text-[#2c3e50]' }}">
                        <div class="flex items-center gap-0 group-hover/sidebar:gap-3 overflow-hidden justify-center group-hover/sidebar:justify-start">
                            <i class="w-5 h-5 group-hover/sidebar:w-4 group-hover/sidebar:h-4 shrink-0 transition-all duration-200" data-lucide="database"></i>
                            <span class="whitespace-nowrap overflow-hidden transition-all duration-300 max-w-0 opacity-0 group-hover/sidebar:max-w-[150px] group-hover/sidebar:opacity-100">Master Data</span>
                        </div>
                        <i id="masterChevron" class="shrink-0 transition-all duration-300 overflow-hidden max-w-0 opacity-0 group-hover/sidebar:max-w-[16px] group-hover/sidebar:w-4 group-hover/sidebar:h-4 group-hover/sidebar:opacity-100 {{ request()->routeIs('master.*') || request()->routeIs('report.geofence') ? 'rotate-180' : '' }}" data-lucide="chevron-down"></i>
                    </button>
                    
                    <!-- Sub Menu -->
                    <div id="masterSubMenu" class="transition-all duration-300 ease-in-out {{ request()->routeIs('master.*') || request()->routeIs('report.geofence') ? 'grid-rows-[1fr] opacity-100 mt-1' : 'grid-rows-[0fr] opacity-0' }} hidden group-hover/sidebar:grid">
                        <div class="overflow-hidden flex flex-col gap-0.5 transition-all duration-300 px-1 group-hover/sidebar:pl-9 group-hover/sidebar:pr-2">
                            <a href="{{ route('master.shifts') }}" title="Kelola Shift" class="py-2.5 px-3 rounded-lg text-[12px] font-semibold transition-colors flex items-center justify-center group-hover/sidebar:justify-start gap-0 group-hover/sidebar:gap-2 {{ request()->routeIs('master.shifts') ? 'text-[#0052cc] bg-blue-50/50' : 'text-slate-500 hover:text-[#2c3e50] hover:bg-slate-50' }}">
                                <i class="w-4 h-4 group-hover/sidebar:w-3.5 group-hover/sidebar:h-3.5 shrink-0 transition-all duration-200" data-lucide="clock"></i>
                                <span class="whitespace-nowrap overflow-hidden transition-all duration-300 max-w-0 opacity-0 group-hover/sidebar:max-w-[150px] group-hover/sidebar:opacity-100">Shift Kerja</span>
                            </a>
                            <a href="{{ route('master.departments') }}" title="Kelola Departemen" class="py-2.5 px-3 rounded-lg text-[12px] font-semibold transition-colors flex items-center justify-center group-hover/sidebar:justify-start gap-0 group-hover/sidebar:gap-2 {{ request()->routeIs('master.departments') ? 'text-[#0052cc] bg-blue-50/50' : 'text-slate-500 hover:text-[#2c3e50] hover:bg-slate-50' }}">
                                <i class="w-4 h-4 group-hover/sidebar:w-3.5 group-hover/sidebar:h-3.5 shrink-0 transition-all duration-200" data-lucide="briefcase"></i>
                                <span class="whitespace-nowrap overflow-hidden transition-all duration-300 max-w-0 opacity-0 group-hover/sidebar:max-w-[150px] group-hover/sidebar:opacity-100">Depart. & Divisi</span>
                            </a>
                            <a href="{{ route('master.positions') }}" title="Kelola Jabatan" class="py-2.5 px-3 rounded-lg text-[12px] font-semibold transition-colors flex items-center justify-center group-hover/sidebar:justify-start gap-0 group-hover/sidebar:gap-2 {{ request()->routeIs('master.positions') ? 'text-[#0052cc] bg-blue-50/50' : 'text-slate-500 hover:text-[#2c3e50] hover:bg-slate-50' }}">
                                <i class="w-4 h-4 group-hover/sidebar:w-3.5 group-hover/sidebar:h-3.5 shrink-0 transition-all duration-200" data-lucide="award"></i>
                                <span class="whitespace-nowrap overflow-hidden transition-all duration-300 max-w-0 opacity-0 group-hover/sidebar:max-w-[150px] group-hover/sidebar:opacity-100">Jabatan Karir</span>
                            </a>
                            <a href="{{ route('report.geofence') }}" title="Area Geofence" class="py-2.5 px-3 rounded-lg text-[12px] font-semibold transition-colors flex items-center justify-center group-hover/sidebar:justify-start gap-0 group-hover/sidebar:gap-2 {{ request()->routeIs('report.geofence') ? 'text-[#0052cc] bg-blue-50/50' : 'text-slate-500 hover:text-[#2c3e50] hover:bg-slate-50' }}">
                                <i class="w-4 h-4 group-hover/sidebar:w-3.5 group-hover/sidebar:h-3.5 shrink-0 transition-all duration-200" data-lucide="map-pinned"></i>
                                <span class="whitespace-nowrap overflow-hidden transition-all duration-300 max-w-0 opacity-0 group-hover/sidebar:max-w-[150px] group-hover/sidebar:opacity-100">Geofence Lokasi</span>
                            </a>
                            <a href="{{ route('master.mitra') }}" title="Kelola Perusahaan Subcontractor" class="py-2.5 px-3 rounded-lg text-[12px] font-semibold transition-colors flex items-center justify-center group-hover/sidebar:justify-start gap-0 group-hover/sidebar:gap-2 {{ request()->routeIs('master.mitra') ? 'text-[#0052cc] bg-blue-50/50' : 'text-slate-500 hover:text-[#2c3e50] hover:bg-slate-50' }}">
                                <i class="w-4 h-4 group-hover/sidebar:w-3.5 group-hover/sidebar:h-3.5 shrink-0 transition-all duration-200" data-lucide="building-2"></i>
                                <span class="whitespace-nowrap overflow-hidden transition-all duration-300 max-w-0 opacity-0 group-hover/sidebar:max-w-[150px] group-hover/sidebar:opacity-100">Perusahaan Subcont</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom User / Logout Section -->
        <div class="px-4 py-4 border-t border-slate-100 bg-white transition-all w-full mt-auto">
            <div class="flex items-center justify-center group-hover/sidebar:justify-between p-1 group-hover/sidebar:px-2 group-hover/sidebar:py-2 rounded-xl transition-all cursor-pointer hover:bg-slate-50 relative group/user">
                
                <!-- Avatar & Info -->
                <div class="flex items-center gap-0 group-hover/sidebar:gap-3 overflow-hidden">
                    <div class="w-10 h-10 rounded-full overflow-hidden shrink-0 border-2 border-white shadow-sm transition-all group-hover/sidebar:w-9 group-hover/sidebar:h-9">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(session('user.employee_data.full_name') ?? session('user.nrp') ?? 'Admin') }}&rounded=true&background=f1f5f9&color=0052cc&bold=true" alt="Avatar" class="w-full h-full object-cover"/>
                    </div>
                    <div class="flex-col justify-center whitespace-nowrap overflow-hidden transition-all duration-300 w-0 opacity-0 group-hover/sidebar:w-auto group-hover/sidebar:max-w-[130px] group-hover/sidebar:opacity-100 hidden group-hover/sidebar:flex">
                        <span class="text-[13px] font-bold text-[#2c3e50] truncate leading-tight">{{ session('user.employee_data.full_name') ?? 'Administrator' }}</span>
                        <span class="text-[10px] font-bold text-slate-400 truncate">{{ session('user.nrp') ?? 'SYSTEM' }}</span>
                    </div>
                </div>

                <!-- Logout Button -->
                <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Sign out" class="w-0 h-0 opacity-0 overflow-hidden shrink-0 flex items-center justify-center rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 transition-all duration-300 group-hover/sidebar:w-8 group-hover/sidebar:h-8 group-hover/sidebar:opacity-100 ml-auto">
                    <i class="w-[18px] h-[18px]" data-lucide="log-out"></i>
                </button>
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </aside>

    <!-- Main Workspace -->
    <main class="flex-1 flex flex-col relative z-0 bg-[#f8f9fb] h-screen overflow-y-auto w-full">
        <!-- Top Mobile Header (Hidden on Desktop because merged into Sidebar) -->
        <header class="sticky top-0 z-10 bg-white/80 backdrop-blur-md border-b border-slate-100 h-[60px] px-5 flex justify-between items-center shrink-0 w-full md:hidden">
            <div class="flex items-center gap-3">
                <div class="w-7 h-7 rounded-md bg-gradient-to-br from-[#0052cc] to-blue-500 flex items-center justify-center text-white shadow-sm shadow-blue-500/20">
                    <i class="w-3.5 h-3.5" data-lucide="activity"></i>
                </div>
                <span class="font-bold text-[#111827] text-[13px] uppercase tracking-wider">PAMA SUBCONT</span>
            </div>
            <button class="text-slate-500 hover:text-blue-600 focus:outline-none" onclick="toggleSidebarMobile()">
                <i class="w-6 h-6" data-lucide="menu"></i>
            </button>
        </header>

        <!-- Main Payload Screen -->
        <div class="flex-1 pb-10">
            @yield('content')
        </div>

        <!-- Inline Footer (Inside Main view to remove horizontal scrolling bloat) -->
        <footer class="bg-transparent py-5 px-6 md:px-10 flex flex-col sm:flex-row justify-between items-center text-[10px] font-bold text-slate-400 tracking-wider z-20 shrink-0 uppercase w-full mt-auto mt-10">
            <div class="mb-2 sm:mb-0 text-center text-slate-400">© 2026 PAMA SUBCONTRACTOR. ALL RIGHTS SECURED.</div>
            <nav class="flex gap-6">
                <a class="hover:text-blue-600 transition-colors cursor-pointer">Privacy</a>
                <a class="hover:text-blue-600 transition-colors cursor-pointer">Terms</a>
            </nav>
        </footer>
    </main>

    <!-- UI Interaction Scripts -->
    <script>
        lucide.createIcons();
        
        // Report Menu Collapse Logic
        function toggleReportMenu() {
            const menu = document.getElementById('reportSubMenu');
            const chevron = document.getElementById('reportChevron');
            toggleMenu(menu, chevron);
        }

        // Master Menu Collapse Logic
        function toggleMasterMenu() {
            const menu = document.getElementById('masterSubMenu');
            const chevron = document.getElementById('masterChevron');
            toggleMenu(menu, chevron);
        }

        function toggleMenu(menu, chevron) {
            if (menu.classList.contains('grid-rows-[0fr]')) {
                menu.classList.replace('grid-rows-[0fr]', 'grid-rows-[1fr]');
                menu.classList.replace('opacity-0', 'opacity-100');
                menu.classList.add('mt-1');
                chevron.classList.add('rotate-180');
            } else {
                menu.classList.replace('grid-rows-[1fr]', 'grid-rows-[0fr]');
                menu.classList.replace('opacity-100', 'opacity-0');
                menu.classList.remove('mt-1');
                chevron.classList.remove('rotate-180');
            }
        }

        // Mobile Off-canvas Slide Function
        function toggleSidebarMobile() {
            const sidebar = document.getElementById('mainSidebar');
            if (sidebar.classList.contains('hidden')) {
                sidebar.classList.remove('hidden');
                sidebar.classList.add('absolute', 'left-0', 'h-full', 'shadow-2xl', 'w-10/12', 'max-w-[300px]');
            } else {
                sidebar.classList.add('hidden');
                sidebar.classList.remove('absolute', 'left-0', 'h-full', 'shadow-2xl', 'w-10/12', 'max-w-[300px]');
            }
        }
        
        // Hide sidebar automatically by default on small windows
        window.addEventListener('DOMContentLoaded', () => {
             if (window.innerWidth < 768) {
                document.getElementById('mainSidebar').classList.add('hidden');
             }
        });
    </script>
    @stack('scripts')
</body>
</html>
