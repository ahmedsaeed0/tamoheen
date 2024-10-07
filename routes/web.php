<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\FrontendsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TripsController;
use App\Http\Controllers\TripBookingsController;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\CountriesController;
use App\Http\Controllers\StatesController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\FeaturesController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\EwalletsController;
use App\Http\Controllers\WithdrawRequestsController;
use App\Http\Controllers\ComplainsController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PromoCodesController;
use App\Http\Controllers\PaytabsController;
use App\Http\Controllers\TelrController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\StcPaymentsController;
use App\Http\Controllers\SlidersController;
use App\Http\Controllers\ProductTypesController;
use App\Http\Controllers\PartnerPaymentMethodsController;
use App\Http\Controllers\ServiceChargesController;
// use App\Http\Controllers\WithdrawRequestsController;
// use App\Http\Controllers\PaytabsController;
use App\Http\Controllers\PartnerPaymentHostoriesController;
use App\Http\Controllers\ReferralsController;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


// Route::get('/sanjeev', 'FrontendsController@testMail');
// Route::get('/newtestMail', 'FrontendsController@newtestMail');
  Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function() {
Auth::routes();
    Route::get('/test', [FrontendsController::class,'tripBookingFormSubmit']);

	Route::group(['middleware' => ['auth']], function() {
		Route::get('/home', [HomeController::class,'index'])->name('home');
		Route::get('change-password', [UsersController::class,'ChangePasswordView']);
		Route::post('/change-password', [UsersController::class,'changePassword']);
		Route::group(['middleware' => ['role:admin|sub_admin']], function(){
			Route::get('users/{type}', [UsersController::class,'index']);
			Route::post('users', [UsersController::class,'adminAdd']);
			Route::get('users/{id}/edit',[UsersController::class ,'edit']);
			Route::patch('users/{id}', [UsersController::class,'update']);
			Route::get('users/{id}/show', [UsersController::class,'show']);
			Route::get('users/{id}/referralShow', [UsersController::class,'referralShow']);
			Route::get('user-inactive/{id}', [UsersController::class,'userInactive']);
			Route::get('user-active/{id}', [UsersController::class,'userActive']);
			Route::get('users-create', [UsersController::class,'create']);
			Route::delete('userDelete/{id}', [UsersController::class,'destroy']);

            Route::get('admins', [AdminController::class,'index']);
			Route::get('admins/create', [AdminController::class,'create']);
			Route::post('admins', [AdminController::class,'store']);
			Route::get('admins/{id}/edit', [AdminController::class,'edit']);
			Route::patch('admins/{id}', [AdminController::class,'update']);
			Route::get('admins/{id}', [AdminController::class,'show']);
            Route::get('admin-inactive/{id}', [AdminController::class,'userInactive']);
			Route::get('admin-active/{id}', [AdminController::class,'userActive']);
            Route::get('admins/{id}/permissions', [AdminController::class,'permissionView']);
            Route::post('permission-update', [AdminController::class,'updatePermission']);

			//Country
			Route::get('countries', [CountriesController::class,'index']);
			Route::get('countries/create', [CountriesController::class,'create']);
			Route::post('countries', [CountriesController::class,'store']);
			Route::get('countries/{id}/edit', [CountriesController::class,'edit']);
			Route::post('countries/{id}', [CountriesController::class,'update']);
			Route::get('countries/{id}', [CountriesController::class,'show']);
			Route::delete('countries/{id}', [CountriesController::class,'destroy']);

			//State
			Route::get('states', [StatesController::class,'index']);
			Route::get('states/create', [StatesController::class,'create']);
			Route::post('states', [StatesController::class,'store']);
			Route::get('states/{id}/edit', [StatesController::class,'edit']);
			Route::post('states/{id}', [StatesController::class,'update']);
			Route::get('states/{id}', [StatesController::class,'show']);
			Route::delete('states/{id}', [StatesController::class,'destroy']);

			//City
			Route::get('cities', [CitiesController::class,'index']);
			Route::get('cities/create', [CitiesController::class,'create']);
			Route::post('cities', [CitiesController::class,'store']);
			Route::get('cities/{id}/edit', [CitiesController::class,'edit']);
			Route::post('cities/{id}', [CitiesController::class,'update']);
			Route::get('cities/{id}', [CitiesController::class,'show']);
			Route::delete('cities/{id}', [CitiesController::class,'destroy']);

			//Category
			Route::get('categories', [CategoriesController::class,'index']);
			Route::get('categories/{id}/edit', [CategoriesController::class,'edit']);
			Route::get('categories/create', [CategoriesController::class,'create']);
			Route::post('categories', [CategoriesController::class,'store']);
			Route::post('categories/{id}', [CategoriesController::class,'update']);
			Route::get('categories/{id}', [CategoriesController::class,'show']);
			Route::delete('categories/{id}', [CategoriesController::class,'destroy']);

			//Product
			Route::get('products', [ProductsController::class,'index']);
			Route::get('products/{id}/edit', [ProductsController::class,'edit']);
			Route::get('products/create', [ProductsController::class,'create']);
			Route::post('products', [ProductsController::class,'store']);
			Route::post('products/{id}', [ProductsController::class,'update']);
			Route::get('products/{id}', [ProductsController::class,'show']);
			Route::delete('products/{id}', [ProductsController::class,'destroy']);

			//Feature
			Route::get('features', [FeaturesController::class,'index']);
			Route::get('features/{id}/edit', [FeaturesController::class,'edit']);
			Route::get('features/create', [FeaturesController::class,'create']);
			Route::post('features', [FeaturesController::class,'store']);
			Route::patch('features/{id}', [FeaturesController::class,'update']);
			Route::get('features/{id}', [FeaturesController::class,'show']);
			Route::delete('features/{id}', [FeaturesController::class,'destroy']);

			Route::get('orders', [OrdersController::class,'index']);
			Route::get('orders/{id}', [OrdersController::class,'show']);
			Route::get('order-accept/{id}', [OrdersController::class,'orderAccept']);
			Route::get('order-ongoing/{id}', [OrdersController::class,'orderOngoing']);
			Route::get('order-delivery/{id}', [OrdersController::class,'orderDelivery']);

			//Slider

			// Route::resource('sliders', [SlidersController::class]);
			Route::resource('sliders', SlidersController::class);

			//Product Type

			Route::resource('product-types', ProductTypesController::class);
			Route::post('product-types', [ProductTypesController::class, 'store']);

			//E-wallet

			Route::get('order-wallets', [EwalletsController::class,'indexOrder']);
			Route::get('trip-wallets', [EwalletsController::class,'indexTrip']);
			Route::get('wallets-manage', [EwalletsController::class,'walletsManage'])->name('wallet-manage');
			Route::get('settle-amount/{id}', [EwalletsController::class,'settleAmount']);
			Route::get('shipment-wallets', [EwalletsController::class,'indexShipment']);

			Route::get('withdraw-requests-accept/{id}', [WithdrawRequestsController::class,'withdrawAccept']);

			Route::resource('service-charges', ServiceChargesController::class);

			Route::get('promo-codes', [PromoCodesController::class,'index']);
			Route::get('promo-codes/create', [PromoCodesController::class,'create']);
			Route::post('promo-codes',[PromoCodesController::class,'store']);
			Route::get('promo-codes/{id}/edit', [PromoCodesController::class,'edit']);
			Route::patch('promo-codes/{id}', [PromoCodesController::class,'update']);
			Route::delete('promo-codes/{id}', [PromoCodesController::class,'destroy']);

			Route::get('terms', 'TermsController@index');
			Route::post('terms', 'TermsController@store');
			Route::get('terms/{id}', 'TermsController@show');
			Route::get('terms/{id}/edit', 'TermsController@edit');
			Route::post('terms/{id}', 'TermsController@update');

			Route::get('pages', [PageController::class,'index']);
			Route::get('pages/create', [PageController::class,'create']);
			Route::post('pages', [PageController::class,'store']);
			Route::get('pages/{id}', [PageController::class,'show']);
			Route::get('pages/{id}/edit', [PageController::class,'edit']);
			Route::patch('pages/{id}', [PageController::class,'update']);
			Route::delete('pages/{id}', [PageController::class,'destroy']);
            Route::get('pages/deactive/{id}', [PageController::class,'deactivePage']);
            Route::get('pages/active/{id}', [PageController::class,'activePage']);

			// Route::post('wallets_update', 'EwalletsController@wallets_update');
			Route::post('wallets_update', [EwalletsController::class,'wallets_update'])->name('wallets_update');
			Route::get('revert/{id}', [EwalletsController::class,'revert']);
			//Car
			Route::get('adminCars', [CarsController::class,'adminCar']);
			Route::get('adminCars/{id}', [CarsController::class,'AdminCarshow']);
			Route::get('adminReferrals', [AdminController::class,'referralsAll']);
		});

		Route::group(['middleware' => ['role:partner']], function(){
			//Car
			Route::get('cars', [CarsController::class,'index']);
			Route::get('cars/{id}/edit', [CarsController::class,'edit']);
			Route::get('cars/create', [CarsController::class,'create']);
			Route::post('save_car', [CarsController::class,'store']);
			Route::post('cars/{id}', [CarsController::class,'update']);
			Route::get('cars/{id}', [CarsController::class,'show']);
			Route::delete('cars/{id}', [CarsController::class,'destroy']);
			Route::post('ajax-car-data', [CarsController::class,'ajaxCarData']);

			//Tripl
			Route::get('trips/create', [TripsController::class,'create']);
			Route::post('trips', [TripsController::class,'store']);
			Route::post('trip-copy', [TripsController::class,'tripCopy'])->name('trip.copy');
			Route::post('trip-discount', [TripsController::class,'tripDiscount'])->name('trip.discount');
			Route::delete('trips/{id}', [TripsController::class,'destroy']);
			Route::get('trip-cancel/{id}', [TripsController::class,'tripCancel']);
			Route::get('trip-complete/{id}', [TripsController::class,'tripComplete']);

			//TripBooking
			Route::get('check-in/{id}',[TripBookingsController::class,'checkInView']);
			Route::get('/direct-check-in/{id}', [TripBookingsController::class,'directCheckIn']);
			Route::get('ship-check-in/{id}',[TripBookingsController::class,'checkInShipView']);
			Route::post('/check-in-submit', [TripBookingsController::class,'checkIn']);
			Route::post('/ship-check-in-submit', [TripBookingsController::class,'checkInShip']);
			Route::get('ship-check-out/{id}',[TripBookingsController::class,'checkOutShipView']);
			Route::get('check-out/{id}',[TripBookingsController::class,'checkOutView']);
			Route::post('/check-out-submit', [TripBookingsController::class,'checkOut']);
			Route::post('/ship-check-out-submit', [TripBookingsController::class,'checkOutShip']);
			Route::get('trip-booking-complete/{id}', [TripBookingsController::class,'tripBookingComplete']);
			Route::get('ship-booking-complete/{id}', [TripBookingsController::class,'shipBookingComplete']);
			Route::delete('ship-trip-bookings/{id}', [TripBookingsController::class,'shipDestroy']);
			Route::delete('trip-bookings/{id}', [TripBookingsController::class,'destroy']);

			//Review
			Route::delete('reviews/{id}', [ReviewsController::class,'destroy']);
			Route::delete('review-ship-delete/{id}', [ReviewsController::class,'destroyShip']);

			//Complain
			Route::delete('complains/{id}', [ComplainsController::class,'destroy']);

			//Payment Section
			Route::resource('partner-payment-methods', PartnerPaymentMethodsController::class);

			//Referrals
			Route::get('referrals', [ReferralsController::class,'index']);
		});

		Route::group(['middleware' => ['role:admin|partner']], function(){
			Route::get('trips', [TripsController::class,'index']);
			Route::get('trips/{id}', [TripsController::class,'show']);

			Route::get('trip-bookings', [TripBookingsController::class,'index']);
			Route::get('ship-bookings', [TripBookingsController::class,'indexShip']);
			Route::get('trip-bookings/{id}', [TripBookingsController::class,'show']);
			Route::get('ship-trip-bookings/{id}', [TripBookingsController::class,'showShipBooking']);

			Route::get('reviews', [ReviewsController::class,'index']);
			Route::get('review-ships', [ReviewsController::class,'indexShip']);

			Route::get('complains', [ComplainsController::class,'index']);

			Route::resource('partner-payment-hostories', PartnerPaymentHostoriesController::class);

			Route::resource('withdraw-requests', WithdrawRequestsController::class);
			Route::get('pending-withdraw-requests', [WithdrawRequestsController::class,'pendingList']);

            Route::get('profile-update', [UsersController::class,'profileUpdate']);
            Route::Patch('update-profile/{id}', [UsersController::class,'updateProfile']);
		});



	});


	// Route::get('all-terms', 'FrontendsController@termsList');
	Route::get('single-trip/{id}', [FrontendsController::class,'singleTrip']);
	Route::get('trip-list', [FrontendsController::class,'tripList'])->name('trip-list');
	Route::get('ship-list', [FrontendsController::class,'shipList']);
	Route::get('price-range-search/{min_price}/{max_price}', [FrontendsController::class,'tripSearchByPriceRange']);
	Route::get('ship-price-range-search/{min_price}/{max_price}/{to_city}', [FrontendsController::class,'shipSearchByPriceRange']);

	Route::get('single-product/{id}', [FrontendsController::class,'singleProduct']);
	Route::get('/user-login', [FrontendsController::class,'login']);
	Route::get('/user-signup', [FrontendsController::class, 'signup']);

	Route::post('user-signup', [UsersController::class,'userSignup']);
	Route::post('/partner-signup', [UsersController::class,'partnerSignup']);
	Route::get('/riyadh', [FrontendsController::class,'riyadh']);
	Route::get('/jeddah', [FrontendsController::class,'jeddah']);
	Route::get('/makkah', [FrontendsController::class,'makkah']);
	Route::get('/medina', [FrontendsController::class,'medina']);
	Route::get('/dammam', [FrontendsController::class,'dammam']);
	Route::get('/tabuk', [FrontendsController::class,'tabuk']);
	Route::get('/shop', [FrontendsController::class,'shop']);

	Route::get('/trip-booking-form', [FrontendsController::class,'tripBookingForm']);
	Route::post('/booking-submit', [FrontendsController::class,'tripBookingFormSubmit'])->name('booking-submit');

	Route::post('shipment-form', [FrontendsController::class,'shipmentForm']);
	Route::post('shipping-submit', [FrontendsController::class,'shipmentFormSubmit']);
	Route::get('ship-payment/{ship_booking_id}/{user_id}', [FrontendsController::class,'paymentShipView']);


	Route::get('payment/{trip_booking_id}/{user_id}', [FrontendsController::class,'paymentView']);
	Route::post('/paytab-payment-submit', [FrontendsController::class,'paytabPaymentSubmit'])->name('paytab-payment-submit');
	Route::post('/stc-payment-submit', [FrontendsController::class,'paymentStcSubmit'])->name('stc-payment-submit');
	Route::get('paytab-payment-success/{id}', [PaytabsController::class,'paytabPaymentSuccess']);
	Route::get('paytab-payment-success-pdf/{id}', [PaytabsController::class,'paytabPaymentSuccessPDF']);
	

	//Paytab
	Route::get('paytab-payment/{id}', [PaytabsController::class,'paytabPayment']);
	Route::post('/return-trip-booking', [PaytabsController::class,'paytabResponseBooking']);

	//Telr Trip
	Route::get('telr-trip-payment/{id}', [TelrController::class,'telrTripPayment']);
	Route::post('telr-trip-payment-submit', [TelrController::class,'telrTripPaymentSubmit']);
	Route::get('return-telr-trip-booking-success', [TelrController::class,'telrTripResponseBookingSuccess'])->name('telr.success');
	Route::get('return-telr-trip-booking-cancel', [TelrController::class,'telrTripResponseBookingCancel'])->name('telr.cancel');
	Route::get('return-telr-trip-booking-decline', [TelrController::class,'telrTripResponseBookingDecline'])->name('telr.decline');
	Route::get('telr-trip-payment-success/{id}', [TelrController::class,'telrTripPaymentSuccess']);
	Route::get('handle-payment/{status}', [TelrController::class,'telrTripResponseBookingSuccess']);

	//Telr Ship
	Route::get('telr-ship-payment/{id}', [TelrController::class,'telrShipPayment']);
	Route::post('telr-ship-payment-submit', [TelrController::class,'telrShipPaymentSubmit']);
	Route::get('return-telr-ship-booking-success', [TelrController::class,'telrShipResponseBookingSuccess']);
	Route::get('return-telr-ship-booking-cancel', [TelrController::class,'telrShipResponseBookingCancel']);
	Route::get('return-telr-ship-booking-decline', [TelrController::class,'telrShipResponseBookingDecline']);
	Route::get('telr-ship-payment-success/{id}', [TelrController::class,'telrShipPaymentSuccess']);

	//Shipment Paytab
	Route::get('ship-paytab-payment/{id}', [PaytabsController::class,'paytabShipPayment']);
	Route::post('/return-ship-booking', [PaytabsController::class,'returnShipBooking']);
	Route::post('/ship-paytab-payment-submit', [FrontendsController::class,'shipPaytabPaymentSubmit']);
	Route::get('shipment-payment-success/{id}', [FrontendsController::class,'shipmentPaymentSuccess']);


	// Exporting Route....
	Route::get('/export-excel/{slug}', [ExcelController::class,'export'])->name('exportExcel');


	Route::post('/stc-ship-payment-submit', [FrontendsController::class,'stcShipPaymentSubmit']);



    Route::group(['middleware' => ['auth']], function() {
        Route::group(['middleware' => ['role:user']], function(){
            Route::get('add-cart/{id}', [FrontendsController::class,'addCart']);
            Route::get('cart-list', [FrontendsController::class,'cartList']);
            Route::post('ajax-delete-cart', [FrontendsController::class,'deleteCartByAjax']);
			Route::post('ajax-update-quantity-cart', [FrontendsController::class,'updateQunatityCartByAjax']);
			Route::get('/address', [FrontendsController::class,'addressView']);
			Route::get('/add-address', [FrontendsController::class,'addAddressView']);
			Route::post('/ajax-state-list', [FrontendsController::class,'ajaxStateList']);
			Route::post('/ajax-city-list', [FrontendsController::class,'ajaxCityList']);
			Route::post('/address-submit', [FrontendsController::class,'addressSubmit']);
			Route::get('product-summary/{address_id}', [FrontendsController::class,'productSummary']);



			Route::get('/payment-method/{address_id}/{user_id}', [FrontendsController::class,'productPayment']);
			Route::post('/product-paytab-payment-submit', [FrontendsController::class,'productPaytabPaymentSubmit'])->name('product-paytab-payment-submit');
			Route::post('/product-stc-payment-submit', [FrontendsController::class,'productStcPaymentSubmit'])->name('product-stc-payment-submit');

			Route::get('product-payment-success/{id}', [PaytabsController::class,'productPaymentSuccess']);

			Route::get('/user-change-password', [FrontendsController::class,'userChangePasswordView'])->name('user-change-password');
			Route::get('/user-payment-method', [FrontendsController::class,'userPaymentMethodView'])->name('user-payment-method');
			Route::post('/user-update-password', [FrontendsController::class,'updatePassword'])->name('user-update-password');
			Route::post('/user-add-payment-method', [FrontendsController::class,'userAddPaymentMethod'])->name('user-add-payment-method');
			Route::get('user-trip-booking-list', [FrontendsController::class,'bookingList']);
			Route::get('user-ship-booking-list', [FrontendsController::class,'bookingShipList']);
			Route::get('review/{id}', [FrontendsController::class,'review']);
			Route::post('review-submit', [FrontendsController::class,'reviewSubmit'])->name('review-submit');
			Route::get('complain/{id}/{type}', [FrontendsController::class,'complain']);
			Route::post('complain-submit', [FrontendsController::class,'complainSubmit'])->name('complain-submit');
			Route::get('user-order-list', [FrontendsController::class,'orderList']);



			//Product Paytab
			Route::get('product-paytab-payment/{id}', [PaytabsController::class,'productPaytabPayment']);
			Route::post('/return-order', [PaytabsController::class,'paytabResponseOrder']);

			//Telr Product
			Route::get('telr-product-payment/{id}', [TelrController::class,'telrProductPayment']);
			Route::post('telr-product-payment-submit', [TelrController::class,'telrProductPaymentSubmit']);
			Route::get('return-telr-product-booking-success', [TelrController::class,'telrProductResponseBookingSuccess']);
			Route::get('return-telr-product-booking-cancel', [TelrController::class,'telrProductResponseBookingCancel']);
			Route::get('return-telr-product-booking-decline', [TelrController::class,'telrProductResponseBookingDecline']);
			Route::get('telr-product-payment-success/{id}', [TelrController::class,'telrProductPaymentSuccess']);

            //Stc Payment All
			Route::post('/direct-stc-product-payment-confirm', [StcPaymentsController::class,'stcProductPaymentConfirm'])->name('direct-stc-product-payment-confirm');

            Route::get('trip-booking-cancel/{id}', [FrontendsController::class,'tripBookingCancel']);
			Route::get('ship-booking-cancel/{id}', [FrontendsController::class,'shipBookingCancel']);

			//Profile
			Route::get('user-profile', [FrontendsController::class,'userProfile']);

        });
	});
    Route::get('city/{id}', [FrontendsController::class,'singleCity']);
    Route::get('/{slug}', [FrontendsController::class,'singleDynamicPage']);
    Route::get('/', [FrontendsController::class,'index']);
   
     Route::get('/route-cache', function() {
        $exitCode = Artisan::call('route:cache');
        $exitCode = Artisan::call('config:cache');
        $exitCode = Artisan::call('cache:clear');
        $exitCode = Artisan::call('view:clear');
        return 'Routes cache cleared';
     });
	 

	
	 
});





