
@include('manager.pages.header')
<!-- ══ SIDEBAR ══ -->
@include('manager.pages.sidebar')

<!-- ══ MAIN ══ -->
<div id="main">
   @yield('content')
</div><!-- /main -->

@include('manager.pages.footer')
