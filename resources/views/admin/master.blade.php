@php 
    $u = auth()->user(); 
@endphp

@if(!$u)
    <script>window.location.href="{{ route('admin.login') }}";</script>
@endif

{{-- ALWAYS INCLUDE ADMIN LAYOUT COMPONENTS --}}
@include('admin.pages.header')

@include('admin.pages.sidebar')

@include('admin.pages.topheader')

<main id="main-content">
    <div class="page-wrapper">
        @yield('main-content')
        @yield('content')
    </div>
</main>

@include('admin.pages.footer')
