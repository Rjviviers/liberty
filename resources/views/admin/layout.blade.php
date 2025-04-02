<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | {{ config('app.name') }}</title>
    
    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .sidebar {
            width: 250px;
            transition: all 0.3s ease;
        }
        
        .main-content {
            margin-left: 250px;
            transition: all 0.3s ease;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
            }
            
            .sidebar.active {
                margin-left: 0;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .main-content.active {
                margin-left: 250px;
            }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <!-- Top Navigation -->
    <header class="bg-white shadow-md py-4 px-6 flex justify-between items-center">
        <div class="flex items-center">
            <button id="sidebar-toggle" class="block md:hidden text-gray-600 mr-3">
                <i class="fas fa-bars fa-lg"></i>
            </button>
            <h1 class="text-xl font-bold text-gray-800">Liberty Admin</h1>
        </div>
        
        <div class="flex items-center space-x-4">
            <div class="text-gray-700">
                Welcome, <span class="font-semibold">{{ session('admin_username', 'Admin') }}</span>
            </div>
            
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-red-600 hover:text-red-800">
                    <i class="fas fa-sign-out-alt mr-1"></i> Logout
                </button>
            </form>
        </div>
    </header>
    
    <!-- Sidebar and Main Content -->
    <div class="flex flex-1">
        <!-- Sidebar -->
        <aside class="sidebar h-screen bg-gray-800 text-white fixed left-0 top-0 pt-20 overflow-y-auto">
            <nav class="mt-8">
                <div class="px-4 py-2 text-xs text-gray-400 uppercase tracking-wider">
                    Main Navigation
                </div>
                
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-900' : 'hover:bg-gray-700' }} transition duration-200">
                    <i class="fas fa-tachometer-alt fa-fw mr-2"></i> Dashboard
                </a>
                
                <a href="{{ route('admin.appointments.index') }}" class="block px-4 py-3 {{ request()->routeIs('admin.appointments.*') ? 'bg-gray-900' : 'hover:bg-gray-700' }} transition duration-200">
                    <i class="fas fa-calendar-alt fa-fw mr-2"></i> Appointments
                </a>
                
                <div class="px-4 py-2 text-xs text-gray-400 uppercase tracking-wider mt-6">
                    Website Management
                </div>
                
                <a href="{{ route('admin.website.hero.edit') }}" class="block px-4 py-3 {{ request()->routeIs('admin.website.hero.*') ? 'bg-gray-900' : 'hover:bg-gray-700' }} transition duration-200">
                    <i class="fas fa-image fa-fw mr-2"></i> Hero Section
                </a>
                
                <a href="{{ route('admin.website.about.edit') }}" class="block px-4 py-3 {{ request()->routeIs('admin.website.about.*') ? 'bg-gray-900' : 'hover:bg-gray-700' }} transition duration-200">
                    <i class="fas fa-info-circle fa-fw mr-2"></i> About Section
                </a>
                
                <a href="{{ route('admin.website.features.edit') }}" class="block px-4 py-3 {{ request()->routeIs('admin.website.features.*') ? 'bg-gray-900' : 'hover:bg-gray-700' }} transition duration-200">
                    <i class="fas fa-star fa-fw mr-2"></i> Features Section
                </a>
                
                <a href="{{ route('admin.website.services.edit') }}" class="block px-4 py-3 {{ request()->routeIs('admin.website.services.*') ? 'bg-gray-900' : 'hover:bg-gray-700' }} transition duration-200">
                    <i class="fas fa-clipboard-list fa-fw mr-2"></i> Services Section
                </a>
                
                <a href="{{ route('admin.website.testimonials.edit') }}" class="block px-4 py-3 {{ request()->routeIs('admin.website.testimonials.*') ? 'bg-gray-900' : 'hover:bg-gray-700' }} transition duration-200">
                    <i class="fas fa-comment fa-fw mr-2"></i> Testimonials Section
                </a>
                
                <a href="{{ route('admin.website.contact.edit') }}" class="block px-4 py-3 {{ request()->routeIs('admin.website.contact.*') ? 'bg-gray-900' : 'hover:bg-gray-700' }} transition duration-200">
                    <i class="fas fa-envelope fa-fw mr-2"></i> Contact Section
                </a>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content flex-1 py-6 px-8">
            @yield('content')
        </main>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                mainContent.classList.toggle('active');
            });
        });
    </script>
</body>
</html> 