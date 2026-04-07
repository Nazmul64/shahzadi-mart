{{-- resources/views/frontend/master.blade.php --}}

@include('frontend.pages.header')

    <div class="page-wrap">

        {{-- Left: category sidebar --}}
        @include('frontend.pages.category')

        {{-- Right: page content --}}
        <main class="content-area">
            @yield('main-content')
        </main>

    </div>

@include('frontend.pages.footer')

@stack('scripts')
