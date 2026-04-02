<!DOCTYPE html>
<html lang="en"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Presensi Subcontractor - Login</title>
<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<!-- Google Fonts: Inter -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
<!-- Lucide Icons for UI elements -->
<script src="https://unpkg.com/lucide@latest"></script>
<style data-purpose="typography">
    body {
      font-family: 'Inter', sans-serif;
    }
  </style>
<style data-purpose="custom-layout">
    .bg-pattern {
      background-image: radial-gradient(#d1d5db 1.2px, transparent 1.2px);
      background-size: 24px 24px;
    }
    .login-card {
      box-shadow: 0 10px 50px rgba(0, 0, 0, 0.05);
      border-radius: 2.5rem;
    }
    .input-field-container {
      background-color: #fcfdfe;
    }
    .domain-field {
      background-color: #f1f4ff;
    }
    .footer-border {
      border-top: 1px solid #e5e7eb;
    }
  </style>
</head>
<body class="bg-[#f8f9fb] bg-pattern min-h-screen flex flex-col">
<!-- BEGIN: MainContent -->
<main class="flex-grow flex items-center justify-center p-4">
<!-- BEGIN: LoginCard -->
<div class="login-card bg-white w-full max-w-4xl p-12 md:p-20 flex flex-col items-center" data-purpose="login-container">
<!-- Logo Section -->
<!-- 
  [PLACEHOLDER LOGO] 
  Saat Anda sudah memiliki logo, hapus div di bawah ini dan gunakan tag <img> yang saat ini di-comment.
  Ganti atribut 'src' dengan path logo Anda (misal: asset('images/logo.png')).
-->
<div class="mb-8 flex justify-center w-full">
    <!-- Kotak Placeholder -->
    <div class="h-28 w-48 bg-gray-100 border-2 border-dashed border-gray-300 rounded-xl flex flex-col items-center justify-center text-gray-400 font-semibold text-sm shadow-inner">
        <i class="w-8 h-8 mb-2 text-gray-400" data-lucide="image"></i>
        <span>Logo Anda</span>
    </div>
    
    <!-- Tag Image asli yang siap pakai (di-comment sementara) -->
    <!-- <img alt="Company Logo" class="h-24 w-auto object-contain" src="path/to/your/logo.png" /> -->
</div>
<!-- Header Section -->
<div class="text-center mb-10">
<h1 class="text-[#2c3e50] text-3xl font-extrabold tracking-tight uppercase mb-2">Presensi Subcontractor</h1>
<p class="text-gray-400 text-xs font-bold tracking-widest uppercase">Sign In To Continue</p>
</div>
<!-- Form Section -->
<form action="{{ route('login.post') }}" class="w-full" method="POST">
@csrf

<!-- Menampilkan error jika login gagal -->
@if ($errors->any())
<div class="bg-red-100 text-red-600 p-3 rounded-lg text-xs font-bold mb-4">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
<!-- Username Field -->
<div class="flex flex-col">
<label class="text-[10px] font-bold text-gray-500 uppercase mb-2 ml-1">Username / PNRP</label>
<div class="relative flex items-center">
<span class="absolute left-4 text-gray-500">
<i class="w-4 h-4" data-lucide="user"></i>
</span>
<input name="nrp" value="{{ old('nrp') }}" required class="input-field-container w-full border border-gray-100 rounded-lg py-4 pl-11 pr-4 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all placeholder:text-gray-500" placeholder="Enter your NRP" type="text"/>
</div>
</div>
<!-- Password Field -->
<div class="flex flex-col">
<label class="text-[10px] font-bold text-gray-500 uppercase mb-2 ml-1">Password</label>
<div class="relative flex items-center">
<span class="absolute left-4 text-gray-500">
<i class="w-4 h-4" data-lucide="lock"></i>
</span>
<input id="passwordInput" name="password" required class="input-field-container w-full border border-gray-100 rounded-lg py-4 pl-11 pr-11 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all text-black placeholder:text-gray-500" type="password" placeholder="********"/>
<button id="togglePassword" class="absolute right-4 text-gray-500 hover:text-gray-700 transition-colors" type="button" aria-label="Toggle password visibility">
<i id="toggleIcon" class="w-4 h-4" data-lucide="eye"></i>
</button>
</div>
</div>
<!-- Domain Field (Disabled/Pre-filled style) -->
<div class="flex flex-col">
<label class="text-[10px] font-bold text-gray-500 uppercase mb-2 ml-1">Domain</label>
<div class="relative flex items-center">
<span class="absolute left-4 text-gray-500">
<i class="w-4 h-4" data-lucide="building-2"></i>
</span>
<input class="domain-field w-full border-none rounded-lg py-4 pl-11 pr-4 text-sm text-gray-500 font-medium focus:ring-0 cursor-default" readonly="" type="text" value="Pamapersada"/>
</div>
</div>
</div>
<!-- Login Button -->
<div class="flex flex-col items-center">
<button class="bg-[#007bff] hover:bg-[#0069d9] text-white font-bold py-4 px-16 rounded-lg flex items-center justify-center gap-2 transition-colors shadow-lg shadow-blue-200 w-full md:w-auto min-w-[280px]" type="submit">
<span class="uppercase tracking-wider text-sm">Log In</span>
<i class="w-4 h-4" data-lucide="arrow-right"></i>
</button>
<a class="mt-6 text-[#5c6ea3] hover:text-blue-700 text-[10px] font-bold tracking-widest uppercase transition-colors" href="#">
            Forgot Password?
          </a>
</div>
</form>
</div>
<!-- END: LoginCard -->
</main>
<!-- END: MainContent -->
<!-- BEGIN: MainFooter -->
<footer class="footer-border bg-white py-8 px-10 flex flex-col md:flex-row justify-between items-center text-[10px] font-bold text-gray-400 tracking-wider">
<div class="mb-4 md:mb-0 uppercase">
      © 2026 PAMA SUBCONTRACTOR PORTAL. ALL RIGHTS RESERVED.
    </div>
<nav class="flex gap-8 uppercase">
<a class="hover:text-gray-600 transition-colors" href="#">Privacy Policy</a>
<a class="hover:text-gray-600 transition-colors" href="#">Terms of Service</a>
<a class="hover:text-gray-600 transition-colors" href="#">Security Audit</a>
</nav>
</footer>
<!-- END: MainFooter -->
<!-- Initialize Icons -->
<script data-purpose="icon-initialization">
    // Refresh the initial icons
    lucide.createIcons();

    // Toggle Password Visibility
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('passwordInput');
    const toggleIcon = document.getElementById('toggleIcon');

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function () {
            // Check the current type and toggle
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Change icon
            if (type === 'text') {
                toggleIcon.setAttribute('data-lucide', 'eye-off');
            } else {
                toggleIcon.setAttribute('data-lucide', 'eye');
            }
            
            // Re-render all lucide icons
            lucide.createIcons();
        });
    }
  </script>
</body></html>
