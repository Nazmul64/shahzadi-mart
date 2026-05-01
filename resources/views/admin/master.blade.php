@php 
    $u = auth()->user(); 
@endphp

@if($u->isSuperAdmin() || $u->hasRole('admin'))
    {{-- ════ DEFAULT ADMIN LAYOUT ════ --}}
    @include('admin.pages.header')
    @include('admin.pages.sidebar')
    @include('admin.pages.topheader')
    
    <main id="main-content">
        @yield('main-content')
        @yield('content')
    </main>
    
    @include('admin.pages.footer')

@elseif($u->isEmployee())
    {{-- ════ EMPLOYEE UI WRAPPER ════ --}}
    @include('emplee.pages.header')
    @include('emplee.pages.siderbar')
    
    <div id="main">
        @include('emplee.pages.topbar')
        <div id="content" style="padding-top:20px;">
            @yield('main-content')
            @yield('content')
        </div>
    </div>
    
    @include('emplee.pages.footer')

@elseif($u->isManager())
    {{-- ════ MANAGER UI WRAPPER ════ --}}
    @include('manager.pages.header')
    @include('manager.pages.sidebar')
    
    <div id="main">
        {{-- Manager uses a different topheader usually --}}
        @if(view()->exists('manager.pages.topheader'))
            @include('manager.pages.topheader')
        @endif
        
        <div id="content" style="padding: 24px;">
            @yield('main-content')
            @yield('content')
        </div>
    </div>
    
    @if(view()->exists('manager.pages.footer'))
        @include('manager.pages.footer')
    @else
        @include('admin.pages.footer')
    @endif

@else
    {{-- Fallback for other roles --}}
    @include('admin.pages.header')
    @yield('main-content')
    @yield('content')
    @include('admin.pages.footer')
@endif
