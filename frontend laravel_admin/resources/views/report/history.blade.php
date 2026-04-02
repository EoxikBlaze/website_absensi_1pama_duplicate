@extends('layouts.app')

@section('title', 'Report History Attendance')

@section('content')
<!-- Tailwind Animation Styles -->
@push('styles')
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out forwards;
        }
        input[type="date"]::-webkit-calendar-picker-indicator {
            cursor: pointer;
            opacity: 0.6;
            transition: 0.2s;
        }
        input[type="date"]::-webkit-calendar-picker-indicator:hover {
            opacity: 1;
        }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; cursor: pointer; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
@endpush

<div class="p-6 md:p-10 w-full max-w-[1400px] mx-auto animate-fade-in-up">
    
    <!-- Premium Header & Breadcrumbs -->
    <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <!-- Breadcrumb -->
            <div class="text-[11px] font-medium text-slate-500 mb-3 flex items-center gap-2">
                <span class="hover:text-blue-600 transition-colors cursor-pointer flex items-center gap-1.5">
                    <i class="w-3.5 h-3.5" data-lucide="bar-chart-2"></i> Report
                </span>
                <i class="w-3 h-3 text-slate-300" data-lucide="chevron-right"></i>
                <span class="text-blue-700 font-bold bg-blue-50 border border-blue-100 px-2.5 py-1 rounded-md text-[10px] tracking-wide shadow-sm">History Attendance</span>
            </div>
            <!-- Title -->
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-[#0052cc] to-blue-500 flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                    <i class="w-5 h-5" data-lucide="file-clock"></i>
                </div>
                <h1 class="text-2xl md:text-[28px] font-[900] text-transparent bg-clip-text bg-gradient-to-r from-slate-900 to-slate-600 tracking-tight leading-none">Report History Attendance</h1>
            </div>
        </div>
        
        <!-- Live Clock or Quick Info -->
        <div class="hidden lg:flex items-center gap-2 bg-white px-4 py-2 rounded-xl shadow-sm border border-slate-100">
            <i class="w-4 h-4 text-emerald-500" data-lucide="Activity"></i>
            <span class="text-xs font-bold text-slate-600">Database Connected</span>
        </div>
    </div>

    <!-- Filter Parameter Block (Glass & Gradient Aesthetic) -->
    <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/40 border border-slate-100 overflow-visible mb-10 transition-all duration-300 hover:shadow-2xl hover:shadow-slate-200/50">
        <!-- Colored Header -->
        <div class="bg-gradient-to-r from-[#0052cc] via-[#1d4ed8] to-[#1e3a8a] px-6 py-4 flex items-center justify-between rounded-t-2xl">
            <div class="flex items-center gap-3">
                <div class="bg-white/20 p-2 rounded-lg backdrop-blur-md border border-white/10 shadow-inner">
                    <i class="w-4 h-4 text-white" data-lucide="sliders-horizontal"></i>
                </div>
                <span class="text-white font-extrabold text-[13px] tracking-widest uppercase text-shadow-sm">Filter Parameter</span>
            </div>
        </div>
        
        <!-- Filter Form Area (Wrapped in Native HTML Form for automatic resets and future GET submissions) -->
        <form action="{{ route('report.history') }}" method="GET" class="p-7 md:p-8">
            <!-- First Row Selects: Shadcn-like Combobox -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-7">
                
                <!-- Divisi Combobox -->
                <div class="custom-combobox group relative flex flex-col" data-name="divisi" data-options='[{"l":"ALL","v":"ALL"},{"l":"OPRT","v":"OPRT"},{"l":"ENGG","v":"ENGG"},{"l":"HCGS","v":"HCGS"}]'>
                    <label class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2.5 ml-1 transition-colors group-focus-within:text-blue-600">DIVISI</label>
                    <input type="hidden" name="divisi" value="{{ request('divisi') }}" required>
                    <button type="button" class="combobox-btn w-full bg-slate-50/50 border border-slate-200 rounded-xl py-3 px-4 text-[13px] text-slate-400 font-bold outline-none focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all cursor-pointer flex justify-between items-center shadow-sm hover:border-blue-300">
                        <span class="combobox-val truncate">SELECT</span>
                        <i class="w-4 h-4 text-slate-400 shrink-0 transition-transform duration-200 combobox-arrow" data-lucide="chevron-down"></i>
                    </button>
                    <!-- Dropdown -->
                    <div class="combobox-menu hidden absolute top-[70px] z-[60] w-full bg-white border border-slate-200 rounded-xl shadow-2xl shadow-slate-200/50 overflow-hidden opacity-0 origin-top scale-95 transition-all duration-200 pointer-events-none">
                        <div class="p-2 border-b border-slate-100 flex items-center gap-2 bg-slate-50/50">
                            <i class="w-4 h-4 text-slate-400 ml-1 shrink-0" data-lucide="search"></i>
                            <input type="text" class="combobox-search w-full bg-transparent text-[13px] text-slate-800 font-bold outline-none placeholder:text-slate-400 placeholder:font-medium py-1" placeholder="Cari divisi...">
                        </div>
                        <div class="combobox-list max-h-48 overflow-y-auto p-1.5 flex flex-col gap-0.5 custom-scrollbar"></div>
                        <div class="combobox-empty hidden p-4 text-center text-xs text-slate-500 font-medium">Brai, opsi tak ditemukan.</div>
                    </div>
                </div>

                <!-- Dept Combobox -->
                <div class="custom-combobox group relative flex flex-col" data-name="dept" data-options='[{"l":"ALL","v":"ALL"},{"l":"SHCG","v":"SHCG"},{"l":"MAINT","v":"MAINT"},{"l":"ADMIN","v":"ADMIN"}]'>
                    <label class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2.5 ml-1 transition-colors group-focus-within:text-blue-600">DEPT</label>
                    <input type="hidden" name="dept" value="{{ request('dept') }}" required>
                    <button type="button" class="combobox-btn w-full bg-slate-50/50 border border-slate-200 rounded-xl py-3 px-4 text-[13px] text-slate-400 font-bold outline-none focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all cursor-pointer flex justify-between items-center shadow-sm hover:border-blue-300">
                        <span class="combobox-val truncate">SELECT</span>
                        <i class="w-4 h-4 text-slate-400 shrink-0 transition-transform duration-200 combobox-arrow" data-lucide="chevron-down"></i>
                    </button>
                    <!-- Dropdown -->
                    <div class="combobox-menu hidden absolute top-[70px] z-[60] w-full bg-white border border-slate-200 rounded-xl shadow-2xl shadow-slate-200/50 overflow-hidden opacity-0 origin-top scale-95 transition-all duration-200 pointer-events-none">
                        <div class="p-2 border-b border-slate-100 flex items-center gap-2 bg-slate-50/50">
                            <i class="w-4 h-4 text-slate-400 ml-1 shrink-0" data-lucide="search"></i>
                            <input type="text" class="combobox-search w-full bg-transparent text-[13px] text-slate-800 font-bold outline-none placeholder:text-slate-400 placeholder:font-medium py-1" placeholder="Cari departemen...">
                        </div>
                        <div class="combobox-list max-h-48 overflow-y-auto p-1.5 flex flex-col gap-0.5 custom-scrollbar"></div>
                        <div class="combobox-empty hidden p-4 text-center text-xs text-slate-500 font-medium">Brai, opsi tak ditemukan.</div>
                    </div>
                </div>

                <!-- Perusahaan Combobox -->
                <div class="custom-combobox group relative flex flex-col" data-name="perusahaan" data-options='[{"l":"ALL","v":"ALL"},{"l":"PAMA PERSADA","v":"PAMA"},{"l":"SUBCONTRACTOR","v":"SUBCONT"}]'>
                    <label class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2.5 ml-1 transition-colors group-focus-within:text-blue-600">PERUSAHAAN</label>
                    <input type="hidden" name="perusahaan" value="{{ request('perusahaan') }}" required>
                    <button type="button" class="combobox-btn w-full bg-slate-50/50 border border-slate-200 rounded-xl py-3 px-4 text-[13px] text-slate-400 font-bold outline-none focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all cursor-pointer flex justify-between items-center shadow-sm hover:border-blue-300">
                        <span class="combobox-val truncate">SELECT</span>
                        <i class="w-4 h-4 text-slate-400 shrink-0 transition-transform duration-200 combobox-arrow" data-lucide="chevron-down"></i>
                    </button>
                    <!-- Dropdown -->
                    <div class="combobox-menu hidden absolute top-[70px] z-[60] w-full bg-white border border-slate-200 rounded-xl shadow-2xl shadow-slate-200/50 overflow-hidden opacity-0 origin-top scale-95 transition-all duration-200 pointer-events-none">
                        <div class="p-2 border-b border-slate-100 flex items-center gap-2 bg-slate-50/50">
                            <i class="w-4 h-4 text-slate-400 ml-1 shrink-0" data-lucide="search"></i>
                            <input type="text" class="combobox-search w-full bg-transparent text-[13px] text-slate-800 font-bold outline-none placeholder:text-slate-400 placeholder:font-medium py-1" placeholder="Cari perusahaan...">
                        </div>
                        <div class="combobox-list max-h-48 overflow-y-auto p-1.5 flex flex-col gap-0.5 custom-scrollbar"></div>
                        <div class="combobox-empty hidden p-4 text-center text-xs text-slate-500 font-medium">Brai, opsi tak ditemukan.</div>
                    </div>
                </div>

                <!-- Distrik Combobox -->
                <div class="custom-combobox group relative flex flex-col" data-name="distrik" data-options='[{"l":"ARIA","v":"ARIA"},{"l":"KIDE","v":"KIDE"},{"l":"JMB","v":"JMB"}]'>
                    <label class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2.5 ml-1 transition-colors group-focus-within:text-blue-600">DISTRIK</label>
                    <input type="hidden" name="distrik" value="{{ request('distrik') }}" required>
                    <button type="button" class="combobox-btn w-full bg-slate-50/50 border border-slate-200 rounded-xl py-3 px-4 text-[13px] text-slate-400 font-bold outline-none focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all cursor-pointer flex justify-between items-center shadow-sm hover:border-blue-300">
                        <span class="combobox-val truncate">SELECT</span>
                        <i class="w-4 h-4 text-slate-400 shrink-0 transition-transform duration-200 combobox-arrow" data-lucide="chevron-down"></i>
                    </button>
                    <!-- Dropdown -->
                    <div class="combobox-menu hidden absolute top-[70px] z-[60] w-full bg-white border border-slate-200 rounded-xl shadow-2xl shadow-slate-200/50 overflow-hidden opacity-0 origin-top scale-95 transition-all duration-200 pointer-events-none">
                        <div class="p-2 border-b border-slate-100 flex items-center gap-2 bg-slate-50/50">
                            <i class="w-4 h-4 text-slate-400 ml-1 shrink-0" data-lucide="search"></i>
                            <input type="text" class="combobox-search w-full bg-transparent text-[13px] text-slate-800 font-bold outline-none placeholder:text-slate-400 placeholder:font-medium py-1" placeholder="Cari distrik...">
                        </div>
                        <div class="combobox-list max-h-48 overflow-y-auto p-1.5 flex flex-col gap-0.5 custom-scrollbar"></div>
                        <div class="combobox-empty hidden p-4 text-center text-xs text-slate-500 font-medium">Brai, opsi tak ditemukan.</div>
                    </div>
                </div>
            </div>

            <!-- Second Row (Dates) -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Date 1 -->
                <div class="flex flex-col md:col-span-1 group">
                    <label class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2.5 ml-1 transition-colors group-focus-within:text-blue-600 flex items-center gap-1.5">
                        <i class="w-3 h-3" data-lucide="calendar"></i> DARI TANGGAL
                    </label>
                    <div class="relative">
                        <input type="date" name="start_date" value="{{ request('start_date', date('Y-m-d')) }}" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl py-2.5 px-4 text-[13px] text-slate-800 font-bold outline-none focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all cursor-text shadow-sm"/>
                    </div>
                </div>
                <!-- Date 2 -->
                <div class="flex flex-col md:col-span-1 group">
                    <label class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2.5 ml-1 transition-colors group-focus-within:text-blue-600 flex items-center gap-1.5">
                        <i class="w-3 h-3" data-lucide="calendar-check"></i> SAMPAI TANGGAL
                    </label>
                    <div class="relative">
                        <input type="date" name="end_date" value="{{ request('end_date', date('Y-m-d')) }}" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl py-2.5 px-4 text-[13px] text-slate-800 font-bold outline-none focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all cursor-text shadow-sm"/>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-slate-100">
                <a href="{{ route('report.history') }}" class="px-8 py-3 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 font-extrabold text-[11px] rounded-xl transition-all hover:shadow-sm active:scale-95 uppercase tracking-widest">
                    RESET
                </a>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-[#0052cc] to-blue-600 hover:from-[#0047b3] hover:to-blue-700 text-white font-extrabold text-[11px] rounded-xl shadow-lg shadow-blue-500/30 transition-all hover:-translate-y-0.5 active:scale-95 uppercase tracking-widest flex items-center gap-2">
                    <i class="w-4 h-4" data-lucide="search"></i> VIEW
                </button>
            </div>
        </form>
    </div>

    <!-- Data Table Block (Modernized) -->
    <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden">
        
        <!-- Premium Table Header -->
        <div class="px-8 py-5 flex flex-col md:flex-row md:justify-between md:items-center gap-4 border-b border-slate-100 bg-slate-50/30">
            <div class="flex items-center gap-3">
                <div class="w-2 h-6 bg-emerald-500 rounded-full"></div>
                <h3 class="font-extrabold text-slate-800 text-[15px] tracking-wide">Attendance Data Records</h3>
            </div>
            <a href="{{ route('report.history.export') }}" class="bg-gradient-to-r from-[#10b981] to-emerald-600 hover:from-[#059669] hover:to-emerald-700 text-white px-5 py-2.5 rounded-xl font-bold text-[11px] flex items-center justify-center gap-2 transition-all shadow-lg shadow-emerald-500/30 hover:-translate-y-0.5 active:scale-95 uppercase tracking-wider">
                <i class="w-4 h-4" data-lucide="file-spreadsheet"></i> 
                Export to Excel
            </a>
        </div>

        <!-- Table Content -->
        <div class="w-full overflow-x-auto">
            <table class="w-full text-left whitespace-nowrap">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-200 text-[10px] text-slate-500 font-extrabold uppercase tracking-widest">
                        <th class="px-8 py-4">Attendance Date</th>
                        <th class="px-4 py-4">Attendance Hour</th>
                        <th class="px-4 py-4">NRP</th>
                        <th class="px-4 py-4">Nama Lengkap</th>
                        <th class="px-4 py-4">Distrik</th>
                        <th class="px-4 py-4">Posisi</th>
                        <th class="px-4 py-4">Divisi</th>
                        <th class="px-4 py-4 align-center">Trans</th>
                        <th class="px-4 py-4">Lokasi</th>
                        <th class="px-4 py-4">CP Location</th>
                        <th class="px-8 py-4 text-right">Att Location</th>
                    </tr>
                </thead>
                <tbody class="text-[12px] font-medium text-slate-600 divide-y divide-slate-100/80">
                    
                    @forelse($attendances as $row)
                        @php
                            // Parsing waktu khusus untuk Format WITA menyesuaikan string UTC/ISO Node.js (05:55:17)
                            $waktuAbsen = isset($row['time_wita']) ? \Carbon\Carbon::parse($row['time_wita'])->format('H:i:s') : '-';
                            $tanggalAbsen = isset($row['attendance_date']) ? \Carbon\Carbon::parse($row['attendance_date'])->format('Y-m-d') : '-';
                            
                            $isCheckIn = ($row['trans_type'] ?? '') === 'Check_in';
                            $transLabel = $isCheckIn ? 'IN' : 'OUT';
                            $transColor = $isCheckIn ? 'text-emerald-700 bg-emerald-100 border-emerald-200/50' : 'text-red-700 bg-red-100 border-red-200/50';
                            $dotColor = $isCheckIn ? 'bg-emerald-500' : 'bg-red-500';

                            // Substitusi field kosong atau belum di JOIN oleh API Backend API saat ini
                            $namaKaryawan = $row['employee']['full_name'] ?? session('user.employee_data.full_name') ?? session('user.nrp') ?? '-';
                        @endphp
                        <tr class="hover:bg-blue-50/30 transition-colors duration-200 group">
                            <td class="px-8 py-4 text-[#111827] font-semibold">{{ $tanggalAbsen }}</td>
                            <td class="px-4 py-4 font-mono text-slate-500">{{ $waktuAbsen }}</td>
                            <td class="px-4 py-4 text-[#0052cc] font-extrabold tracking-wide cursor-pointer group-hover:underline">{{ $row['nrp'] ?? '-' }}</td>
                            <td class="px-4 py-4 text-[#111827] font-extrabold">{{ $namaKaryawan }}</td>
                            <td class="px-4 py-4">{{ $row['employee']['mitra_kerja']['mitra_kerja_name'] ?? '-' }}</td>
                            <td class="px-4 py-4">{{ $row['employee']['position']['pos_name'] ?? '-' }}</td>
                            <td class="px-4 py-4">{{ $row['employee']['division']['div_name'] ?? '-' }}</td>
                            <td class="px-4 py-4">
                                <span class="{{ $transColor }} px-2.5 py-1 rounded-md text-[10px] font-extrabold uppercase shadow-sm border flex items-center justify-center w-max gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $dotColor }} animate-pulse"></span> {{ $transLabel }}
                                </span>
                            </td>
                            <td class="px-4 py-4 font-bold text-slate-700">{{ $row['work_location'] ?? 'WFO' }}</td>
                            <td class="px-4 py-4">{{ $row['cp_location'] ?? '-' }}</td>
                            <td class="px-8 py-4 text-right text-slate-400 italic font-medium tracking-wide">
                                {{ isset($row['att_latitude']) ? round($row['att_latitude'], 4) . ',' . round($row['att_longitude'], 4) : '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-8 py-16 text-center">
                                <div class="flex flex-col items-center justify-center w-full">
                                    <div class="w-16 h-16 mb-4 rounded-full bg-slate-100 flex items-center justify-center text-slate-300">
                                        <i class="w-8 h-8" data-lucide="inbox"></i>
                                    </div>
                                    <h4 class="text-slate-700 font-extrabold text-[15px] mb-1">Belum Ada Riwayat Absensi</h4>
                                    <p class="text-slate-500 text-[12px] font-medium max-w-sm mx-auto">Data rekaman kehadiran absensi online untuk periode ini belum ditemukan secara keseluruhan di Database Node.js.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
        
        <!-- Table Footer Pagination Proxy -->
        <div class="px-8 py-4 border-t border-slate-100 bg-slate-50/30 flex justify-between items-center text-xs font-bold text-slate-400">
            <span>Showing 1 to 3 of 150 entries</span>
            <div class="flex gap-2">
                <button class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-200 bg-white hover:bg-slate-50 text-slate-400 transition-colors shadow-sm"><i class="w-4 h-4" data-lucide="chevron-left"></i></button>
                <button class="w-8 h-8 rounded-lg flex items-center justify-center border border-[#0052cc] bg-[#0052cc] text-white shadow-md shadow-blue-500/30 font-bold">1</button>
                <button class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 transition-colors shadow-sm font-bold">2</button>
                <button class="w-8 h-8 rounded-lg flex items-center justify-center border border-slate-200 bg-white hover:bg-slate-50 text-slate-400 transition-colors shadow-sm"><i class="w-4 h-4" data-lucide="chevron-right"></i></button>
            </div>
        </div>
    </div>
    
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Shadcn Combobox Replacer Engine (Vanilla JS)
        document.querySelectorAll('.custom-combobox').forEach(combo => {
            const options = JSON.parse(combo.getAttribute('data-options'));
            const btn = combo.querySelector('.combobox-btn');
            const valText = combo.querySelector('.combobox-val');
            const arrow = combo.querySelector('.combobox-arrow');
            const menu = combo.querySelector('.combobox-menu');
            const search = combo.querySelector('.combobox-search');
            const list = combo.querySelector('.combobox-list');
            const emptyMsg = combo.querySelector('.combobox-empty');
            const hiddenInput = combo.querySelector('input[type="hidden"]');
            
            let isOpen = false;

            const renderOptions = (filterText = "") => {
                list.innerHTML = "";
                let count = 0;
                
                options.forEach(opt => {
                    if(opt.l.toLowerCase().includes(filterText.toLowerCase())) {
                        count++;
                        const isSelected = hiddenInput.value === opt.v;
                        const item = document.createElement('div');
                        item.className = `px-3 py-2 text-[12px] font-bold rounded-lg cursor-pointer flex justify-between items-center transition-all duration-150 select-none ${isSelected ? 'bg-blue-50 text-[#0052cc]' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'}`;
                        
                        item.innerHTML = `
                            <span class="truncate pr-2">${opt.l}</span>
                            ${isSelected ? '<i class="w-4 h-4 text-[#0052cc] shrink-0" data-lucide="check"></i>' : ''}
                        `;
                        
                        item.addEventListener('click', (e) => {
                            e.stopPropagation();
                            hiddenInput.value = opt.v;
                            valText.textContent = opt.l;
                            valText.classList.replace('text-slate-400', 'text-slate-800');
                            closeMenu();
                            renderOptions(); // To refresh checkmarks
                            if(typeof lucide !== 'undefined') lucide.createIcons();
                        });
                        
                        list.appendChild(item);
                    }
                });
                
                if(count === 0) emptyMsg.classList.remove('hidden');
                else emptyMsg.classList.add('hidden');
                
                if(typeof lucide !== 'undefined') lucide.createIcons();
            };

            const openMenu = () => {
                // Ensure sibling menus are closed properly
                document.querySelectorAll('.combobox-menu:not(.hidden)').forEach(el => {
                    el.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
                    setTimeout(() => el.classList.add('hidden'), 200);
                    // Reset arrow visual for others
                    const t_arrow = el.parentElement.querySelector('.combobox-arrow');
                    if(t_arrow) t_arrow.classList.remove('rotate-180');
                });

                isOpen = true;
                menu.classList.remove('hidden');
                menu.classList.remove('pointer-events-none');
                
                // Force HTML reflow for transiton
                void menu.offsetWidth;
                
                menu.classList.remove('opacity-0', 'scale-95');
                arrow.classList.add('rotate-180');
                
                search.value = "";
                renderOptions();
                setTimeout(() => search.focus(), 50);
            };

            const closeMenu = () => {
                isOpen = false;
                arrow.classList.remove('rotate-180');
                menu.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
                setTimeout(() => {
                    if(!isOpen) menu.classList.add('hidden');
                }, 200);
            };

            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                if(isOpen) closeMenu();
                else openMenu();
            });

            search.addEventListener('input', (e) => {
                renderOptions(e.target.value);
            });
            
            menu.addEventListener('click', (e) => e.stopPropagation());

            // Global Click outside detector
            document.addEventListener('click', () => {
                if(isOpen) closeMenu();
            });

            // Hydration (Reload retain value based on hidden input)
            if(hiddenInput.value) {
                const found = options.find(o => o.v === hiddenInput.value);
                if(found) {
                    valText.textContent = found.l;
                    valText.classList.replace('text-slate-400', 'text-slate-800');
                }
            }

            renderOptions();
        });
    });
</script>
@endpush
