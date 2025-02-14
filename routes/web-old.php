<?php

use App\Http\Controllers\Admin\AdminLiveSupportController;
use App\Http\Controllers\Admin\AdminShipmentController;
use App\Http\Controllers\Admin\AdminTruckController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LiveSupportController;
use App\Http\Controllers\MyShipmentController;
use App\Http\Controllers\NewTrackingRequestController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PostAShipmentController;
use App\Http\Controllers\PrivateNetworkController;
use App\Http\Controllers\SearchLoadsController;
use App\Http\Controllers\SearchTrucksController;
use App\Http\Controllers\ToolsController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();
Auth::routes(['verify' => true]);

// Route::get('logout', '\App\Http\Controllers\Auth\loginController@logout')->name('logout');
Route::get('/send-otp/{user_id}/{pass}', [LoginController::class, 'sendOtp'])->name('send_otp');
Route::get('/resend-otp/{user_id}/{pass}', [LoginController::class, 'resendOtp'])->name('resend_otp');
Route::post('/otp-verify', [LoginController::class, 'otpVerify'])->name('otp_verify');

//Signup start
Route::get('/signup-one/{id}', [RegisterController::class, 'signUpForm1'])->name('signup-step1');
Route::get('/signup-two', [RegisterController::class, 'signUpForm2'])->name('signup_step2');
Route::get('/signup-three', [RegisterController::class, 'signUpForm3'])->name('signup_step3');
Route::get('/signup-four', [RegisterController::class, 'signUpForm4'])->name('signup_step4');
Route::post('/lc-number', [RegisterController::class, 'lcNumber'])->name('lc_number');
// Route::get('/check-email', [RegisterController::class, 'emailVerify'])->name('email_verify');
//Signup end

//Payment start
Route::get('/pricing', [RegisterController::class, 'pricing'])->name('pricing');
Route::post('/package/payment', [PaymentController::class, 'handlePaymentResponse'])->name('package.payment');
Route::post('webhook/endpoint', [WebhookController::class, 'handle']);
Route::get('/curl', [WebhookController::class, 'curl']);
//Payment end

/* Users: 0=>super-admin   , 1=>trucker,  2=>shipper, 3=>broker */

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'user-access:super-admin'])->group(function () {
    Route::get('/admin/dashboard', [HomeController::class, 'SuperAdminDashboard'])->name('super-admin.dashboard');
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('super-admin.users_list');
    Route::get('/admin/trucks', [AdminTruckController::class, 'trucksList'])->name('super-admin.trucks_list');
    Route::get('/admin/shipments', [AdminShipmentController::class, 'shipmentsList'])->name('super-admin.shipments_list');
    Route::get('/admin/feedbacks', [FeedbackController::class, 'feedbacksList'])->name('super-admin.feedbacks_list');

    //support
    Route::get('/admin/live-support', [AdminLiveSupportController::class, 'adminLiveSupport'])->name('super-admin.live_support');

    //profile
    Route::get('/admin/user-profile', [AdminUserController::class, 'user_profile'])->name('super-admin.user_profile');
    Route::get('/admin/tools', [ToolsController::class, 'tools'])->name('super-admin.tools');
    Route::get('/admin/help-center', [ToolsController::class, 'helpCenter'])->name('super-admin.help-center');
    Route::get('/admin/cross-border-services', [ToolsController::class, 'helpCenterDetail'])->name('super-admin.help-center-detail');
});

Route::middleware(['verified'])->group(function () {

    Route::middleware(['auth', 'user-access:trucker'])->group(function () {
        Route::get('/trucker/dashboard', [HomeController::class, 'truckerDashboard'])->name('trucker.dashboard');
        Route::get('/trucker/live-support/{id}', [LiveSupportController::class, 'live_support'])->name('trucker.live_support');
        Route::get('/trucker/tools', [ToolsController::class, 'tools'])->name('trucker.tools');
        Route::get('/trucker/help-center', [ToolsController::class, 'helpCenter'])->name('trucker.help-center');
        Route::get('/trucker/cross-border-services', [ToolsController::class, 'helpCenterDetail'])->name('trucker.help-center-detail');

        // Route::get('/trucker/my-shipments', [MyShipmentController::class, 'my_shipments'])->name('trucker.my_shipments');
        Route::get('/trucker/user-profile', [UserProfileController::class, 'user_profile'])->name('trucker.user_profile');
        Route::get('/trucker/feedback-form', [HomeController::class, 'feedback'])->name('trucker.feedback_foam');
        Route::post('/trucker/feedback', [HomeController::class, 'feedbackSubmit'])->name('trucker.feedback_submit');
    });

    /*------------------------------------------
    --------------------------------------------
    All Admin Routes List
    --------------------------------------------
    --------------------------------------------*/

    Route::middleware(['auth', 'user-access:shipper'])->group(function () {
        Route::get('/shipper/dashboard', [HomeController::class, 'shipperDashboard'])->name('shipper.dashboard');
        Route::get('/shipper/search-trucks', [SearchTrucksController::class, 'search_trucks'])->name('shipper.search_trucks');
        Route::get('/shipper/search-loads', [SearchLoadsController::class, 'search_loads'])->name('shipper.search_loads');

        //tools
        Route::get('/shipper/tools', [ToolsController::class, 'tools'])->name('shipper.tools');
        Route::get('/shipper/help-center', [ToolsController::class, 'helpCenter'])->name('shipper.help-center');
        Route::get('/shipper/cross-border-services', [ToolsController::class, 'helpCenterDetail'])->name('shipper.help-center-detail');

        //Shipments
        Route::get('/shipper/my-shipments', [MyShipmentController::class, 'my_shipments'])->name('shipper.my_shipments');
        Route::get('/shipper/post-a-shipment', [PostAShipmentController::class, 'post_a_shipment'])->name('shipper.post_a_shipment');
        Route::post('/shipper/store-a-shipment', [PostAShipmentController::class, 'store_a_shipment'])->name('shipper.store_a_shipment');
        Route::get('/shipper/edit-a-shipment/{id}', [PostAShipmentController::class, 'edit_a_shipment'])->name('shipper.edit_a_shipment');
        Route::post('/shipper/update-a-shipment/{id}', [PostAShipmentController::class, 'update_a_shipment'])->name('shipper.update_a_shipment');
        Route::get('/shipper/my-shipments-open', [MyShipmentController::class, 'my_shipments'])->name('shipper.my_shipments');
        Route::get('/shipper/my-shipments-active', [MyShipmentController::class, 'my_shipments_active'])->name('shipper.my_shipments_active');
        Route::get('/shipper/my-shipments-history', [MyShipmentController::class, 'my_shipments_history'])->name('shipper.my_shipments_history');
        Route::get('/shipper/my-shipments-overview/{id}', [MyShipmentController::class, 'my_shipments_overview'])->name('shipper.my_shipments_overview');
        Route::get('/shipper/my-shipments-bid-activity/{id}', [MyShipmentController::class, 'my_shipments_bid_activity'])->name('shipper.my_shipments_bid_activity');
        Route::get('/shipper/my-shipments-requests-activity/{id}', [MyShipmentController::class, 'my_shipments_requests_activity'])->name('shipper.my_shipments_requests_activity');
        Route::get('/shipper/my-shipments-tracking/{id}', [MyShipmentController::class, 'my_shipments_tracking'])->name('shipper.my_shipments_tracking');
        Route::post('/shipper/my-shipment-update-tracking/{id}', [MyShipmentController::class, 'my_shipment_update_tracking'])->name('shipper.my_shipment_update_tracking');
        Route::get('/shipper/status-accept-decline/{id}', [MyShipmentController::class, 'status_accept_decline'])->name('shipper.status_accept_decline');

        //live Support
        Route::get('/shipper/live-support/{id}', [LiveSupportController::class, 'live_support'])->name('shipper.live_support');

        //tracking
        Route::get('/shipper/trackings', [NewTrackingRequestController::class, 'trackings'])->name('shipper.trackings');
        Route::get('/shipper/tracking-details/{id}', [NewTrackingRequestController::class, 'tracking_details'])->name('shipper.tracking_details');
        Route::get('/shipper/new-tracking-request', [NewTrackingRequestController::class, 'new_tracking_request'])->name('shipper.new_tracking_request');
        Route::post('/shipper/new-tracking-store', [NewTrackingRequestController::class, 'new_tracking_store'])->name('shipper.new_tracking_store');
        Route::get('/shipper/edit-tracking-request/{id}', [NewTrackingRequestController::class, 'edit_tracking_request'])->name('shipper.edit_tracking_request');
        Route::get('/shipper/delete-tracking-request/{id}', [NewTrackingRequestController::class, 'delete_tracking_request'])->name('shipper.delete_tracking_request');
        Route::post('/shipper/new-tracking-update/{id}', [NewTrackingRequestController::class, 'new_tracking_update'])->name('shipper.new_tracking_update');
        Route::get('/shipper/new-tracking-request', [NewTrackingRequestController::class, 'new_tracking_request'])->name('shipper.new_tracking_request');

        // userprorfile

        Route::get('/shipper/user-profile', [UserProfileController::class, 'user_profile'])->name('shipper.user_profile');
        Route::get('/shipper/company-profile', [UserProfileController::class, 'user_company_profile'])->name('shipper.user_company_profile');

        //Feedback
        Route::get('/shipper/feedback-form', [HomeController::class, 'feedback'])->name('shipper.feedback_foam');
        Route::post('/shipper/feedback', [HomeController::class, 'feedbackSubmit'])->name('shipper.feedback_submit');

        //Private Network Start
        Route::get('/shipper/private-network', [PrivateNetworkController::class, 'private_network'])->name('shipper.private_network');
        Route::get('/shipper/private-network-detail/{id}', [PrivateNetworkController::class, 'private_network_deatil'])->name('shipper.private_network_deatil');
        Route::get('/shipper/create-contact', [PrivateNetworkController::class, 'create_contact'])->name('shipper.create_contact');
        Route::post('/shipper/create-contact-store', [PrivateNetworkController::class, 'create_contact_store'])->name('shipper.create_contact_store');
        Route::post('/shipper/contact-assign-group', [PrivateNetworkController::class, 'contact_assign_group'])->name('shipper.contact_assign_group');
        Route::get('/shipper/groups', [PrivateNetworkController::class, 'groups'])->name('shipper.groups');
        Route::get('/shipper/groups-detail/{id}', [PrivateNetworkController::class, 'groups_detail'])->name('shipper.groups_detail');
        Route::post('/shipper/groups-store', [PrivateNetworkController::class, 'groups_store'])->name('shipper.groups_store');
        Route::post('/shipper/groups-update/{id}', [PrivateNetworkController::class, 'groups_update'])->name('shipper.groups_update');
        Route::get('/shipper/groups-delete/{id}', [PrivateNetworkController::class, 'groups_delete'])->name('shipper.groups_delete');
        Route::get('/shipper/group-remove-contact/{group_id}/{contact_id}', [PrivateNetworkController::class, 'group_remove_contact'])->name('shipper.group_remove_contact');
        Route::get('/shipper/contact-remove-groups/{contact_id}', [PrivateNetworkController::class, 'contact_remove_groups'])->name('shipper.contact_remove_groups');
        //Private Network End

        // Invoice
        Route::get('/shipper/invoice/index', [InvoiceController::class, 'index'])->name('shipper.invoice.index');
        Route::get('/shipper/invoice/new', [InvoiceController::class, 'create'])->name('shipper.invoice.create');
        Route::post('/shipper/invoice/store', [InvoiceController::class, 'store'])->name('shipper.invoice.store');
        Route::get('/shipper/invoice/view/{id}', [InvoiceController::class, 'show'])->name('shipper.invoice.show');
        Route::get('/shipper/invoice/destroy/{id}', [InvoiceController::class, 'destroy'])->name('shipper.invoice.destroy');
        //  Route::get('/shipper/invoice/index', [InvoiceController::class, 'index'])->name('shipper.invoice.index');

    });

    /*------------------------------------------
    --------------------------------------------
    All Admin Routes List
    --------------------------------------------
    --------------------------------------------*/
    Route::middleware(['auth', 'user-access:broker'])->group(function () {

        Route::get('/broker/dashboard', [HomeController::class, 'brokerDashboard'])->name('broker.dashboard');
        Route::get('/broker/search-trucks', [SearchTrucksController::class, 'search_trucks'])->name('broker.search_trucks');
        Route::get('/broker/search-loads', [SearchLoadsController::class, 'search_loads'])->name('broker.search_loads');

        // Tracking
        Route::get('/broker/trackings', [NewTrackingRequestController::class, 'trackings'])->name('broker.trackings');
        Route::get('/broker/tracking-details/{id}', [NewTrackingRequestController::class, 'tracking_details'])->name('broker.tracking_details');
        Route::get('/broker/new-tracking-request', [NewTrackingRequestController::class, 'new_tracking_request'])->name('broker.new_tracking_request');
        Route::post('/broker/new-tracking-store', [NewTrackingRequestController::class, 'new_tracking_store'])->name('broker.new_tracking_store');
        Route::get('/broker/edit-tracking-request/{id}', [NewTrackingRequestController::class, 'edit_tracking_request'])->name('broker.edit_tracking_request');
        Route::get('/broker/delete-tracking-request/{id}', [NewTrackingRequestController::class, 'delete_tracking_request'])->name('broker.delete_tracking_request');
        Route::post('/broker/new-tracking-update/{id}', [NewTrackingRequestController::class, 'new_tracking_update'])->name('broker.new_tracking_update');
        Route::get('/broker/new-tracking-request', [NewTrackingRequestController::class, 'new_tracking_request'])->name('broker.new_tracking_request');

        // Invoice

        // Route::resource('/shipper/invoice', InvoiceController::class);

        //Shipments
        Route::get('/broker/my-shipments', [MyShipmentController::class, 'my_shipments'])->name('broker.my_shipments');
        Route::get('/broker/post-a-shipment', [PostAShipmentController::class, 'post_a_shipment'])->name('broker.post_a_shipment');
        Route::post('/broker/store-a-shipment', [PostAShipmentController::class, 'store_a_shipment'])->name('broker.store_a_shipment');
        Route::get('/broker/edit-a-shipment/{id}', [PostAShipmentController::class, 'edit_a_shipment'])->name('broker.edit_a_shipment');
        Route::post('/broker/update-a-shipment/{id}', [PostAShipmentController::class, 'update_a_shipment'])->name('broker.update_a_shipment');
        Route::get('/broker/my-shipments-open', [MyShipmentController::class, 'my_shipments'])->name('broker.my_shipments');
        Route::get('/broker/my-shipments-active', [MyShipmentController::class, 'my_shipments_active'])->name('broker.my_shipments_active');
        Route::get('/broker/my-shipments-history', [MyShipmentController::class, 'my_shipments_history'])->name('broker.my_shipments_history');
        Route::get('/broker/my-shipments-overview/{id}', [MyShipmentController::class, 'my_shipments_overview'])->name('broker.my_shipments_overview');
        Route::get('/broker/my-shipments-bid-activity/{id}', [MyShipmentController::class, 'my_shipments_bid_activity'])->name('broker.my_shipments_bid_activity');
        Route::get('/broker/my-shipments-requests-activity/{id}', [MyShipmentController::class, 'my_shipments_requests_activity'])->name('broker.my_shipments_requests_activity');
        Route::get('/broker/my-shipments-tracking/{id}', [MyShipmentController::class, 'my_shipments_tracking'])->name('broker.my_shipments_tracking');
        Route::post('/broker/my-shipment-update-tracking/{id}', [MyShipmentController::class, 'my_shipment_update_tracking'])->name('broker.my_shipment_update_tracking');
        Route::get('/broker/status-accept-decline/{id}', [MyShipmentController::class, 'status_accept_decline'])->name('broker.status_accept_decline');

        //feedback
        Route::get('/broker/feedback-form', [HomeController::class, 'feedback'])->name('broker.feedback_foam');
        Route::post('/broker/feedback', [HomeController::class, 'feedbackSubmit'])->name('broker.feedback_submit');

        //Private Network Start

        Route::get('/broker/private-network', [PrivateNetworkController::class, 'private_network'])->name('broker.private_network');
        Route::get('/broker/private-network-detail/{id}', [PrivateNetworkController::class, 'private_network_deatil'])->name('broker.private_network_deatil');
        Route::get('/broker/create-contact', [PrivateNetworkController::class, 'create_contact'])->name('broker.create_contact');
        Route::post('/broker/create-contact-store', [PrivateNetworkController::class, 'create_contact_store'])->name('broker.create_contact_store');
        Route::post('/broker/contact-assign-group', [PrivateNetworkController::class, 'contact_assign_group'])->name('broker.contact_assign_group');
        Route::get('/broker/groups', [PrivateNetworkController::class, 'groups'])->name('broker.groups');
        Route::get('/broker/groups-detail/{id}', [PrivateNetworkController::class, 'groups_detail'])->name('broker.groups_detail');
        Route::post('/broker/groups-store', [PrivateNetworkController::class, 'groups_store'])->name('broker.groups_store');
        Route::post('/broker/groups-update/{id}', [PrivateNetworkController::class, 'groups_update'])->name('broker.groups_update');
        Route::get('/broker/groups-delete/{id}', [PrivateNetworkController::class, 'groups_delete'])->name('broker.groups_delete');
        Route::get('/broker/group-remove-contact/{group_id}/{contact_id}', [PrivateNetworkController::class, 'group_remove_contact'])->name('broker.group_remove_contact');
        Route::get('/broker/contact-remove-groups/{contact_id}', [PrivateNetworkController::class, 'contact_remove_groups'])->name('broker.contact_remove_groups');

        //Private Network End

        // live
        Route::get('/broker/live-support/{id}', [LiveSupportController::class, 'live_support'])->name('broker.live_support');

        //tools
        Route::get('/broker/tools', [ToolsController::class, 'tools'])->name('broker.tools');
        Route::get('/broker/help-center', [ToolsController::class, 'helpCenter'])->name('broker.help-center');
        Route::get('/broker/cross-border-services', [ToolsController::class, 'helpCenterDetail'])->name('broker.help-center-detail');

        //broker Profile
        Route::get('/broker/user-profile', [UserProfileController::class, 'user_profile'])->name('broker.user_profile');
        Route::get('/broker/company-profile', [UserProfileController::class, 'user_company_profile'])->name('broker.user_company_profile');

        // Invoice
        Route::get('/broker/invoice/index', [InvoiceController::class, 'index'])->name('broker.invoice.index');
        Route::get('/broker/invoice/new', [InvoiceController::class, 'create'])->name('broker.invoice.create');
        Route::post('/broker/invoice/store', [InvoiceController::class, 'store'])->name('broker.invoice.store');
        Route::get('/broker/invoice/view/{id}', [InvoiceController::class, 'show'])->name('broker.invoice.show');
        Route::get('/broker/invoice/destroy/{id}', [InvoiceController::class, 'destroy'])->name('broker.invoice.destroy');

    });

    //global chat system
    Route::post('/send-message/{id}', [ChatController::class, 'sendMessage'])->name('send_message');

});
