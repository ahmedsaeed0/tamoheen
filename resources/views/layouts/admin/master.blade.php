<!DOCTYPE html>

@if(app()->getLocale()== 'en')

  <html lang="en" dir="ltr">

@elseif(app()->getLocale()== 'ar')

  <html lang="ar" dir="rtl">

@else

  <html lang="ur" dir="rtl">

@endif



<head>

  @include('layouts.admin.include.meta')

  @include('layouts.admin.include.css')

</head>



<body class="">

  <div class="wrapper">

    @include('layouts.admin.include.sidebar')

    <div class="main-panel">

      <!-- Navbar -->

      @include('layouts.admin.include.navbar')

      <!-- End Navbar -->

      @yield('content')

      @include('layouts.admin.include.footer')

    </div>

  </div>

  @include('layouts.admin.include.fixed-plugin')

  @include('layouts.admin.include.js')

</body>

</html>