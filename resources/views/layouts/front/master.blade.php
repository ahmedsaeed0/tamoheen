<!DOCTYPE html>
@if(app()->getLocale()== 'en')
<html lang="en" dir="ltr">
 @else
 <html lang="ar" dir="rtl">
 @endif
    <head>
        @include('layouts.front.include.meta')
        
        @include('layouts.front.include.css')
        
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-JEV2J92X9Q"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', 'G-JEV2J92X9Q');
        </script>
    </head>
    <body>
        <!-- ========== MAIN CONTENT ========== -->
        @yield('content')
        <!-- ========== END MAIN CONTENT ========== -->

        <!-- ========== FOOTER ========== -->
        @include('layouts.front.include.footer')
        <!-- ========== End FOOTER ========== -->

      
        <a class="js-go-to u-go-to-modern" href="#" data-position='{"bottom": 15, "right": 15 }' data-type="fixed" data-offset-top="400" data-compensation="#header" data-show-effect="slideInUp" data-hide-effect="slideOutDown">
            <span class="flaticon-arrow u-go-to-modern__inner"></span>
        </a>
        <!-- End Go to Top -->
        <!--@include('layouts.front.include.js')-->
        
    </body>
</html>
