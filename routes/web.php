<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('home');
Route::get('/about', 'HomeController@about')->name('about');
Route::get('/tracking', 'HomeController@tracking')->name('tracking');
Route::get('/track-shipment', 'HomeController@track_order')->name('track-shipment');
Route::get('/contact', 'HomeController@contact')->name('contact');
Route::post('/contact', 'HomeController@save_contact')->name('save-contact');
Route::get('/blog', 'HomeController@blog')->name('blog');
Route::get('/blog-info/{blog}', 'HomeController@show_blog')->name('show-blog');
Route::get('/blog-cetegory/{blog_category}', 'HomeController@category_post')->name('category-post');
Route::get('/blog-search', 'HomeController@seach_blog')->name('search-post');
// ajax call
Route::get('/check-rate', 'HomeController@rateCheck')->name('rate.check');

Route::get('/pricing', 'HomeController@pricing')->name('pricing');


/*
|--------------------------------------------------------------------------
| Admin Route
|--------------------------------------------------------------------------
*/
Route::get('admin/login', 'Admin\AuthController@index');
Route::post('admin/login', 'Admin\AuthController@login')->name('admin.login');
Route::post('admin/register', 'Admin\AuthController@store')->name('admin.register');
Route::post('admin/logout', 'Admin\AuthController@logout')->name('admin.logout');

Route::group(['prefix' => 'admin','middleware' => 'auth:admin', 'namespace' => 'Admin'], function () {
    Route::get('/', 'DashboardController@index')->name('admin-dashboard');
    Route::get('/basic-information', 'BasicInformationController@index')->name('basic-information');
    Route::post('/basic-information', 'BasicInformationController@update')->name('basic-information.update');

    Route::get('/admin-change-hub/{hub}', 'DashboardController@admin_changes_hub')->name('admin-change-hub');
    Route::get('/get-admin-hub-ids/{admin}', 'DashboardController@get_admin_hub_ids')->name('get-admin-hub-ids');
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
    Route::get('/delete-hub/{hub}', 'AreaController@delete_hub')->name('deleet-hub');

    Route::get('/area', 'AreaController@area')->name('area');
    Route::post('/area', 'AreaController@areaStore')->name('area.store');
    Route::get('/get-area', 'AreaController@areaGet')->name('AdminAreaGet');
    Route::post('/area-update', 'AreaController@areaUpdate')->name('area.update');
    Route::get('/area-delete/{area}', 'AreaController@areaDelete')->name('area.delete');
    Route::get('/get-area-single', 'AreaController@areaGetSingle')->name('area.single');

    Route::get('/merchant-list', 'MerchantController@index')->name('merchant.list');
    Route::get('/merchant-details/{user}', 'MerchantController@show')->name('merchant.details');
    Route::post('/merchant-list', 'MerchantController@store')->name('merchant.store');

    Route::get('/shipping-price-set', 'ShippingPriceController@shippingPrice')->name('shippingPrice.set');
    Route::post('/shipping-price-set', 'ShippingPriceController@shippingPriceAdd')->name('shippingPrice.add');
    Route::post('/shipping-price-set-edit', 'ShippingPriceController@shippingPriceEdit')->name('shippingPrice.edit');
    Route::get('/delete-shipping-price/{shipping_price}', 'ShippingPriceController@destroy')->name('delete-shipping-price');
    Route::get('/show-shipping-price/{shipping_price}', 'ShippingPriceController@show')->name('show-shipping-price');

    Route::resource('/driver-list', 'DriverController');
    Route::get('/driver-shipments/{id}', 'DriverController@assigned_shipments')->name('admin-driverShipments');

    Route::get('/shipping-list', 'ShipmentController@index')->name('AdminShipment.index');
    Route::get('/shipping-list/more/{id}/{status}/{shipping_status}', 'ShipmentController@show')->name('AdminShipmentMore');
    Route::post('/shipping-list/more/{id}/{status}/{shipping_status}', 'ShipmentController@save_driver_shipment')->name('saveDriverShipments');
    Route::get('/shipping-list/received', 'ShipmentController@shipment_received')->name('AdminShipmentReceived');
    Route::get('/shipping-list/cancelled', 'ShipmentController@shipment_cancelled')->name('AdminShipmentCancelled');

    Route::post('/add-parcelBy-admin', 'ShipmentController@add_parcel')->name('add-parcelBy-admin');


    Route::get('/assign-to-hub/{user_id}/{status}/{shipping_status}', 'ShipmentController@assignToHub')->name('AdminShipmentReceive');
    Route::get('/receiving-parcels/{user_id}/{status?}/{shipping_status?}', 'ShipmentController@receving_parcels')->name('receiving-parcels');
    Route::get('/get-hub-csv-files/{user_id}/{status}/{shipping_status}', 'ShipmentController@get_hub_csv')->name('get-hub-csv');

    Route::get('/move-to-hub', 'ShipmentController@MoveToHub')->name('ShipmentToHub');
    Route::get('/move2hub-withPhone', 'ShipmentController@MoveToHubWithPhone')->name('move2hub-withPhone');
    Route::get('/move2hub-withInvoice', 'ShipmentController@MoveToHubWithInvoice')->name('move2hub-withInvoice');

    Route::get('/user-hub-parcels/{hub}/{user}', 'ShipmentController@hub_parcels')->name('hub-parcels');
    Route::get('/user-hub-parcels-csv/{hub}/{user}', 'ShipmentController@hub_parcels_csv')->name('hub-parcels-csv');
    Route::get('/remove-hub-parcel/{hub_shipment}', 'ShipmentController@remove_hub_parcel')->name('remove-hub-parcel');
    Route::get('/change-hub-with-area/{id}', 'ShipmentController@change_bub')->name('change-hub-with-area');
    Route::get('/hub-sorting/{hub}', 'ShipmentController@hub_sorting')->name('hub-sorting');


    Route::get('/shipping-list/dispatch', 'ShipmentController@shipment_dispatch')->name('AdminShipmentDispatch');
    Route::get('/dispatch/view/{hub}', 'ShipmentController@dispatch_view')->name('dispatchView');
    Route::get('/status-dispatch/{hub}', 'ShipmentController@status_dispatch')->name('status-dispatch');
    Route::get('/status-on-transit/{hub}', 'ShipmentController@status_on_transit')->name('status-on-transit');
    Route::get('/dispatch-box-view/{hub_shipment_box}', 'ShipmentController@dispatch_box_view')->name('box-view');
    Route::get('/change-box-status/{hub_shipment_box}/{status}', 'ShipmentController@box_status_changes')->name('box-status-change');
    Route::get('/change-box-status-bulk-id/{hub_shipment_box}/{status}', 'ShipmentController@box_status_changes_bulk_id')->name('box-status-change-bulk-id');
    Route::get('/box-sorting/{hub}', 'ShipmentController@box_sorting')->name('box-sorting');

    Route::get('/hub-receivable', 'ShipmentController@hub_receivable')->name('hub-receivable');
    Route::get('/back2-dispatch/{hub_shipment_box}', 'ShipmentController@box_back2Dispatch')->name('box-sorting-back');

    Route::get('/sort-to-agent-dispatch/{hub_shipment_box}', 'ShipmentController@sort2agentDispatch')->name('sorting-to-agent');
    Route::get('/agent-dispatch', 'ShipmentController@agent_dispatch')->name('AdminAgentDispatch');

    //first login design , agent-dispatch with  bulk-id
    # Route::post('/agent-dispatch/', 'ShipmentController@assigDriverForDelivery')->name('assigDriverForDelivery');

    Route::get('/agent-dispatch-agentSide', 'ShipmentController@agent_dispatch_agentSide')->name('agent-dispatch-agentSide');
    Route::get('/agent-dispatch-driverSide', 'ShipmentController@agent_dispatch_driverSide')->name('agent-dispatch-driverSide');

    Route::get('/agentDispatch-to-driverAssign/{hub_shipment_box}/{shipment}', 'ShipmentController@agentDispatch2DriverAssign')->name('agent-dispatch-driverAssign');
    Route::get('/agentDispatch-to-driverAssign-withInvoice/{invce_id}', 'ShipmentController@agentDispatch2DriverAssignWithInvoice');
    Route::get('/driver-assign2agent-dispatch/{hub_shipment_box}/{shipment}', 'ShipmentController@driverAssign2Agent_dispatch')->name('driver-assign2agent-dispatch');

    Route::post('/agent-dispatch-assing-to-driver', 'ShipmentController@agent_dispatchAssigning')->name('agent-dispatch-assing2Driver');


    Route::get('/all-shipments', 'ShipmentController@all_shipments')->name('all-shipments');
    Route::get('/shipment-details/{shipment}', 'ShipmentController@shipment_detail')->name('shipment-details');
    Route::get('/shipment-print/{shipment}', 'ShipmentController@shipment_print')->name('shipment-print');
    Route::post('/reset-shipment', 'ShipmentController@reset_shipment')->name('reset-shipment');

    // ajax call, get zone wize area
    Route::get('/zone-to-area/{zone}', 'AreaController@zone_wize_area')->name('zone-to-area');

    // reconcile
    Route::get('/reconcile', 'ShipmentController@reconcile')->name('AdminReconcile');
    Route::get('/load-shipment-reconcilable', 'ShipmentController@load_shipment_reconcilable');
    Route::get('/load-reconcile-shipments', 'ShipmentController@load_reconcil_shipments');
    Route::get('/create-reconcile/{shipment}', 'ShipmentController@create_reconcile');
    Route::get('/remove-reconcile/{shipment}', 'ShipmentController@remove_reconcile');
    Route::get('/return-reconcile2receive', 'ShipmentController@return_shipments2receive');


    // delivery
    Route::get('/delivery', 'ShipmentController@delivery')->name('AdminDelivery');
    Route::get('/get-shipment/{field}/{keyword}', 'ShipmentController@shipment_search')->name('delivery-search');
    Route::get('/get-driver-shipment/{driver}', 'ShipmentController@driver_shipment_search')->name('delivery-search-driver');
    Route::get('/get-shipment-with-invoices/{keyword}', 'ShipmentController@shipment_search_invoices')->name('delivery-search-invoices');

    Route::get('/get-shipment-withHub/{hub}', 'ShipmentController@shipment_search_withHub')->name('delivery-search-hub');
    Route::get('/get-shipment-withStatus/{status}', 'ShipmentController@shipment_search_withStatus')->name('delivery-search-hub-status');
    Route::get('/get-shipment-withdate/{date1}/{date2}', 'ShipmentController@shipment_search_withDates')->name('delivery-search-dates');

    Route::get('/shipment-audit/{shipment}', 'ShipmentController@shipment_audit')->name('shipment-audit');
    //ajax call to show driver note during delivery
    Route::get('/driver-delivery-note/{shipment}', 'DriverController@delivery_note');
    Route::get('/export-selected/{shipment_ids}', 'ShipmentController@export_shipments')->name('export-selected');
    Route::get('/delivery-payment-form/{shipment_ids}', 'ShipmentController@deliveryPaymentsForMerchant')->name('delivery-payment-form');
    Route::post('/save-delivery-payment', 'ShipmentController@save_delivery_payment')->name('delivery-payment-save');
    Route::get('/return-selected-to-merchant/{shipment_ids}','ShipmentController@return_shipments');


    // download
    Route::get('/shipment-download', 'ShipmentController@download')->name('AdminDownload');
    Route::get('/get-shipment-withBulkID/{bulk_id}', 'ShipmentController@shipment_search_withBulkID')->name('delivery-search-bulkid');
    Route::get('/get-shipment-files/{type}/{bulk_id}','ShipmentController@download_file')->name('get-shipment-files');

    Route::get('/admin-upload-csv', 'CSVController@create')->name('AdminUploadCSV');
    Route::post('/admin-upload-csv', 'CSVController@get_csv_data')->name('AdminShowCSV');

    Route::get('/csv-temporary', 'CSVController@show')->name('admin-csv-temporary');
    Route::post('/csv-temporary', 'CSVController@store')->name('admin-csv-save');


    Route::get('/shipping-list/cencelled-items/{id}', 'ShipmentController@cencelled_shippings')->name('CencelledShipping');
    Route::get('/back-to-shipment/{id}', 'ShipmentController@back2shipment')->name('back2shipment');

    Route::get('/delete-shipment/{id}', 'ShipmentController@destroy')->name('destroy-shipment');
    Route::get('/cencell-shipment/{id}', 'ShipmentController@cencell')->name('cencell-shipment');

    // third party shipments
    Route::get('/thirdparty-shipments/{hub}','ThirdpartyShipmentController@index')->name('thirdparty-shipments');
    Route::get('/thirdparty-hub-shipments/{hub}','ThirdpartyShipmentController@show')->name('thirdparty-hub-shipments');
    Route::get('/thirdparty-left/{hub}','ThirdpartyShipmentController@show_left_side')->name('thirdparty-left');
    Route::get('/thirdparty-right/{hub}','ThirdpartyShipmentController@show_right_side')->name('thirdparty-right');
    Route::get('/thirdparty-moveTo-right/{thirdparty_shipment}','ThirdpartyShipmentController@moveToright')->name('thirdparty2right');
    Route::get('/thirdparty-moveTo-left/{thirdparty_shipment}','ThirdpartyShipmentController@moveToleft')->name('thirdparty2left');
    Route::get('/thirdparty-sendToSort','ThirdpartyShipmentController@sendToSort')->name('thirdpartySendToSort');
    Route::get('/thirdparty-csv-pdf/{type}','ShipmentController@get_csv_pdf');
    Route::get('/thirdparty-rightWithInvoice/{invoice_id}','ThirdpartyShipmentController@show_right_withInvoice')->name('thirdparty-rightWithInvoice');

    // hold
    Route::get('/hold-shipments/{hold}','HoldShipmentController@index')->name('hold-shipments');
    Route::get('/move-to-hold_shipment/{shipment}/{hub}','HoldShipmentController@move_to_hold_shipment')->name('move-to-hold_shipment');
    Route::get('/hold-agentDispatch-to-driverAssign-withInvoice/{invce_id}', 'HoldShipmentController@move_to_hold_shipmentWithInvoice');
    Route::get('/hold-agentDispatch-to-driverAssign-rider/{driver}', 'HoldShipmentController@move_to_hold_shipmentRider');
    Route::get('/hold-shipment-rows/{type}','HoldShipmentController@hold_shipment_rows');
    Route::get('/driver-hub-shipment-rows/{type}','HoldShipmentController@driver_hub_shipments');
    Route::get('/move-back-to-hold_shipment/{shipment}/{type}','HoldShipmentController@move_back2hold_shipment');
    Route::get('/sendToSorting-hold_shipment','HoldShipmentController@sendToSorting');

    Route::get('/move-to-return_shipment/{shipment}/{hub}','HoldShipmentController@move_to_return_shipment');
    Route::get('/move-to-return_shipment-withInvoice/{inviceid}','HoldShipmentController@move_to_return_shipment_withInvoice');
    Route::get('/move-to-return_shipment-withRider/{driver}','HoldShipmentController@move_to_return_shipment_withRider');

    Route::get('/return-shipment-rows/{type}','HoldShipmentController@return_shipment_rows');
    Route::get('/return-shipments-parcels/{hub}','HoldShipmentController@return_shipments_parcels');
    Route::get('/move-back-to-return_shipment/{return_shipment}/{type}','HoldShipmentController@move_back2return_shipment');

    Route::get('/return-sorting/{hub}','HoldShipmentController@return_sorting')->name('return-sorting');
    Route::get('/return-dispatch','HoldShipmentController@return_dispatch')->name('return-dispatch');
    Route::get('/return-dispatch/view/{hub}','HoldShipmentController@dispatch_view')->name('return-dispatch-view');
    Route::get('/return-status-dispatch/{hub}', 'HoldShipmentController@status_dispatch')->name('return-status-dispatch');
    Route::get('/return-status-on-transit/{hub}', 'HoldShipmentController@status_on_transit')->name('return-status-on-transit');
    Route::get('/return-dispatch-box-view/{return_shipment_box}', 'HoldShipmentController@dispatch_box_view')->name('return-box-view');
    Route::get('/return-change-box-status/{return_shipment_box}/{status}', 'HoldShipmentController@box_status_changes')->name('return-box-status-change');
    Route::get('/return-change-box-status-bulk-id/{return_shipment_box}/{status}', 'HoldShipmentController@box_status_changes_bulk_id')->name('return-box-status-change-bulk-id');
    Route::get('/return-box-sorting/{hub}', 'HoldShipmentController@box_sorting')->name('return-box-sorting');

    Route::get('/receive-from-hub','HoldShipmentController@receive_from_hub')->name('receive-from-hub');
    Route::get('/return-agent-dispatch','HoldShipmentController@agent_dispatch')->name('return-agent-dispatch');
    Route::get('/return-agent-dispatch-agentSide', 'HoldShipmentController@agent_dispatch_agentSide')->name('return-agent-dispatch-agentSide');
    Route::get('/return-agent-dispatch-driverSide', 'HoldShipmentController@agent_dispatch_driverSide')->name('return-agent-dispatch-driverSide');
    Route::get('/return-agentDispatch-to-driverAssign/{return_shipment_box}/{shipment}', 'HoldShipmentController@agentDispatch2DriverAssign')->name('return-agent-dispatch-driverAssign');
    Route::get('/return-driver-assign2agent-dispatch/{return_shipment_box}/{shipment}', 'HoldShipmentController@driverAssign2Agent_dispatch')->name('return-driver-assign2agent-dispatch');
    Route::post('/return-agent-dispatch-assing-to-driver', 'HoldShipmentController@agent_dispatchAssigning')->name('return-agent-dispatch-assing2Driver');

    Route::get('/return-to-return-delivery/{type}/{hub_shipmentBox}', 'HoldShipmentController@return2return_delivery')->name('return-to-return-delivery');
    // return to merchant
    Route::get('/return-merchant-handover', 'HoldShipmentController@merchant_handover')->name('merchant-handover');
    Route::get('/view-merchant-handover/{user}', 'HoldShipmentController@merchant_handover_parcels')->name('merchant-handover-parcels');
    Route::get('/handover-to-merchant/{user}', 'HoldShipmentController@handover2merchant')->name('handover-to-merchant');


    Route::get('/admin-list', 'AdminController@index')->name('admin-list');
    Route::get('/admins', 'AdminController@admins')->name('admins');
    Route::get('/admin/create', 'AdminController@create')->name('create-admin');
    Route::post('/save-admin', 'AdminController@store')->name('save-admin');
    Route::post('/update-admin', 'AdminController@update')->name('update-admin');
    Route::get('/admin/delete/{admin}', 'AdminController@destroy')->name('destroy-admin');
    Route::get('/admin/show', 'AdminController@show')->name('show-admin');
    Route::get('/role-assign', 'AdminController@role_assign')->name('role-assign');
    Route::post('/role-assign', 'AdminController@save_role_assign')->name('save-role-assign');
    Route::get('/get-employee-roles/{admin}', 'AdminController@employee_roles')->name('get-roles');


    Route::get('/sliders', 'SliderController@index')->name('adminSlider');
    Route::get('/sliders-show', 'SliderController@sliders')->name('sliders');
    Route::post('/save-slider', 'SliderController@store')->name('save-slider');
    Route::post('/update-slider', 'SliderController@update')->name('update-slider');
    Route::get('/slider-show/{slider}', 'SliderController@show')->name('show-slider');


    Route::get('/about-us', 'AboutController@index')->name('adminAbout');
    Route::get('/client-reviews', 'ClientReviewController@index')->name('adminClientReview');
    Route::get('/review-posts', 'ClientReviewController@ajax_get')->name('review-posts');

    Route::post('/save-review', 'ClientReviewController@store')->name('save-review');
    Route::post('/update-review', 'ClientReviewController@update')->name('update-review');
    Route::get('/view-review/{client_review}', 'ClientReviewController@show')->name('view-review');
    Route::get('/delete-review/{client_review}', 'ClientReviewController@destroy')->name('delete-review');

    Route::post('/save-about-1', 'AboutController@store')->name('save-about-1');
    Route::post('/about-us', 'AboutController@save')->name('save-about-us');
    Route::get('/about-posts', 'AboutController@about_posts')->name('about-posts');
    Route::get('/about-show/{about}', 'AboutController@show')->name('about-show');
    Route::post('/update-about-post', 'AboutController@update')->name('update-about-post');
    Route::get('/delete-about-post/{about}', 'AboutController@destroy')->name('delete-about-post');


    Route::get('/messages', 'MessageController@index')->name('contact-messages');
    Route::get('/view-messages', 'MessageController@messages')->name('messages');
    Route::get('/message-show/{message}', 'MessageController@show')->name('view-message');
    Route::get('/delete-message/{message}', 'MessageController@destroy')->name('delete-message');

    Route::get('/blog/index', 'BlogController@index')->name('AdminBlog');
    Route::get('/blog-posts', 'BlogController@blogs')->name('blogs');
    Route::post('/update-blog', 'BlogController@update')->name('update-blog');
    Route::get('/show-blog/{blog}', 'BlogController@show')->name('show-blog-admin');
    Route::post('/save-blog', 'BlogController@store')->name('save-blog');
    Route::get('/blog/delete/{blog}', 'BlogController@destroy')->name('delete-blog');


    Route::get('/blog/category', 'Blog_categoryController@index')->name('blog-category');
    Route::get('/blog/categories', 'Blog_categoryController@categories')->name('blog-categories');
    Route::post('/blog/category/save', 'Blog_categoryController@store')->name('save-category');
    Route::get('/show-category/{blog_category}', 'Blog_categoryController@show')->name('show-category');
    Route::get('/blog/category/delete/{blog_category}', 'Blog_categoryController@destroy')->name('delete-category');
    Route::post('/blog/category/update', 'Blog_categoryController@update')->name('update-category');


    Route::get('set-mail-info', 'BasicInformationController@mailing_info')->name('mail-setup');
    Route::post('set-mail-info', 'BasicInformationController@save_mailing_info')->name('save-mail-setup');
});

/*
|--------------------------------------------------------------------------
| User Route
|--------------------------------------------------------------------------
*/
Route::get('/login', 'AuthController@index')->name('login');
Route::get('/verify', 'AuthController@verify')->name('verify-user');
Route::post('/verify', 'AuthController@verify_code')->name('verify-user-code');
Route::post('/verification.resend', 'AuthController@send_verification_code')->name('verification.resend');

Route::post('/login', 'AuthController@login')->name('login.store');
Route::get('/register', 'AuthController@register')->name('register');
Route::post('/register', 'AuthController@registerStore')->name('register.store');
Route::post('/logout', 'AuthController@logout')->name('logout');

Route::group(['middleware' => 'auth:user', 'namespace' => 'User'], function () {

    Route::get('/dashboard', 'DashboardController@index')->name('user.dashboard');
    Route::get('/shipment-info/{shipment}', 'ShipmentController@show')->name('single.shipment');
    Route::get('/shipment-pdf/{shipment}', 'ShipmentController@shipment_pdf')->name('pdf.shipment');

    Route::get('/profile', 'DashboardController@profile')->name('profile');
    Route::get('/profile-edit', 'DashboardController@ProfileEdit')->name('ProfileEdit');
    Route::post('/profile-update', 'DashboardController@ProfileUpdate')->name('ProfileUpdate');


    Route::get('/account', 'DashboardController@account')->name('account');
    Route::post('/change-email', 'DashboardController@ChangeMail')->name('ChangeMail');
    Route::post('/change-password', 'DashboardController@ChangePassword')->name('ChangePassword');

    Route::get('/prepare-shipment', 'ShipmentController@index')->name('PrepareShipment');
    Route::post('/check-rate-merchant', 'ShipmentController@rateCheck')->name('merchant.rate.check');
    Route::post('prepare-shipment-submit', 'ShipmentController@PrepareShipmentSubmit')->name('PrepareShipmentSubmit');
    Route::get('/edit-shipment/{shipment}', 'ShipmentController@edit')->name('editShipment');
    Route::post('/edit-shipment/{shipment}', 'ShipmentController@update')->name('updateShipment');

    Route::get('payments', 'ShipmentController@payments')->name('payments');
    Route::get('payments-load', 'ShipmentController@payments_loading')->name('payments-load');
    Route::get('/show-payment/{shipment}', 'ShipmentController@show_payment')->name('payments-show');

    Route::get('/csv-upload', 'CSVController@create')->name('csv-upload');
    Route::post('/csv-upload', 'CSVController@get_csv_data')->name('get-csv');
    Route::get('/csv-temporary', 'CSVController@show')->name('csv-temporary');
    Route::post('/csv-temporary', 'CSVController@store')->name('csv-save');

    Route::get('prepare-shipment-details/{id}', 'ShipmentController@PrepareShipmentEdit')->name('PrepareShipmentEdit');
});


Route::get('driver/login', 'Driver\AuthController@index');
Route::post('driver/login', 'Driver\AuthController@login')->name('driver.login');
Route::post('driver/register', 'Driver\AuthController@store')->name('driver.register');
Route::post('driver/logout', 'Driver\AuthController@logout')->name('driver.logout');

Route::group(['middleware' => 'auth:driver', 'namespace' => 'Driver', 'prefix' => 'driver'], function () {
    Route::get('/', 'DashboardController@index')->name('driver.dashboard');
    Route::get('/get-shipments/{type}', 'DashboardController@shipments')->name('get-driver-shipments');
    Route::get('/get-shipments-with-dates/{dates}/{type}', 'DashboardController@shipments_dates')->name('dateWize-driver-shipments');

    Route::get('/shipments', 'ShipmentController@index')->name('driverShipments.index');
    Route::get('/my-shipments/{type}', 'ShipmentController@my_shipments')->name('my-shipments');
    Route::get('/shipping-details/{id}/{status}', 'ShipmentController@show')->name('shipping-details');


    Route::get('/cencell-parcel/{id}', 'ShipmentController@cencel_parcel')->name('cancel-parcel');
    Route::get('/receive-shipment/{id}', 'ShipmentController@receive_parcel')->name('receive-parcel');
    Route::get('/receive-all-shipment/{user}', 'ShipmentController@receive_all_parcel')->name('receive-all-parcel');


    Route::get('/my-parcels/{type}', 'ShipmentController@my_parcels')->name('my-parcel');
    Route::get('/agent-dispatch', 'ShipmentController@agent_dispatch')->name('box-for-delivery');
    Route::get('/shipment-info/{shipment}', 'ShipmentController@shipment_info')->name('shipment-info');
    Route::post('/shipment-delivery', 'ShipmentController@delivery_report')->name('shipment-delivery');

    Route::get('/return-agent-dispatch', 'ShipmentController@return_agent_dispatch')->name('return-box-for-delivery');
    Route::post('/return-shipment-delivery', 'ShipmentController@return_delivery_report')->name('return-shipment-delivery');
    Route::post('/confirm-otp','ShipmentController@otp_confirmation')->name('confirm-opt');
});


Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
