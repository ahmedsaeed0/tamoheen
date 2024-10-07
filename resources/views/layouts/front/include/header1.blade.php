<header id="header" class="u-header u-header--dark-nav-links-xl u-header--show-hide-xl ">

    

    <div class="u-header__section u-header__shadow-on-show-hide py-4 py-xl-0">

        <!-- Topbar -->

        <div class="container-fluid u-header__hide-content u-header__topbar u-header__topbar-lg border-bottom border-color-8">

            <div class="d-flex align-items-center justify-content-between">

                <ul class="list-inline list-inline-dark u-header__topbar-nav-divider--dark mb-0">

                    <li class="list-inline-item mr-0"><a href="tel:(000)999-898-999" class="u-header__navbar-link">@lang('header.tel_num')</a></li>

                    <li class="list-inline-item mr-0"><a href="mailto:info@mytravel.com" class="u-header__navbar-link">@lang('header.info_email')</a></li>

                </ul>

                <div class=" d-flex align-items-center">

                    <ul class="list-inline mb-0 mr-2 pr-1">

                        <li class="list-inline-item">

                            <a class="btn btn-xs btn-icon btn-pill btn-soft-dark btn-bg-transparent transition-3d-hover header-social-fb" href="https://www.facebook.com/" target="_blank">

                                <span class="fab fa-facebook-f btn-icon__inner"></span>

                            </a>

                        </li>

                        <li class="list-inline-item">

                            <a class="btn btn-xs btn-icon btn-pill btn-soft-dark btn-bg-transparent transition-3d-hover header-social-twitter" href="https://twitter.com/tamoheen" target="_blank">

                                <span class="fab fa-twitter btn-icon__inner"></span>

                            </a>

                        </li>

                        <li class="list-inline-item">

                            <a class="btn btn-xs btn-icon btn-pill btn-soft-dark btn-bg-transparent transition-3d-hover header-social-instagram" href="https://www.instagram.com/tamoheen/" target="_blank">

                                <span class="fab fa-instagram btn-icon__inner"></span>

                            </a>

                        </li>

                        <li class="list-inline-item">

                            <a class="btn btn-xs btn-icon btn-pill btn-soft-dark btn-bg-transparent transition-3d-hover header-social-linkedin" href="https://www.linkedin.com/" target="_blank">

                                <span class="fab fa-linkedin-in btn-icon__inner"></span>

                            </a>

                        </li>

                    </ul>

                    @guest

                    <div class="position-relative px-3 u-header__login-form dropdown-connector-xl u-header__topbar-divider--dark">

                        <a id="signUpDropdownInvoker"  href="{{ url('user-login') }}" class="d-flex align-items-center text-dark" aria-controls="signUpDropdown" aria-haspopup="true" aria-expanded="true" data-unfold-event="click" data-unfold-target="#signUpDropdown" data-unfold-type="css-animation" data-unfold-duration="300" data-unfold-delay="300" data-unfold-hide-on-scroll="true" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">

                            <i class="fas fa-sign-in-alt mr-2 ml-1 font-size-18"></i>

                            <span class="d-inline-block font-size-14 mr-1">@lang('header.sign_in')</span>

                        </a>

                    </div>

                    <div class="position-relative px-3 u-header__login-form dropdown-connector-xl u-header__topbar-divider--dark">

                        <a id="signUpDropdownInvoker"  href="{{ url('user-signup') }}" class="d-flex align-items-center text-dark" aria-controls="signUpDropdown" aria-haspopup="true" aria-expanded="true" data-unfold-event="click" data-unfold-target="#signUpDropdown" data-unfold-type="css-animation" data-unfold-duration="300" data-unfold-delay="300" data-unfold-hide-on-scroll="true" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">

                            <i class="fas fa-user-plus mr-2 ml-1 font-size-18"></i>

                            <span class="d-inline-block font-size-14 mr-1">@lang('header.registration')</span>

                        </a>



                    </div>

                    @else

                    <div class="position-relative pl-3 language-switcher dropdown-connector-xl u-header__topbar-divider--dark">

                        

                        <a id="languageDropdownInvoker" class="dropdown-nav-link dropdown-toggle d-flex align-items-center ml-1" href="javascript:;" role="button" aria-controls="userDropdown" aria-haspopup="true" aria-expanded="false" data-unfold-event="hover" data-unfold-target="#userDropdown" data-unfold-type="css-animation" data-unfold-duration="300" data-unfold-delay="300" data-unfold-hide-on-scroll="true" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">

                            <span class="d-inline-block">{{ Auth::user()->name }}</span>

                        </a>

                        <div id="userDropdown" class="dropdown-menu dropdown-unfold dropdown-menu-right mt-0" aria-labelledby="userDropdown">

                            @hasrole('driver')

                                <a class="dropdown-item" href="{{ url('home') }}">

                                    @lang('header.dashboard')

                                </a>

                            @endhasrole

                            @hasrole('admin')

                                <a class="dropdown-item" href="{{ url('home') }}">

                                    @lang('header.dashboard')

                                </a>

                            @endhasrole

                            @hasrole('user')                               

                                @php

                                    $id = Auth::id();

                                    $user_amount = \App\Models\PartnerAmount::where('partner_id', $id)->sum('total_amount');

                                @endphp

                                <a class="dropdown-item" href="#">

                                   <span class="badge badge-success">E-Wallet:</span> {{ $user_amount }}

                                </a>

                                {{-- <a class="dropdown-item" href="{{ url('user-order-list') }}">

                                    @lang('header.order_list')

                                </a> --}}

                                <a class="dropdown-item" href="{{ url('user-trip-booking-list') }}">

                                    @lang('header.booking_list')

                                </a>

                                {{-- <a class="dropdown-item" href="{{ url('user-ship-booking-list') }}">

                                    @lang('header.ship_booking_list')

                                </a> --}}

                                <a class="dropdown-item" href="{{ route('user-payment-method') }}">

                                    @lang('header.payment_method')

                                </a>


                            @endhasrole

                            

                                <a class="dropdown-item" href="{{ route('user-change-password') }}">

                                    @lang('header.change_password')

                                </a>

                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                                @lang('header.logout')

                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">

                                @csrf

                            </form>

                        </div>

                    </div>

                    @endguest

                    <div class="position-relative pl-3 language-switcher dropdown-connector-xl u-header__topbar-divider">

                        <a id="languageDropdownInvoker" class="dropdown-nav-link dropdown-toggle d-flex align-items-center ml-1 py-3" href="javascript:;" role="button" aria-controls="languageDropdown" aria-haspopup="true" aria-expanded="false" data-unfold-event="hover" data-unfold-target="#languageDropdown" data-unfold-type="css-animation" data-unfold-duration="300" data-unfold-delay="300" data-unfold-hide-on-scroll="true" data-unfold-animation-in="slideInUp" data-unfold-animation-out="fadeOut">

                            <span class="d-inline-block">{{ LaravelLocalization::getCurrentLocaleNative() }}</span>

                        </a>

                        <div id="languageDropdown" class="dropdown-menu dropdown-unfold dropdown-menu-right mt-0" aria-labelledby="languageDropdownInvoker">

                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)

                            <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">

                                {{ $properties['native'] }}

                            </a>

                            @endforeach

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- End Topbar -->

        <div id="logoAndNav" class="container-fluid py-xl-2 border-bottom-xl">

            <!-- Nav -->

            <nav class="js-mega-menu navbar navbar-expand-xl u-header__navbar u-header__navbar--no-space">

                <!-- Logo -->

                <a class="navbar-brand u-header__navbar-brand-default u-header__navbar-brand-center u-header__navbar-brand-text-dark-xl" href="{{ url('/') }}" aria-label="MyTour">

                    <img contain width="auto" height="70px" src="{{ asset('front/assets/images/logo.png')}}" alt="" srcset="">

                </a>

                <!-- End Logo -->







                <!-- Responsive Toggle Button -->

                <button type="button" class="navbar-toggler btn u-hamburger u-hamburger--primary order-2 ml-3" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navBar" data-toggle="collapse" data-target="#navBar">

                    <span id="hamburgerTrigger" class="u-hamburger__box">

                        <span class="u-hamburger__inner"></span>

                    </span>

                </button>

                <!-- End Responsive Toggle Button -->



                <!-- Navigation -->

                <div id="navBar" class="navbar-collapse u-header__navbar-collapse collapse order-2 order-xl-0 pt-4 p-xl-0 position-relative justify-content-end align-items-center">

                    <ul class="navbar-nav u-header__navbar-nav">

                        <!-- Home -->

                        <li class="nav-item hs-has-sub-menu u-header__nav-item" data-event="hover" data-animation-in="slideInUp" data-animation-out="fadeOut">

                            <a id="homeMenu" class="nav-link u-header__nav-link u-header__nav-link-toggle u-header__nav-link-border" href="{{ url('/') }}" aria-haspopup="true" aria-expanded="false" aria-labelledby="homeSubMenu"> @lang('header.home')</a>

                        </li>

                        <!-- End Home -->



                        <!-- Shop -->

                        {{-- <li class="nav-item hs-has-sub-menu u-header__nav-item" data-event="hover" data-animation-in="slideInUp" data-animation-out="fadeOut">

                            <a id="homeMenu" class="nav-link u-header__nav-link u-header__nav-link-toggle u-header__nav-link-border" href="{{ url('/shop') }}" aria-haspopup="true" aria-expanded="false" aria-labelledby="homeSubMenu">@lang('header.shop')</a>

                        </li> --}}

                        <!-- End Shop -->



                        @php

                            $pages = App\Models\Page::where('status', 1)->get();

                        @endphp

                        @foreach ($pages as $page)

                             @if(app()->getLocale() == 'ar')

                                <li class="nav-item hs-has-sub-menu u-header__nav-item" data-event="hover" data-animation-in="slideInUp" data-animation-out="fadeOut">

                                    <a id="homeMenu{{ $loop->iteration }}" class="nav-link u-header__nav-link u-header__nav-link-toggle u-header__nav-link-border" href="{{ url($page->slug) }}" aria-haspopup="true" aria-expanded="false"  onclick="window.open('{{ url($page->slug) }}','_self')" aria-labelledby="homeSubMenu">{{ $page->title_arabic }}</a>

                                </li>

                            @else

                                <li class="nav-item hs-has-sub-menu u-header__nav-item" data-event="hover" data-animation-in="slideInUp" data-animation-out="fadeOut">

                                    <a id="homeMenu{{ $loop->iteration }}" class="nav-link u-header__nav-link u-header__nav-link-toggle u-header__nav-link-border" href="{{ url($page->slug) }}" onclick="window.open('{{ url($page->slug) }}','_self')" aria-haspopup="true" aria-expanded="false" aria-labelledby="homeSubMenu">{{ $page->title }}</a>

                                </li>

                            @endif

                        @endforeach

                        <?php

                            if(strpos($_SERVER['HTTP_USER_AGENT'],'Phone')||strpos($_SERVER['HTTP_USER_AGENT'],'Android')){ 

                        ?>

                        <li class="list-inline-item">

                            <a class="btn btn-sm btn-icon btn-pill btn-soft-white btn-bg-transparent transition-3d-hover header-social-fb" style="color:black" href="https://www.facebook.com/forsanway" target="_blank">

                                <span class="fab fa-facebook-f btn-icon__inner"></span>

                            </a>

                            <a class="btn btn-sm btn-icon btn-pill btn-soft-white btn-bg-transparent transition-3d-hover header-social-twitter" style="color:black" href="https://twitter.com/forsanway" target="_blank">

                                <span class="fab fa-twitter btn-icon__inner"></span>

                            </a>

                            <a class="btn btn-sm btn-icon btn-pill btn-soft-white btn-bg-transparent transition-3d-hover header-social-instagram" style="color:black" href="https://www.instagram.com/forsanway" target="_blank">

                                <span class="fab fa-instagram btn-icon__inner"></span>

                            </a>

                            <a class="btn btn-sm btn-icon btn-pill btn-soft-white btn-bg-transparent transition-3d-hover header-social-youtube" style="color:black" href="https://www.youtube.com/forsanway" target="_blank">

                                <span class="fab fa-youtube btn-icon__inner"></span>

                            </a>

                            <a class="btn btn-sm btn-icon btn-pill btn-soft-white btn-bg-transparent transition-3d-hover header-social-youtube" style="color:black" href="https://wa.me/000999898999?lang=en" target="_blank">

                                <span class="fab fa-whatsapp btn-icon__inner"></span>

                            </a>

                        </li>

                        <?php

                            }

                        ?>

                    </ul>

                </div>

                <!-- End Navigation -->

            </nav>

            <!-- End Nav -->

        </div>

    </div>

</header>

