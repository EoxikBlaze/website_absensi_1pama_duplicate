<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Presensi Subcontractor - Login</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap"
        rel="stylesheet" />
    <!-- Lucide Icons for UI elements -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style data-purpose="typography">
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    <style data-purpose="custom-layout">
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

<body class="bg-[#f8f9fb] min-h-screen flex flex-col">
    <!-- BEGIN: MainContent -->
    <main class="flex-grow flex items-center justify-center p-4">
        <!-- BEGIN: LoginCard -->
        <div class="login-card bg-white w-full max-w-4xl p-12 md:p-20 flex flex-col items-center"
            data-purpose="login-container">
            <!-- Logo Section -->
            <div class="mb-6">
                <img alt="PA Logo" class="h-12 w-auto object-contain"
                    src="https://lh3.googleusercontent.com/aida/ADBb0ujeapFAuvSGkxaxZScGGVNq-SsWD-nEjn58XxhAeAtREfP2Jr-hQVk5A9eCYcNdmfHt_74wdbcP_JzZZ8GYERZdWracn5jG3c9kiEL4XlLAnmgGunmfGCgKK0lVMVxPwPzdlzhjo0QSBrJDsu8RX12NHe8LFC2QtMhoS7y3uVmh27tYL6uepxXvUOk0bglQzidZL_Xm0JWQBk78E9c-xpjhhNQZXULPODUwo28KIE9vB9c3RqjNir9aAVZ2rQnaPhauIQS03Q_vXQ"
                    style="clip-path: inset(30% 45% 63% 45%); transform: scale(4);" />
                <!-- Note: Using a clip-path/scale trick as a placeholder for the logo extract from the provided image -->
            </div>
            <!-- Header Section -->
            <div class="text-center mb-10">
                <h1 class="text-[#2c3e50] text-3xl font-extrabold tracking-tight uppercase mb-2">Presensi Subcontractor
                </h1>
                <p class="text-gray-400 text-xs font-bold tracking-widest uppercase">Sign In To Continue</p>
            </div>
            <!-- Form Section -->
            <form action="#" class="w-full" method="POST">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
                    <!-- Username Field -->
                    <div class="flex flex-col">
                        <label class="text-[10px] font-bold text-gray-500 uppercase mb-2 ml-1">Username / PNRP</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-4 text-gray-400">
                                <i class="w-4 h-4" data-lucide="user"></i>
                            </span>
                            <input
                                class="input-field-container w-full border border-gray-100 rounded-lg py-4 pl-11 pr-4 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all placeholder:text-gray-300"
                                placeholder="Enter your NRP" type="text" />
                        </div>
                    </div>
                    <!-- Password Field -->
                    <div class="flex flex-col">
                        <label class="text-[10px] font-bold text-gray-500 uppercase mb-2 ml-1">Password</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-4 text-gray-400">
                                <i class="w-4 h-4" data-lucide="lock"></i>
                            </span>
                            <input
                                class="input-field-container w-full border border-gray-100 rounded-lg py-4 pl-11 pr-11 text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition-all text-gray-400"
                                type="password" value="********" />
                            <button class="absolute right-4 text-gray-400 hover:text-gray-600" type="button">
                                <i class="w-4 h-4" data-lucide="eye"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Domain Field (Disabled/Pre-filled style) -->
                    <div class="flex flex-col">
                        <label class="text-[10px] font-bold text-gray-500 uppercase mb-2 ml-1">Domain</label>
                        <div class="relative flex items-center">
                            <span class="absolute left-4 text-[#5c6ea3]">
                                <i class="w-4 h-4" data-lucide="building-2"></i>
                            </span>
                            <input
                                class="domain-field w-full border-none rounded-lg py-4 pl-11 pr-4 text-sm text-[#5c6ea3] font-medium focus:ring-0 cursor-default"
                                readonly="" type="text" value="Pamapersada" />
                        </div>
                    </div>
                </div>
                <!-- Login Button -->
                <div class="flex flex-col items-center">
                    <button
                        class="bg-[#007bff] hover:bg-[#0069d9] text-white font-bold py-4 px-16 rounded-lg flex items-center justify-center gap-2 transition-colors shadow-lg shadow-blue-200 w-full md:w-auto min-w-[280px]"
                        type="submit">
                        <span class="uppercase tracking-wider text-sm">Log In</span>
                        <i class="w-4 h-4" data-lucide="arrow-right"></i>
                    </button>
                    <a class="mt-6 text-[#5c6ea3] hover:text-blue-700 text-[10px] font-bold tracking-widest uppercase transition-colors"
                        href="#">
                        Forgot Password?
                    </a>
                </div>
            </form>
        </div>
        <!-- END: LoginCard -->
    </main>
    <!-- END: MainContent -->
    <!-- BEGIN: MainFooter -->
    <footer
        class="footer-border bg-white py-8 px-10 flex flex-col md:flex-row justify-between items-center text-[10px] font-bold text-gray-400 tracking-wider">
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
        lucide.createIcons();
    </script>
</body>

</html>