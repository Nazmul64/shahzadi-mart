
@include('subadmin.pages.header')
<!-- ══ SIDEBAR ══ -->
@include('subadmin.pages.sidebar')

<!-- ══ MAIN ══ -->
<div id="main">
   @yield('content')
</div><!-- /main -->
@include('subadmin.pages.footer')
