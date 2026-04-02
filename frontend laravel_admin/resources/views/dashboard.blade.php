@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="flex-1 flex flex-col items-center justify-center p-8 w-full h-full min-h-full bg-white text-center transform -translate-y-8">
    <!-- Dinamis menyapa nama user dari database session Node.js -->
    <h1 class="text-[32px] tracking-tight font-[900] text-[#111827] leading-tight mb-3">Hallo, {{ session('user.employee_data.full_name') ?? session('user.nrp') ?? 'Admin User' }}</h1>
    <p class="text-[13px] text-gray-500 font-medium">Welcome back to your administration command center.</p>
</div>
@endsection
