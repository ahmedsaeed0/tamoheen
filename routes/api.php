<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
use Illuminate\Support\Facades\DB;






Route::get('/databases', function() {
    // تحديث جميع السجلات حيث يكون imageable_type يساوي 'AppModelsUser' إلى 'App\Models\User'
    DB::update("UPDATE `model_has_roles` SET `model_type` = 'App\\\Models\\\User' WHERE `imageable_type` = ?", ['App\User']);
    
    // إرجاع رسالة نجاح
    return response()->json(['message' => 'Records updated successfully!']);
});


// Route::get('all-trips', 'Api\TripsController@allTrips');
// Route::post('user-register', 'Api\Auth\RegisterController@registerUser');
// Route::post('partner-register', 'Api\Auth\RegisterController@registerPartner');
// Route::post('login', 'Api\Auth\LoginController@login');

// Route::get('search-trip', 'Api\FrontendsController@searchTrip');
// Route::get('search-ship', 'Api\FrontendsController@searchShip');
// Route::get('trip-detail/{id}', 'Api\FrontendsController@tripDetail');
// Route::get('trip-review/{id}', 'Api\FrontendsController@tripReviews');

// Route::get('country-list', 'Api\FrontendsController@countryList');
// Route::get('get-state/{country_id}', 'Api\FrontendsController@stateList');
// Route::get('get-city/{state_id}', 'Api\FrontendsController@cityList');

// Route::get('front-cities', 'Api\CitiesController@index');
// Route::get('cities', 'Api\CitiesController@index');
// Route::get('front-cities/{id}', 'Api\CitiesController@show');

// Route::get('reviews/user/{user_id}', 'Api\ReviewsController@getUserReview');
// Route::get('products/{id}', 'Api\ProductsController@show');
// Route::get('products', 'Api\ProductsController@index');

// Route::get('front-features', 'Api\FrontendsController@frontFeatures');
// Route::get('front-main-features', 'Api\FrontendsController@frontMainFeatures');

// Route::post('trip-booking', 'Api\TripBookingsController@store');
// Route::post('ship-booking', 'Api\TripBookingsController@storeShip');
// Route::get('tripbooking/{id}', 'Api\FrontendsController@bookingDetails');


// Route::post('return-trip-booking', 'Api\PaytabsController@paytabResponseBooking');
// Route::post('stc-payment-submit', 'Api\FrontendsController@paymentStcSubmit');
// Route::post('direct-stc-payment-confirm', 'Api\FrontendsController@stcTripPaymentConfirm');


// Route::get('ship-paytab-payment/{id}', 'Api\PaytabsController@paytabShipPayment');
// Route::post('return-ship-booking', 'Api\PaytabsController@returnShipBooking');
// Route::post('stc-ship-payment-submit', 'Api\FrontendsController@stcShipPaymentSubmit');
// Route::post('direct-stc-ship-payment-confirm', 'Api\FrontendsController@stcShipPaymentConfirm');

// Route::get('product-list-by-category/{id}', 'Api\FrontendsController@productListByCategory');

// Route::get('get-promo-codes', 'Api\PromoCodesController@get_promo_codes');

// Route::post('telr-payment-submit-for-trip-booking', 'Api\PaymentGatewayController@telrGatewayForBooking');

// Route::get('terms', 'Api\FrontendsController@terms');

// Route::group([
//     'prefix' => 'password'
// ], function () {
//     Route::post('create', 'Api\Auth\PasswordResetController@create');
//     Route::get('find/{token}', 'Api\Auth\PasswordResetController@find');
//     Route::post('reset', 'Api\Auth\PasswordResetController@reset');
// });

// Route::group(['middleware' => ['auth:api']], function() {
// 	Route::post('logout','Api\UsersController@logoutApi');
	
//     Route::group(['middleware' => ['role:admin']], function(){

		

//     	Route::get('user-active/{id}', 'Api\UsersController@userActive');
// 	    Route::get('user-deactive/{id}', 'Api\UsersController@userDeactive');
// 	    Route::get('user-list', 'Api\UsersController@userList');
// 		Route::post('add-admin-by-admin', 'Api\UsersController@addAdmin');
// 		Route::get('driver-list', 'Api\UsersController@driverList');

		
// 		Route::post('countries', 'Api\CountriesController@store');
// 		Route::get('countries/{id}', 'Api\CountriesController@show');
// 		Route::get('countries/{id}/edit', 'Api\CountriesController@edit');
// 		Route::post('countries/{id}', 'Api\CountriesController@update');
// 		Route::delete('countries/{id}', 'Api\CountriesController@destroy');

	
// 		Route::get('states', 'Api\StatesController@index');
// 		Route::post('states', 'Api\StatesController@store');
// 		Route::get('states/{id}', 'Api\StatesController@show');
// 		Route::get('states/{id}/edit', 'Api\StatesController@edit');
// 		Route::post('states/{id}', 'Api\StatesController@update');
// 		Route::delete('states/{id}', 'Api\StatesController@destroy');
		

	   
// 	    Route::post('cities', 'Api\CitiesController@store');
// 	    Route::post('cities/{id}', 'Api\CitiesController@update');
// 	    Route::get('cities/{id}/edit', 'Api\CitiesController@edit');
// 	    Route::get('cities/{id}', 'Api\CitiesController@show');
// 	    Route::delete('cities/{id}', 'Api\CitiesController@destroy');

	   
// 	    Route::post('categories', 'Api\CategoriesController@store');
// 	    Route::post('category-update', 'Api\CategoriesController@update');
// 	    Route::get('categories', 'Api\CategoriesController@index');
// 	    Route::get('categories/{id}', 'Api\CategoriesController@show');
// 	    Route::delete('categories/{id}', 'Api\CategoriesController@destroy');

	    
// 	    Route::post('products', 'Api\ProductsController@store');
// 	    Route::post('products/{id}', 'Api\ProductsController@update');
// 	    Route::delete('products/{id}', 'Api\ProductsController@destroy');
// 	    Route::get('product-active/{id}', 'Api\ProductsController@productActive');  
// 	    Route::get('product-deactive/{id}', 'Api\ProductsController@productDeactive');

	  

// 	    Route::get('features', 'Api\FeaturesController@index');
// 	    Route::post('features', 'Api\FeaturesController@store');
// 	    Route::get('features/{id}', 'Api\FeaturesController@show');
// 	    Route::post('feature-update', 'Api\FeaturesController@update');
// 	    Route::delete('features/{id}', 'Api\FeaturesController@destroy');
//     });
    
//     Route::group(['middleware' => ['role:user']], function(){
//     	Route::post('place-order','Api\OrdersController@place_order');
// 		Route::post('telr-payment-submit-for-product', 'Api\PaymentGatewayController@telrGatewayForProductOrder');
    	
//     });

//     Route::group(['middleware' => ['role:partner|admin']], function(){

// 		Route::get('dashboard', 'Api\DashboardsController@index');



//     	Route::get('features', 'Api\FeaturesController@index');

//     	Route::get('cars', 'Api\CarsController@index');
// 	    Route::post('cars', 'Api\CarsController@store');
// 	    Route::post('cars/{id}', 'Api\CarsController@update');
// 	    Route::get('cars/{id}', 'Api\CarsController@show');
// 	    Route::delete('cars/{id}', 'Api\CarsController@destroy');


// 	    Route::get('trips', 'Api\TripsController@index');
// 	    Route::post('trips', 'Api\TripsController@store');
// 	    Route::get('trips/{id}', 'Api\TripsController@show');
// 	    Route::delete('trips/{id}', 'Api\TripsController@destroy');
// 		Route::get('trip-customers/{id}', 'Api\TripsController@tripCustomers');
		
	
// 		Route::get('trip-cancel/{id}', 'Api\TripsController@tripCancel');
// 		Route::get('trip-complete/{id}', 'Api\TripsController@tripComplete');

// 		Route::post('check-in', 'Api\TripBookingsController@checkIn');
// 		Route::post('check-out', 'Api\TripBookingsController@checkOut');
// 		Route::get('trip-booking-complete/{id}', 'Api\TripBookingsController@tripBookingComplete');

	
// 	});	
  
//     Route::group(['middleware' => ['role:admin|user|partner']], function(){
//     	Route::post('change-password', 'Api\UsersController@changePassword');
// 	    Route::get('current-user-detail', 'Api\UsersController@currentUserDetail');
// 	    Route::post('update-user-detail', 'Api\UsersController@updateUserDetail');

// 	    Route::get('complains', 'Api\ComplainsController@index');
// 		Route::post('complains', 'Api\ComplainsController@store');
// 		Route::get('complains/{id}', 'Api\ComplainsController@show');
// 	    Route::delete('complains/{id}', 'Api\ComplainsController@destroy');


// 	    Route::get('reviews', 'Api\ReviewsController@index');
// 		Route::post('reviews', 'Api\ReviewsController@store');
// 		Route::get('reviews/{id}', 'Api\ReviewsController@show');
// 	    Route::delete('reviews/{id}', 'Api\ReviewsController@destroy');

// 	    Route::get('view-cart','Api\CartsController@index');
// 		Route::post('add-to-cart','Api\CartsController@store');
// 		Route::post('update-quantity','Api\CartsController@update_quantity_cart');
// 		Route::post('delete-cart','Api\CartsController@destroy');
		
// 		Route::post('promo-code-validation', 'Api\PromoCodesController@promo_code_validation');


// 		Route::get('address', 'Api\AddressController@index');
// 		Route::post('address', 'Api\AddressController@store');
// 		Route::get('address/{id}', 'Api\AddressController@show');
// 		Route::delete('address/{id}', 'Api\AddressController@destroy');
		
		
//     	Route::get('passengers/{trip_id}', 'Api\PassengersController@index');

    
//     	Route::get('trip-bookings', 'Api\TripBookingsController@index');
//     	Route::get('user-wise-trip-bookings', 'Api\TripBookingsController@indexUserWise');
//     	Route::get('user-wise-ship-bookings', 'Api\TripBookingsController@indexUserWiseShip');
//     	Route::get('trip-bookings/{id}', 'Api\TripBookingsController@show');
//     	Route::get('ship-bookings/{id}', 'Api\TripBookingsController@showShip');
//     	Route::delete('trip-bookings/{id}', 'Api\TripBookingsController@destroy');
//     });

//     Route::group(['middleware' => ['role:admin|user']], function(){
//     	Route::get('order-details/{order_id}','Api\OrdersController@order_detail');
//     	Route::get('get-order-history','Api\OrdersController@history');
//     });
   
// });