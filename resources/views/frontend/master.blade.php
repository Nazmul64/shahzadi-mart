@include('frontend.pages.header')

    <div class="main-site-content {{ $gs->site_layout_width == 'boxed' ? 'container' : 'container-fluid' }}">
        
        <div class="page-wrap {{ $gs->category_menu_type == 'hover' ? 'no-sidebar' : '' }}">

            {{-- Left: category sidebar (only if fixed) --}}
            @if($gs->category_menu_type == 'fixed')
                @include('frontend.pages.category')
            @endif

            {{-- Right: page content --}}
            <main class="content-area">
                @yield('main-content')
            </main>

        </div>
    </div>

@include('frontend.pages.footer')

@stack('scripts')
