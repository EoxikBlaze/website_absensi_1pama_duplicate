@extends('layouts.app')

@section('title', 'Manajemen Shift Kerja')

@section('content')
<div class="p-6 md:p-10 w-full max-w-[1400px] mx-auto animate-fade-in-up">
    
    <!-- Premium Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <!-- Breadcrumb -->
            <div class="text-[11px] font-medium text-slate-500 mb-3 flex items-center gap-2">
                <span class="hover:text-blue-600 transition-colors cursor-pointer flex items-center gap-1.5">
                    <i class="w-3.5 h-3.5" data-lucide="database"></i> Data Master
                </span>
                <i class="w-3 h-3 text-slate-300" data-lucide="chevron-right"></i>
                <span class="text-blue-700 font-bold bg-blue-50 border border-blue-100 px-2.5 py-1 rounded-md text-[10px] tracking-wide shadow-sm">Shift Kerja</span>
            </div>
            <!-- Title -->
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-[#0052cc] to-blue-500 flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                    <i class="w-5 h-5" data-lucide="clock"></i>
                </div>
                <h1 class="text-2xl md:text-[28px] font-[900] text-transparent bg-clip-text bg-gradient-to-r from-slate-900 to-slate-600 tracking-tight leading-none">Pengaturan Shift</h1>
            </div>
        </div>
    </div>

    <!-- Alert Success/Error -->
    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-700 p-4 rounded-xl mb-6 font-bold text-sm border border-emerald-200 animate-fade-in-up">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="bg-red-50 text-red-700 p-4 rounded-xl mb-6 font-bold text-sm border border-red-200 animate-fade-in-up">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left: List -->
        <div class="lg:col-span-8 flex flex-col gap-4">
            <h3 class="font-extrabold text-slate-800 text-[15px] flex items-center gap-2">
                <i class="w-5 h-5 text-blue-500" data-lucide="list"></i> Daftar Shift (<span id="totalShift">{{ count($shifts) }}</span>)
            </h3>
            <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100">
                                <th class="py-4 px-5 text-[11px] font-extrabold text-slate-500 uppercase tracking-widest">Kode Shift</th>
                                <th class="py-4 px-5 text-[11px] font-extrabold text-slate-500 uppercase tracking-widest text-center">Jadwal Masuk</th>
                                <th class="py-4 px-5 text-[11px] font-extrabold text-slate-500 uppercase tracking-widest text-center">Jadwal Pulang</th>
                                <th class="py-4 px-5 text-[11px] font-extrabold text-slate-500 uppercase tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($shifts as $shift)
                            @php
                                $dIn = \Carbon\Carbon::parse($shift['time_in_expected'])->timezone('UTC')->format('H:i');
                                $dOut = \Carbon\Carbon::parse($shift['time_out_expected'])->timezone('UTC')->format('H:i');
                            @endphp
                            <tr class="hover:bg-blue-50/30 transition-colors group">
                                <td class="py-4 px-5">
                                    <span class="bg-blue-50 text-blue-700 border border-blue-100 font-extrabold text-xs px-2.5 py-1 rounded-md">{{ $shift['shift_code'] }}</span>
                                </td>
                                <td class="py-4 px-5 text-center text-[13px] font-bold text-emerald-600 bg-emerald-50/20">
                                    {{ $dIn }}
                                </td>
                                <td class="py-4 px-5 text-center text-[13px] font-bold text-rose-600 bg-rose-50/20">
                                    {{ $dOut }}
                                </td>
                                <td class="py-4 px-5 text-right">
                                    <button type="button" onclick="editShift({{ json_encode($shift) }}, '{{ $dIn }}', '{{ $dOut }}')" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all mr-2">
                                        <i class="w-4 h-4" data-lucide="edit-2"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-10 text-center text-slate-400 font-bold text-xs">Belum ada data shift kerja.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right: Form -->
        <div class="lg:col-span-4 flex flex-col gap-4">
            <h3 class="font-extrabold text-slate-800 text-[15px] flex items-center justify-between">
                <span class="flex items-center gap-2" id="formTitle"><i class="w-5 h-5 text-emerald-500" data-lucide="plus-circle"></i> Tambah Baru</span>
                <button type="button" onclick="resetForm()" class="hidden text-xs font-bold text-blue-600 hover:text-blue-800 px-3 py-1 bg-blue-50 rounded-lg transition-colors" id="btnCancelEdit">Batal Edit</button>
            </h3>
            
            <form id="shiftForm" method="POST" action="{{ route('master.shifts.store') }}" class="bg-white p-6 rounded-2xl shadow-xl shadow-slate-200/40 border border-slate-100 relative overflow-hidden">
                @csrf
                <input type="hidden" name="_method" value="POST" id="methodField">
                
                <div class="absolute -right-8 -top-8 w-32 h-32 bg-blue-50 rounded-full blur-3xl opacity-60 pointer-events-none"></div>

                <div class="flex flex-col mb-5 relative z-10">
                    <label class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2.5 ml-1">Kode Shift</label>
                    <input type="text" id="shiftCodeInput" name="shift_code" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl py-3 px-4 text-[13px] text-slate-800 font-bold outline-none focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all shadow-sm" required placeholder="Contoh: SHIFT 1 / SHIFT ROSTER"/>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6 relative z-10">
                    <div class="flex flex-col">
                        <label class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2.5 ml-1">Jam Masuk</label>
                        <input type="time" id="timeInInput" name="time_in_expected" class="w-full bg-emerald-50 border border-emerald-200 rounded-xl py-3 px-4 text-[13px] text-emerald-800 font-bold outline-none focus:bg-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all shadow-sm" required/>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2.5 ml-1">Jam Pulang</label>
                        <input type="time" id="timeOutInput" name="time_out_expected" class="w-full bg-rose-50 border border-rose-200 rounded-xl py-3 px-4 text-[13px] text-rose-800 font-bold outline-none focus:bg-white focus:ring-4 focus:ring-rose-500/10 focus:border-rose-500 transition-all shadow-sm" required/>
                    </div>
                </div>

                <div class="flex flex-col gap-3">
                    <button type="submit" id="btnSubmit" class="w-full px-6 py-3.5 bg-gradient-to-r from-[#0052cc] to-blue-600 hover:from-[#0047b3] hover:to-blue-700 text-white font-extrabold text-[12px] rounded-xl shadow-lg shadow-blue-500/30 transition-all active:scale-95 uppercase tracking-widest flex items-center justify-center gap-2">
                        <i class="w-4 h-4" data-lucide="save"></i> SIMPAN SHIFT
                    </button>
                    
                    <button type="button" id="btnDelete" onclick="deleteShift()" class="hidden w-full px-6 py-3.5 bg-red-50 hover:bg-red-100 text-red-600 font-extrabold text-[12px] rounded-xl transition-all uppercase tracking-widest items-center justify-center gap-2 border border-red-100">
                        <i class="w-4 h-4" data-lucide="trash-2"></i> HAPUS SHIFT
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const form = document.getElementById('shiftForm');
    const methodField = document.getElementById('methodField');
    const shiftCodeInput = document.getElementById('shiftCodeInput');
    const timeInInput = document.getElementById('timeInInput');
    const timeOutInput = document.getElementById('timeOutInput');
    const formTitle = document.getElementById('formTitle');
    const btnCancelEdit = document.getElementById('btnCancelEdit');
    const btnSubmit = document.getElementById('btnSubmit');
    const btnDelete = document.getElementById('btnDelete');
    
    const storeUrl = "{{ route('master.shifts.store') }}";
    const updateUrlBase = "{{ url('master/shifts') }}"; 

    let currentEditId = null;

    function editShift(shift, tIn, tOut) {
        currentEditId = shift.shift_id;
        form.action = `${updateUrlBase}/${shift.shift_id}`;
        methodField.value = 'PUT';
        
        shiftCodeInput.value = shift.shift_code;
        timeInInput.value = tIn;
        timeOutInput.value = tOut;
        
        formTitle.innerHTML = `<i class="w-5 h-5 text-blue-500" data-lucide="edit-3"></i> Edit: #${shift.shift_code}`;
        btnCancelEdit.classList.remove('hidden');
        
        btnSubmit.innerHTML = `<i class="w-4 h-4" data-lucide="save"></i> PERBARUI SHIFT`;
        btnDelete.classList.remove('hidden');
        btnDelete.classList.add('flex');
        lucide.createIcons();
    }

    function resetForm() {
        currentEditId = null;
        form.action = storeUrl;
        methodField.value = 'POST';
        
        shiftCodeInput.value = '';
        timeInInput.value = '';
        timeOutInput.value = '';
        
        formTitle.innerHTML = `<i class="w-5 h-5 text-emerald-500" data-lucide="plus-circle"></i> Tambah Baru`;
        btnCancelEdit.classList.add('hidden');
        
        btnSubmit.innerHTML = `<i class="w-4 h-4" data-lucide="save"></i> SIMPAN SHIFT`;
        btnDelete.classList.add('hidden');
        btnDelete.classList.remove('flex');
        lucide.createIcons();
    }

    function deleteShift() {
        if(currentEditId && confirm("AWAS! Anda yakin menghapus master Shift ini?")) {
            methodField.value = 'DELETE';
            form.submit();
        }
    }
</script>
@endpush
