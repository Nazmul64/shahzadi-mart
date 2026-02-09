@include('frontend.pages.header')

    <!-- Main Container -->
    <div class="main-container">
        <!-- Sidebar -->
         @include('frontend.pages.category')
        <!-- Content Area -->
        @yield('main-content')
    </div>
@include('frontend.pages.footer')
