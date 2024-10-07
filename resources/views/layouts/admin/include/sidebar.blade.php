<div class="sidebar" data-color="purple" data-background-color="white" data-image="{{ asset('admin/assets/img/sidebar-1.jpg') }}">
  <!--
    Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

    Tip 2: you can also add an image using data-image tag
-->
    <div class="logo">
      <a href="http://127.0.0.1:8000" class="simple-text logo-normal">
        {{ __('sidebar-ts.site_title') }}
      </a>
    </div>
  <div class="sidebar-wrapper">
    <ul class="nav">

    <li class="nav-item dropdown active show">
      <a class="nav-link dropdown-toggle" href="#" id="langset" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        <i class="material-icons">translate</i>
        <p class="d-inline-block">
          {{ LaravelLocalization::getCurrentLocaleNative() }}
        </p>
      </a>
      <div class="dropdown-menu" aria-labelledby="langset">
      @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
        <a rel="alternate" class="dropdown-item" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
          {{ $properties['native'] }}
        </a>
      @endforeach
      </div>
    </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons text-primary">dashboard</i>
          <p>@lang('sidebar-ts.dashboard')</p>
        </a>
      </li>
       <li class="nav-item ">
            <a class="nav-link" href="{{ url('trips') }}">
            <i class="material-icons text-primary">trip_origin</i>
            <p>@lang('sidebar-ts.trip')</p>
            </a>
        </li>


        <li class="nav-item ">
            <a class="nav-link" href="{{ url('trip-bookings') }}">
            <i class="material-icons text-primary">local_shipping</i>
            <p>@lang('sidebar-ts.tbooking')</p>
            </a>
        </li>


      @role('admin')

      <li class="nav-item ">
        <a class="nav-link" href="{{ url('admins') }}">
          <i class="material-icons text-primary">person</i>
          <p>@lang('sidebar-ts.admin')</p>
        </a>
      </li>
      @endrole
      @hasanyrole('admin|sub_admin')
      {{-- <li class="nav-item ">
        <a class="nav-link" href="{{ url('users') }}">
          <i class="material-icons">person</i>
          <p>@lang('sidebar-ts.user')</p>
        </a>
      </li> --}}


      @can('user')
      <li class="nav-item dropdown show">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
          <i class="material-icons text-primary">person</i>
          <p>
            @lang('sidebar-ts.user')
          </p>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="{{ url('users/user') }}">User</a>
          <a class="dropdown-item" href="{{ url('users/partner') }}">Partner</a>
        </div>
      </li>
      @endcan

      @can('slider')
        <li class="nav-item ">
            <a class="nav-link" href="{{ url('sliders') }}">
            <i class="material-icons text-primary">slideshow</i>
            <p>@lang('sidebar-ts.sliders')</p>
            </a>
        </li>
      @endcan
      @can('product_type')
      <li class="nav-item ">
        <a class="nav-link" href="{{ url('product-types') }}">
          <i class="material-icons text-primary">category</i>
          <p>@lang('sidebar-ts.product_type')</p>
        </a>
      </li>
      @endcan

      @can('promo_code')
      <li class="nav-item ">
        <a class="nav-link" href="{{ url('promo-codes') }}">
          <i class="material-icons text-primary">content_copy</i>
          <p>@lang('sidebar-ts.promo')</p>
        </a>
      </li>
      @endcan
      @can('country')
      <li class="nav-item ">
        <a class="nav-link" href="{{ url('countries') }}">
          <i class="material-icons text-primary">flag</i>
          <p>@lang('sidebar-ts.country')</p>
        </a>
      </li>
      @endcan
      @can('state')
      <li class="nav-item ">
        <a class="nav-link" href="{{ url('states') }}">
          <i class="material-icons text-primary">business</i>
          <p>@lang('sidebar-ts.state')</p>
        </a>
      </li>
      @endcan
      @can('city')
      <li class="nav-item ">
        <a class="nav-link" href="{{ url('cities') }}">
          <i class="material-icons text-primary">apartment</i>
          <p>@lang('sidebar-ts.city')</p>
        </a>
      </li>
      @endcan
      {{-- <li class="nav-item ">
        <a class="nav-link" href="{{ url('categories') }}">
          <i class="material-icons">person</i>
          <p>@lang('sidebar-ts.category')</p>
        </a>
      </li>

      <li class="nav-item ">
        <a class="nav-link" href="{{ url('products') }}">
          <i class="material-icons">person</i>
          <p>@lang('sidebar-ts.products')</p>
        </a>
      </li> --}}
      @can('feature')
      <li class="nav-item ">
        <a class="nav-link" href="{{ url('features') }}">
          <i class="material-icons text-primary">featured_play_list</i>
          <p>@lang('sidebar-ts.feature')</p>
        </a>
      </li>
      @endcan
      {{-- <li class="nav-item ">
        <a class="nav-link" href="{{ url('orders') }}">
          <i class="material-icons">person</i>
          <p>@lang('sidebar-ts.order')</p>
        </a>
      </li> --}}
      @can('charge')
      <li class="nav-item ">
        <a class="nav-link" href="{{ url('service-charges') }}">
          <i class="material-icons text-primary">attach_money</i>
          <p>@lang('sidebar-ts.charge')</p>
        </a>
      </li>
      @endcan
      @can('wallet')
      <li class="nav-item dropdown show">
        <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
          <i class="material-icons text-primary">wallet</i>
          <p>
            @lang('sidebar-ts.wallet')
          </p>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          {{-- <a class="dropdown-item" href="{{ url('order-wallets') }}">Order</a> --}}
          <a class="dropdown-item" href="{{ url('trip-wallets') }}">{{ __('sidebar-ts.trip') }}</a>
          <a class="dropdown-item" href="{{ url('wallets-manage') }}">{{ __('sidebar-ts.wallet_manage') }}</a>
          {{-- <a class="dropdown-item" href="{{ url('shipment-wallets') }}">Shipment</a> --}}
        </div>
      </li>
      @endcan
      {{-- <li class="nav-item ">
        <a class="nav-link" href="{{ url('terms') }}">
          <i class="material-icons">person</i>
          <p>@lang('sidebar-ts.terms')</p>
        </a>
      </li> --}}
      @can('page')
      <li class="nav-item ">
        <a class="nav-link" href="{{ url('pages') }}">
          <i class="material-icons text-primary">pages</i>
          <p>@lang('sidebar-ts.pages')</p>
        </a>
      </li>
      @endcan
      @endhasanyrole
      @role('partner')
      <li class="nav-item ">
        <a class="nav-link" href="{{ url('partner-payment-methods') }}">
          <i class="material-icons text-primary">payment</i>
          <p>@lang('sidebar-ts.payment-method')</p>
        </a>
      </li>
      <li class="nav-item ">
        <a class="nav-link" href="{{ url('cars') }}">
          <i class="material-icons text-primary">directions_car_filled</i>
          <p>@lang('sidebar-ts.car')</p>
        </a>
      </li>
      @endrole

      @role('partner')
      <li class="nav-item ">
        <a class="nav-link" href="{{ url('referrals') }}">
          <i class="material-icons text-primary">people</i>
          <p>Referrals</p>
        </a>
      </li>
      @endrole

      @role('admin')
      <li class="nav-item ">
        <a class="nav-link" href="{{ url('adminCars') }}">
          <i class="material-icons text-primary">directions_car_filled</i>
          <p>@lang('sidebar-ts.car')</p>
        </a>
      </li>

      <li class="nav-item ">
        <a class="nav-link" href="{{ url('adminReferrals') }}">
          <i class="material-icons text-primary">directions_car_filled</i>
          <p>Referrals</p>
        </a>
      </li>
      @endrole

      @role('admin|partner|sub_admin')

      {{-- @if(auth()->user()->hasrole('sub_admin') && auth()->user()->can('withdraw')) --}}
      @hasrole('sub_admin')
        @can('withdraw')
            <li class="nav-item dropdown show">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <i class="material-icons text-primary">payment</i>
                <p>
                    @lang('sidebar-ts.withdraw')
                </p>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                @role('partner')
                    <a class="dropdown-item" href="{{ url('withdraw-requests/create') }}">@lang('sidebar-ts.create')</a>
                @endrole
                <a class="dropdown-item" href="{{ url('withdraw-requests') }}">@lang('sidebar-ts.accept')</a>
                <a class="dropdown-item" href="{{ url('pending-withdraw-requests') }}">@lang('sidebar-ts.pending')</a>
                </div>
            </li>
        @endcan
      @else
        <li class="nav-item dropdown show">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            <i class="material-icons text-primary">payment</i>
            <p>
                @lang('sidebar-ts.withdraw')
            </p>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            @role('partner')
                <a class="dropdown-item" href="{{ url('withdraw-requests/create') }}">@lang('sidebar-ts.create')</a>
            @endrole
            <a class="dropdown-item" href="{{ url('withdraw-requests') }}">@lang('sidebar-ts.accept')</a>
            <a class="dropdown-item" href="{{ url('pending-withdraw-requests') }}">@lang('sidebar-ts.pending')</a>
            </div>
        </li>
      @endhasrole


      @hasrole('sub_admin')
        @can('payment_history')
        <li class="nav-item ">
            <a class="nav-link" href="{{ url('partner-payment-hostories') }}">
            <i class="material-icons text-primary">payment</i>
            <p>@lang('sidebar-ts.history')</p>
            </a>
        </li>
        @endcan
        @can('trip')
        <li class="nav-item ">
            <a class="nav-link" href="{{ url('trips') }}">
            <i class="material-icons text-primary">trip_origin</i>
            <p>@lang('sidebar-ts.trip')</p>
            </a>
        </li>
        @endcan
        @can('trip_booking')
        <li class="nav-item ">
            <a class="nav-link" href="{{ url('trip-bookings') }}">
            <i class="material-icons text-primary">local_shipping</i>
            <p>@lang('sidebar-ts.tbooking')</p>
            </a>
        </li>
        @endcan
        {{-- <li class="nav-item ">
            <a class="nav-link" href="{{ url('ship-bookings') }}">
            <i class="material-icons">person</i>
            <p>@lang('sidebar-ts.sbooking')</p>
            </a>
        </li> --}}
        @can('trip_review')
        <li class="nav-item ">
            <a class="nav-link" href="{{ url('reviews') }}">
            <i class="material-icons text-primary">reviews</i>
            <p>@lang('sidebar-ts.review')</p>
            </a>
        </li>
        @endcan
        {{-- <li class="nav-item ">
            <a class="nav-link" href="{{ url('review-ships') }}">
            <i class="material-icons">person</i>
            <p>@lang('sidebar-ts.sreview')</p>
            </a>
        </li> --}}
        @can('complain')
        <li class="nav-item ">
            <a class="nav-link" href="{{ url('complains') }}">
            <i class="material-icons text-primary">feedback</i>
            <p>@lang('sidebar-ts.complain')</p>
            </a>
        </li>
        @endcan
      @else

        <li class="nav-item ">
            <a class="nav-link" href="{{ url('partner-payment-hostories') }}">
            <i class="material-icons text-primary">history</i>
            <p>@lang('sidebar-ts.history')</p>
            </a>
        </li>


       
        {{-- <li class="nav-item ">
            <a class="nav-link" href="{{ url('ship-bookings') }}">
            <i class="material-icons">person</i>
            <p>@lang('sidebar-ts.sbooking')</p>
            </a>
        </li> --}}

        <li class="nav-item ">
            <a class="nav-link" href="{{ url('reviews') }}">
            <i class="material-icons text-primary">reviews</i>
            <p>@lang('sidebar-ts.review')</p>
            </a>
        </li>

        {{-- <li class="nav-item ">
            <a class="nav-link" href="{{ url('review-ships') }}">
            <i class="material-icons">person</i>
            <p>@lang('sidebar-ts.sreview')</p>
            </a>
        </li> --}}

        <li class="nav-item ">
            <a class="nav-link" href="{{ url('complains') }}">
            <i class="material-icons text-primary">feedback</i>
            <p>@lang('sidebar-ts.complain')</p>
            </a>
        </li>

        <li class="nav-item ">
            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="material-icons text-primary">exit_to_app</i>
            <p>@lang('header.logout')</p>
            </a>
        </li>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        <li class="nav-item ">
            <a class="nav-link" href="{{ url('profile-update') }}">
            <i class="material-icons text-primary">create</i>
            <p>@lang('header.update_profile')</p>
            </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="{{ url('change-password') }}">
            <i class="material-icons text-primary">lock</i>
            <p>@lang('header.change_password')</p>
            </a>
        </li>


      @endhasrole

      <!--<li class="nav-item d-block d-lg-none d-md-none">-->
      <!--  <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">-->
      <!--    <i class="material-icons text-primary">logout</i>-->
      <!--    <p>@lang('header.logout')</p>-->
      <!--  </a>-->
      <!--  <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" style="display: none;">-->
      <!--    @csrf-->
      <!--  </form>-->
      <!--</li>-->
      @endrole



    </ul>
  </div>
</div>
