<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $gs = \App\Models\Generalsetting::getSettings();
        $siteName = $gs->website_name ?? ($gs->site_name ?? 'Shahzadi Mart');
    @endphp
    <title>{{ $siteName }} - Seller Dashboard</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <!-- Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ asset('saller/assets/css/style.css') }}">
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Quill -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
    
    @stack('styles')

    <style>
        :root {
            --sidebar-width: 280px;
        }
        #sidebar { 
            width: var(--sidebar-width); 
            min-height: 100vh; 
            position: fixed; 
            top: 0; 
            left: 0 !important; 
            z-index: 1050; 
            overflow-y: auto; 
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
            background: #0f172a !important;
            box-shadow: 4px 0 10px rgba(0,0,0,0.1);
        }

        #main-area { 
            margin-left: var(--sidebar-width); 
            min-height: 100vh; 
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
            background: #f8fafc; 
            display: flex;
            flex-direction: column;
        }
        header { 
            position: sticky; 
            top: 0; 
            z-index: 1040; 
            background: #fff; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.05); 
        }
        
        .page-section { display: none; }
        .page-section.active { display: block !important; }

        @media (max-width: 992px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.open { transform: translateX(0); }
            #main-area { margin-left: 0; }
        }

        /* Select2 Premium Styling */
        .select2-container--default .select2-selection--single, 
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            min-height: 42px;
            padding: 5px;
            transition: border-color 0.2s;
        }
    </style>
</head>
<body>

{{-- Layout Wrapper --}}
<div class="d-flex" id="saller-wrapper">
    {{-- Sidebar (fixed) --}}
    @include('saller.pages.sidebar')

    {{-- Main area (header + content + footer) --}}
    <div class="flex-grow-1" id="main-area">
        {{-- Header --}}
        @include('saller.pages.header')

        {{-- Page Content --}}
        <main id="content">
            @yield('main-content')
        </main>

        {{-- Footer --}}
        @include('saller.pages.footer')
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        sidebar.classList.toggle('open');
        if (overlay) overlay.classList.toggle('active');
    }
</script>

@stack('scripts')

</body>
</html>
