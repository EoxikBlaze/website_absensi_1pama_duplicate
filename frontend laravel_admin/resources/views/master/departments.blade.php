@extends('layouts.app')

@section('title', 'Manajemen Departemen')

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
                <span class="text-blue-700 font-bold bg-blue-50 border border-blue-100 px-2.5 py-1 rounded-md text-[10px] tracking-wide shadow-sm">Departemen & Divisi</span>
            </div>
            <!-- Title -->
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-[#0052cc] to-blue-500 flex items-center justify-center text-white shadow-lg shadow-blue-500/30">
                    <i class="w-5 h-5" data-lucide="briefcase"></i>
                </div>
                <h1 class="text-2xl md:text-[28px] font-[900] text-transparent bg-clip-text bg-gradient-to-r from-slate-900 to-slate-600 tracking-tight leading-none">Departemen Institusi</h1>
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
        <div class="lg:col-span-7 flex flex-col gap-4">
            <h3 class="font-extrabold text-slate-800 text-[15px] flex items-center gap-2">
                <i class="w-5 h-5 text-blue-500" data-lucide="list"></i> Daftar Struktur (<span id="totalDept">{{ count($departments) }}</span>)
            </h3>
            <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/40 border border-slate-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100">
                                <th class="py-4 px-5 text-[11px] font-extrabold text-slate-500 uppercase tracking-widest">Nama Departemen</th>
                                <th class="py-4 px-5 text-[11px] font-extrabold text-slate-500 uppercase tracking-widest text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($departments as $dept)
                            <tr class="hover:bg-blue-50/30 transition-colors group">
                                <td class="py-4 px-5">
                                    <div class="text-[14px] font-bold text-slate-800 tracking-tight mb-1">{{ $dept['dept_name'] }}</div>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($dept['divisions'] ?? [] as $div)
                                            <span class="inline-flex items-center gap-1 bg-slate-100 text-slate-600 px-2 py-0.5 rounded-md text-[10px] font-bold border border-slate-200 cursor-pointer hover:bg-slate-200" onclick='editDivision(@json($div), @json($dept))'>
                                                {{ $div['div_name'] }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="py-4 px-5 text-right align-top">
                                    <button type="button" onclick="editDepartment({{ json_encode($dept) }})" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition-all mr-2" title="Edit Departemen">
                                        <i class="w-4 h-4" data-lucide="edit-2"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="py-10 text-center text-slate-400 font-bold text-xs">Belum ada data departemen.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right: Forms -->
        <div class="lg:col-span-5 flex flex-col gap-6">
            
            <!-- Department Form -->
            <div class="flex flex-col gap-4">
                <h3 class="font-extrabold text-slate-800 text-[15px] flex items-center justify-between">
                    <span class="flex items-center gap-2" id="deptFormTitle"><i class="w-5 h-5 text-emerald-500" data-lucide="plus-circle"></i> Tambah Departemen</span>
                    <button type="button" onclick="resetDeptForm()" class="hidden text-xs font-bold text-blue-600 hover:text-blue-800 px-3 py-1 bg-blue-50 rounded-lg transition-colors" id="btnCancelDeptEdit">Batal</button>
                </h3>
                
                <form id="deptForm" method="POST" action="{{ route('master.departments.store') }}" class="bg-white p-6 rounded-2xl shadow-xl shadow-slate-200/40 border border-slate-100 relative overflow-hidden">
                    @csrf
                    <input type="hidden" name="_method" value="POST" id="deptMethodField">
                    
                    <div class="absolute -right-8 -top-8 w-32 h-32 bg-blue-50 rounded-full blur-3xl opacity-60 pointer-events-none"></div>

                    <div class="flex flex-col mb-5 relative z-10">
                        <label class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2.5 ml-1">Nama Departemen</label>
                        <input type="text" id="deptNameInput" name="dept_name" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl py-3 px-4 text-[13px] text-slate-800 font-bold outline-none focus:bg-white focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all shadow-sm" required placeholder="Contoh: HRD, Engineering..."/>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="submit" id="btnSubmitDept" class="flex-1 w-full px-6 py-3.5 bg-gradient-to-r from-[#0052cc] to-blue-600 hover:from-[#0047b3] hover:to-blue-700 text-white font-extrabold text-[12px] rounded-xl shadow-lg shadow-blue-500/30 transition-all active:scale-95 uppercase tracking-widest flex items-center justify-center gap-2">
                            <i class="w-4 h-4" data-lucide="save"></i> SIMPAN DEPT
                        </button>
                        
                        <button type="button" id="btnDeleteDept" onclick="deleteDepartment()" class="hidden flex-1 w-full px-6 py-3.5 bg-red-50 hover:bg-red-100 text-red-600 font-extrabold text-[12px] rounded-xl transition-all uppercase tracking-widest items-center justify-center gap-2 border border-red-100">
                            <i class="w-4 h-4" data-lucide="trash-2"></i> HAPUS
                        </button>
                    </div>
                </form>
            </div>

            <hr class="border-slate-200" />

            <!-- Division Form -->
            <div class="flex flex-col gap-4">
                <h3 class="font-extrabold text-slate-800 text-[15px] flex items-center justify-between">
                    <span class="flex items-center gap-2" id="divFormTitle"><i class="w-5 h-5 text-indigo-500" data-lucide="plus-circle"></i> Tambah Divisi</span>
                    <button type="button" onclick="resetDivForm()" class="hidden text-xs font-bold text-indigo-600 hover:text-indigo-800 px-3 py-1 bg-indigo-50 rounded-lg transition-colors" id="btnCancelDivEdit">Batal</button>
                </h3>
                
                <form id="divForm" method="POST" action="{{ route('master.divisions.store') }}" class="bg-white p-6 rounded-2xl shadow-xl shadow-slate-200/40 border border-slate-100 relative overflow-hidden">
                    @csrf
                    <input type="hidden" name="_method" value="POST" id="divMethodField">
                    
                    <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-indigo-50 rounded-full blur-3xl opacity-60 pointer-events-none"></div>

                    <div class="flex flex-col mb-4 relative z-10">
                        <label class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2.5 ml-1">Pilih Departemen Induk</label>
                        <select id="parentDeptSelect" name="dept_id" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl py-3 px-4 text-[13px] text-slate-800 font-bold outline-none focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm cursor-pointer" required>
                            <option value="">-- Pilih Departemen --</option>
                            @foreach($departments as $dept)
                            <option value="{{ $dept['dept_id'] }}">{{ $dept['dept_name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col mb-5 relative z-10">
                        <label class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest mb-2.5 ml-1">Nama Divisi</label>
                        <input type="text" id="divNameInput" name="div_name" class="w-full bg-slate-50/50 border border-slate-200 rounded-xl py-3 px-4 text-[13px] text-slate-800 font-bold outline-none focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm" required placeholder="Contoh: Recruitment, IT Support..."/>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="submit" id="btnSubmitDiv" class="flex-1 w-full px-6 py-3.5 bg-gradient-to-r from-indigo-600 to-[#0052cc] hover:from-indigo-700 hover:to-indigo-800 text-white font-extrabold text-[12px] rounded-xl shadow-lg shadow-indigo-500/30 transition-all active:scale-95 uppercase tracking-widest flex items-center justify-center gap-2">
                            <i class="w-4 h-4" data-lucide="save"></i> SIMPAN DIVISI
                        </button>
                        
                        <button type="button" id="btnDeleteDiv" onclick="deleteDivision()" class="hidden flex-1 w-full px-6 py-3.5 bg-red-50 hover:bg-red-100 text-red-600 font-extrabold text-[12px] rounded-xl transition-all uppercase tracking-widest items-center justify-center gap-2 border border-red-100">
                            <i class="w-4 h-4" data-lucide="trash-2"></i> HAPUS
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // DEPARTMENTS
    const deptForm = document.getElementById('deptForm');
    const deptMethodField = document.getElementById('deptMethodField');
    const deptNameInput = document.getElementById('deptNameInput');
    const deptFormTitle = document.getElementById('deptFormTitle');
    const btnCancelDeptEdit = document.getElementById('btnCancelDeptEdit');
    const btnSubmitDept = document.getElementById('btnSubmitDept');
    const btnDeleteDept = document.getElementById('btnDeleteDept');
    
    const storeDeptUrl = "{{ route('master.departments.store') }}";
    const updateDeptUrlBase = "{{ url('master/departments') }}"; 

    let currentDeptEditId = null;

    function editDepartment(dept) {
        currentDeptEditId = dept.dept_id;
        deptForm.action = `${updateDeptUrlBase}/${dept.dept_id}`;
        deptMethodField.value = 'PUT';
        
        deptNameInput.value = dept.dept_name;
        
        deptFormTitle.innerHTML = `<i class="w-5 h-5 text-blue-500" data-lucide="edit-3"></i> Edit Departemen`;
        btnCancelDeptEdit.classList.remove('hidden');
        
        btnSubmitDept.innerHTML = `<i class="w-4 h-4" data-lucide="save"></i> UPD DEPT`;
        btnDeleteDept.classList.remove('hidden');
        btnDeleteDept.classList.add('flex');
        
        // Auto select on div form
        resetDivForm();
        document.getElementById('parentDeptSelect').value = dept.dept_id;

        lucide.createIcons();
    }

    function resetDeptForm() {
        currentDeptEditId = null;
        deptForm.action = storeDeptUrl;
        deptMethodField.value = 'POST';
        
        deptNameInput.value = '';
        
        deptFormTitle.innerHTML = `<i class="w-5 h-5 text-emerald-500" data-lucide="plus-circle"></i> Tambah Departemen`;
        btnCancelDeptEdit.classList.add('hidden');
        
        btnSubmitDept.innerHTML = `<i class="w-4 h-4" data-lucide="save"></i> SIMPAN DEPT`;
        btnDeleteDept.classList.add('hidden');
        btnDeleteDept.classList.remove('flex');
        lucide.createIcons();
    }

    function deleteDepartment() {
        if(currentDeptEditId && confirm("AWAS! Menghapus departemen ini mungkin juga menghapus divisi di dalamnya! Yakin?")) {
            deptMethodField.value = 'DELETE';
            deptForm.submit();
        }
    }

    // DIVISIONS
    const divForm = document.getElementById('divForm');
    const divMethodField = document.getElementById('divMethodField');
    const divNameInput = document.getElementById('divNameInput');
    const parentDeptSelect = document.getElementById('parentDeptSelect');
    const divFormTitle = document.getElementById('divFormTitle');
    const btnCancelDivEdit = document.getElementById('btnCancelDivEdit');
    const btnSubmitDiv = document.getElementById('btnSubmitDiv');
    const btnDeleteDiv = document.getElementById('btnDeleteDiv');
    
    const storeDivUrl = "{{ route('master.divisions.store') }}";
    const updateDivUrlBase = "{{ url('master/divisions') }}"; 

    let currentDivEditId = null;

    function editDivision(div, dept) {
        currentDivEditId = div.div_id;
        divForm.action = `${updateDivUrlBase}/${div.div_id}`;
        divMethodField.value = 'PUT';
        
        divNameInput.value = div.div_name;
        parentDeptSelect.value = dept.dept_id;
        
        divFormTitle.innerHTML = `<i class="w-5 h-5 text-indigo-500" data-lucide="edit-3"></i> Edit Divisi`;
        btnCancelDivEdit.classList.remove('hidden');
        
        btnSubmitDiv.innerHTML = `<i class="w-4 h-4" data-lucide="save"></i> UPD DIVISI`;
        btnDeleteDiv.classList.remove('hidden');
        btnDeleteDiv.classList.add('flex');
        lucide.createIcons();
    }

    function resetDivForm() {
        currentDivEditId = null;
        divForm.action = storeDivUrl;
        divMethodField.value = 'POST';
        
        divNameInput.value = '';
        parentDeptSelect.value = '';
        
        divFormTitle.innerHTML = `<i class="w-5 h-5 text-indigo-500" data-lucide="plus-circle"></i> Tambah Divisi`;
        btnCancelDivEdit.classList.add('hidden');
        
        btnSubmitDiv.innerHTML = `<i class="w-4 h-4" data-lucide="save"></i> SIMPAN DIVISI`;
        btnDeleteDiv.classList.add('hidden');
        btnDeleteDiv.classList.remove('flex');
        lucide.createIcons();
    }

    function deleteDivision() {
        if(currentDivEditId && confirm("Apakah Anda yakin ingin menghapus divisi ini dari departemen?")) {
            divMethodField.value = 'DELETE';
            divForm.submit();
        }
    }
</script>
@endpush
