<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/about', 'HomeController@about')->name('about');
Route::get('/tracking', 'HomeController@tracking')->name('tracking');
Route::get('/contact', 'HomeController@contact')->name('contact');
Route::get('/blog', 'HomeController@blog')->name('blog');

/*
|--------------------------------------------------------------------------
| Admin Route
|--------------------------------------------------------------------------
*/
Route::get('admin/login', 'Admin\AuthController@index');
Route::post('admin/login', 'Admin\AuthController@login')->name('admin.login');
Route::post('admin/register', 'Admin\AuthController@store')->name('admin.register');
Route::post('admin/logout', 'Admin\AuthController@logout')->name('admin.logout');

Route::group(['middleware' => 'auth:admin', 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::resource('/basic-information', 'BasicInformationController');

    Route::get('/zone', 'AreaController@zone')->name('zone');
    Route::post('/zone', 'AreaController@zoneStore')->name('zone.store');
    Route::get('/get-zone', 'AreaController@zoneGet')->name('AdminZoneGet');
    Route::post('/zone-update', 'AreaController@zoneUpdate')->name('zone.update');
    Route::post('/zone-delete', 'AreaController@zoneDelete')->name('zone.delete');
    Route::get('/get-zone-single', 'AreaController@zoneGetSingle')->name('zone.single');

    Route::get('/hub', 'AreaController@index')->name('hub');
    Route::post('/hub', 'AreaController@hubStore')->name('hub.store');
    Route::get('/get-hub', 'AreaController@hubGet')->name('AdminHubGet');
    Route::post('/hub-update', 'AreaController@hubUpdate')->name('hub.update');
    Route::post('/hub-delete', 'AreaController@hubDelete')->name('hub.delete');
    Route::get('/get-hub-single', 'AreaController@hubGetSingle')->name('hub.single');
    Route::post('/get-hub-select', 'AreaController@SelectHub')->name('SelectHub');

    Route::get('/area', 'AreaController@area')->name('area');
    Route::post('/area', 'AreaController@areaStore')->name('area.store');
    Route::get('/get-area', 'AreaController@areaGet')->name('AdminAreaGet');
    Route::post('/area-update', 'AreaController@areaUpdate')->name('area.update');
    Route::post('/area-delete', 'AreaController@areaDelete')->name('area.delete');
    Route::get('/get-area-single', 'AreaController@areaGetSingle')->name('area.single');

    Route::get('/merchant-list', 'MerchantController@index')->name('merchant.list');
    Route::post('/merchant-list', 'MerchantController@store')->name('merchant.store');

    Route::get('/shipping-price-set', 'ShippingPriceController@shippingPrice')->name('shippingPrice.set');
    Route::post('/shipping-price-set', 'ShippingpriceController@shippingPriceAdd')->name('shippingPrice.add');
    Route::get('/admin-international-delete', 'ShippingpriceController@AdminInternationalDelete')->name('AdminInternationalDelete');

    Route::resource('/driver-list', 'DriverController');

    Route::get('/shipping-list', 'ShipmentController@index')->name('AdminShipment.index');
});

/*
|--------------------------------------------------------------------------
| User Route
|--------------------------------------------------------------------------
*/
Route::get('/login', 'AuthController@index')->name('login');
Route::post('/login', 'AuthController@login')->name('login.store');
Route::get('/register', 'AuthController@register')->name('register');
Route::post('/register', 'AuthController@registerStore')->name('register.store');
Route::post('/logout', 'AuthController@logout')->name('logout');

Route::group(['middleware' => 'auth:user', 'namespace' => 'User'], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('user.dashboard');

    Route::get('/profile', 'DashboardController@profile')->name('profile');
    Route::get('/profile-edit', 'DashboardController@ProfileEdit')->name('ProfileEdit');
    Route::post('/profile-update', 'DashboardController@ProfileUpdate')->name('ProfileUpdate');


    Route::get('/account', 'DashboardController@account')->name('account');
    Route::post('/change-email', 'DashboardController@ChangeMail')->name('ChangeMail');
    Route::post('/change-password', 'DashboardController@ChangePassword')->name('ChangePassword');

    Route::get('/prepare-shipment', 'ShipmentController@index')->name('PrepareShipment');
    Route::post('/check-rate-merchant', 'ShipmentController@rateCheck')->name('merchant.rate.check');
    Route::post('prepare-shipment-submit', 'ShipmentController@PrepareShipmentSubmit')->name('PrepareShipmentSubmit');

    Route::get('prepare-shipment-details/{id}', 'ShipmentController@PrepareShipmentEdit')->name('PrepareShipmentEdit');
});
