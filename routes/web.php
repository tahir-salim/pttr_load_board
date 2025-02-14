<?php

use App\Http\Controllers\Admin\AdminAdvertisementController;
use App\Http\Controllers\Admin\SubAdminsController;
use App\Http\Controllers\Admin\AdminLiveSupportController;
use App\Http\Controllers\Admin\AdminPackageController;
use App\Http\Controllers\Admin\AdminPushNotificationController;
use App\Http\Controllers\Admin\AdminServiceCategoryItemController;
use App\Http\Controllers\Admin\AdminServicesController;
use App\Http\Controllers\Admin\AdminShipmentController;
use App\Http\Controllers\Admin\AdminTruckController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\ShopController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LiveSupportController;
use App\Http\Controllers\MyLoadsController;
use App\Http\Controllers\MyShipmentController;
use App\Http\Controllers\NewTrackingRequestController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PoliciesController;
use App\Http\Controllers\PostAShipmentController;
use App\Http\Controllers\PrivateNetworkController;
use App\Http\Controllers\PushNotificationController;
use App\Http\Controllers\SearchLoadsController;
use App\Http\Controllers\SearchTrucksController;
use App\Http\Controllers\ToolsController;
use App\Http\Controllers\TruckController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MyPlansController;


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

// Route::get('/log-out', [LoginController::class, 'logout']);

Route::get('logout', [LoginController::class, 'logout'])->name('logout');
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
Route::any('/webhook/notification', [WebhookController::class, 'handle']);

Route::get('tracking-request-link/{id}', [NewTrackingRequestController::class, 'tracking_request_link'])->name('tracking_request_link');



//Payment end

// Policies Start

Route::get('/terms-and-conditions', [PoliciesController::class, 'terms_and_conditions'])->name('terms_and_conditions')->middleware('auth');
Route::get('/privacy-policy', [PoliciesController::class, 'privacy_policy'])->name('privacy_policy')->middleware('auth');
Route::get('/product-delivery-schedule', [PoliciesController::class, 'product_delivery_schedule'])->name('product_delivery_schedule')->middleware('auth');
Route::get('/acceptable-use-policy', [PoliciesController::class, 'acceptable_use_policy'])->name('acceptable_use_policy')->middleware('auth');
// Policies End

/* Users: 0=>super-admin   , 1=>trucker,  2=>shipper, 3=>broker */

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'user-access:super-admin'])->group(function () {

    Route::get('/admin/map', [NewTrackingRequestController::class, 'map'])->name('super-admin.map');
    Route::post('/admin/send-notification', [AdminPushNotificationController::class, 'sendNotification'])->name('super-admin.send_notification');
    Route::get('/admin/all-notifications', [AdminPushNotificationController::class, 'all_notifications'])->name('super-admin.all_notifications');
    Route::get('/admin/get_all_notifications', [AdminPushNotificationController::class, 'get_all_notifications'])->name('super-admin.get_all_notifications');
    Route::get('/admin/notification-setting', [AdminPushNotificationController::class, 'notificationSetting'])->name('super-admin.notification_setting');
    Route::post('/admin/notification-settings', [AdminPushNotificationController::class, 'notificationSettingStore'])->name('super-admin.notification_setting_store');
    Route::get('/admin/delete-notification/{id}', [AdminPushNotificationController::class, 'deleteNotification'])->name('super-admin.delete_notification');

    Route::post('/super-admin/save-token', [App\Http\Controllers\HomeController::class, 'saveToken'])->name('admin.save_token');
    Route::post('/admin/state-city', [PostAShipmentController::class, 'state_city'])->name('admin.state_city');
    Route::get('/admin/dashboard', [HomeController::class, 'SuperAdminDashboard'])->name('super-admin.dashboard');
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('super-admin.users_list');
    Route::get('/admin/change-status/{id}', [AdminUserController::class, 'changeStatus'])->name('super-admin.change_user_status');
     Route::get('/admin/users/details/{id}', [AdminUserController::class, 'user_details'])->name('super-admin.user_details');

    Route::get('/admin/trucks', [AdminTruckController::class, 'trucksList'])->name('super-admin.trucks_list');
    Route::get('/admin/shipments', [AdminShipmentController::class, 'shipmentsList'])->name('super-admin.shipments_list');
    Route::get('/admin/feedbacks', [FeedbackController::class, 'feedbacksList'])->name('super-admin.feedbacks_list');
    Route::get('/admin/feedbacks/destroy/{id}', [FeedbackController::class, 'destroy'])->name('super-admin.feedbacks.destroy');

    //support
    Route::get('/super-admin/live-support', [AdminLiveSupportController::class, 'adminLiveSupport'])->name('super-admin.live_support');

    //profile
    Route::get('/admin/user-profile', [AdminUserController::class, 'user_profile'])->name('super-admin.user_profile');
    Route::post('/admin/change-password', [AdminUserController::class, 'changePassword'])->name('super-admin.change_password');
    Route::get('/admin/tools', [ToolsController::class, 'tools'])->name('super-admin.tools');
    Route::get('/admin/help-center', [ToolsController::class, 'helpCenter'])->name('super-admin.help-center');
    Route::get('/admin/cross-border-services', [ToolsController::class, 'helpCenterDetail'])->name('super-admin.help-center-detail');
    Route::post('/admin/form-tools', [ToolsController::class, 'form_tools'])->name('super-admin.form_tools');

    //packages
    Route::get('/admin/packages', [AdminPackageController::class, 'index'])->name('super-admin.packages.list');
    Route::get('/admin/packages/create', [AdminPackageController::class, 'create'])->name('super-admin.packages.create');
    Route::get('/admin/packages/detail/{id}', [AdminPackageController::class, 'detail'])->name('super-admin.packages.show');
    Route::post('/admin/packages/store', [AdminPackageController::class, 'store'])->name('super-admin.packages.store');
    Route::get('/admin/packages/edit/{id}', [AdminPackageController::class, 'edit'])->name('super-admin.packages.edit');
    Route::post('/admin/packages/update/{id}', [AdminPackageController::class, 'update'])->name('super-admin.packages.update');
    Route::get('/admin/packages/delete/{id}', [AdminPackageController::class, 'destroy'])->name('super-admin.packages.destroy');

    //Advertisment
    Route::get('/admin/advertisements', [AdminAdvertisementController::class, 'index'])->name('super-admin.advertisements.list');
    Route::get('/admin/advertisements/create', [AdminAdvertisementController::class, 'create'])->name('super-admin.advertisements.create');
    Route::get('/admin/advertisements/detail/{id}', [AdminAdvertisementController::class, 'detail'])->name('super-admin.advertisements.show');
    Route::post('/admin/advertisements/store', [AdminAdvertisementController::class, 'store'])->name('super-admin.advertisements.store');
    Route::get('/admin/advertisements/edit/{id}', [AdminAdvertisementController::class, 'edit'])->name('super-admin.advertisements.edit');
    Route::post('/admin/advertisements/update/{id}', [AdminAdvertisementController::class, 'update'])->name('super-admin.advertisements.update');
    Route::get('/admin/advertisements/delete/{id}', [AdminAdvertisementController::class, 'destroy'])->name('super-admin.advertisements.destroy');
    Route::get('/admin/adv-change-status/{id}', [AdminAdvertisementController::class, 'change_advertisements_status'])->name('super-admin.change_advertisements_status');

    //Shops
    Route::get('/admin/shops', [ShopController::class, 'index'])->name('super-admin.shops.list');
    Route::get('/admin/shops/create', [ShopController::class, 'create'])->name('super-admin.shops.create');
    Route::get('/admin/shops/detail/{id}', [ShopController::class, 'show'])->name('super-admin.shops.show');
    Route::post('/admin/shops/store', [ShopController::class, 'store'])->name('super-admin.shops.store');
    Route::get('/admin/shops/edit/{id}', [ShopController::class, 'edit'])->name('super-admin.shops.edit');
    Route::post('/admin/shops/update/{id}', [ShopController::class, 'update'])->name('super-admin.shops.update');
    Route::get('/admin/shops/delete/{id}', [ShopController::class, 'destroy'])->name('super-admin.shops.destroy');
    Route::get('/admin/shops-change-status/{id}', [ShopController::class, 'change_shops_status'])->name('super-admin.change_shops_status');

    //billing
    Route::get('/admin/billing/{id}', [BillingController::class, 'cancelSubscription'])->name('super-admin.billing.destroy');

    //services
    Route::get('/admin/services', [AdminServicesController::class, 'index'])->name('super-admin.service.list');
    Route::get('/admin/service/create', [AdminServicesController::class, 'create'])->name('super-admin.service.create');
    Route::get('/admin/service/detail/{id}', [AdminServicesController::class, 'show'])->name('super-admin.service.show');
    Route::post('/admin/service/store', [AdminServicesController::class, 'store'])->name('super-admin.service.store');
    Route::get('/admin/service/edit/{id}', [AdminServicesController::class, 'edit'])->name('super-admin.service.edit');
    Route::post('/admin/service/update/{id}', [AdminServicesController::class, 'update'])->name('super-admin.service.update');
    Route::get('/admin/service/delete/{id}', [AdminServicesController::class, 'destroy'])->name('super-admin.service.destroy');
    Route::get('/admin/service-change-status/{id}', [AdminServicesController::class, 'change_service_status'])->name('super-admin.change_service_status');

    //services category item
    Route::get('/admin/service-category-item', [AdminServiceCategoryItemController::class, 'index'])->name('super-admin.service_category_item.list');
    Route::get('/admin/service-category-item/create', [AdminServiceCategoryItemController::class, 'create'])->name('super-admin.service_category_item.create');
    Route::get('/admin/service-category-item/detail/{id}', [AdminServiceCategoryItemController::class, 'show'])->name('super-admin.service_category_item.show');
    Route::post('/admin/service-category-item/store', [AdminServiceCategoryItemController::class, 'store'])->name('super-admin.service_category_item.store');
    Route::get('/admin/service-category-item/edit/{id}', [AdminServiceCategoryItemController::class, 'edit'])->name('super-admin.service_category_item.edit');
    Route::post('/admin/service-category-item/update/{id}', [AdminServiceCategoryItemController::class, 'update'])->name('super-admin.service_category_item.update');
    Route::get('/admin/service-category-item/delete/{id}', [AdminServiceCategoryItemController::class, 'destroy'])->name('super-admin.service_category_item.destroy');
    Route::get('/admin/service-category', [AdminServiceCategoryItemController::class, 'serviceCategory'])->name('super-admin.service_category');
    Route::get('/admin/service-category-item-change-status/{id}', [AdminServiceCategoryItemController::class, 'change_service_status'])->name('super-admin.change_service_category_item_status');
    
    
    
    Route::get('/admin/sub-admins', [SubAdminsController::class, 'index'])->name('super-admin.subadmin.list');
    Route::get('/admin/sub-admins/edit/{id}', [SubAdminsController::class, 'edit'])->name('super-admin.subadmin.edit');
    Route::get('/admin/sub-admins/add', [SubAdminsController::class, 'add'])->name('super-admin.subadmin.add');
    Route::post('/admin/sub-admins/create', [SubAdminsController::class, 'create'])->name('super-admin.subadmin.create');
    Route::post('/admin/sub-admins/update/{id}', [SubAdminsController::class, 'update'])->name('super-admin.subadmin.update');
    Route::get('/admin/sub-admins/change_subadmin_status/{id}', [SubAdminsController::class, 'change_status'])->name('super-admin.subadmin.change_subadmin_status');
    
    
});
//
/*------------------------------------------
--------------------------------------------
All trucker Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['verified'])->group(function () {

    Route::middleware(['auth', 'user-access:trucker'])->group(function () {
        

    //Create OnBoarding
        Route::get('/trucker/on-boarding-profile', [UserProfileController::class, 'on_boarding_proflie'])->name('trucker.on_boarding_proflie');
        Route::get('/trucker/on-boarding-profile-notify', [UserProfileController::class, 'on_boarding_proflie_notify'])->name('trucker.on_boarding_proflie_notify');
        Route::post('/trucker/save_onboarding_profile_step_1', [UserProfileController::class, 'save_onboarding_profile_step_1'])->name('trucker.save_onboarding_profile_step_1');
        Route::post('/trucker/save_onboarding_profile_step_2', [UserProfileController::class, 'save_onboarding_profile_step_2'])->name('trucker.save_onboarding_profile_step_2');
        Route::post('/trucker/save_onboarding_profile_step_3', [UserProfileController::class, 'save_onboarding_profile_step_3'])->name('trucker.save_onboarding_profile_step_3');
        Route::post('/trucker/save_onboarding_profile_step_4', [UserProfileController::class, 'save_onboarding_profile_step_4'])->name('trucker.save_onboarding_profile_step_4');
        Route::post('/trucker/save_onboarding_profile_step_5', [UserProfileController::class, 'save_onboarding_profile_step_5'])->name('trucker.save_onboarding_profile_step_5');
        Route::post('/trucker/save_onboarding_profile_step_6', [UserProfileController::class, 'save_onboarding_profile_step_6'])->name('trucker.save_onboarding_profile_step_6');
        Route::post('/trucker/save_onboarding_profile_step_7', [UserProfileController::class, 'save_onboarding_profile_step_7'])->name('trucker.save_onboarding_profile_step_7');
        Route::post('/trucker/save_onboarding_profile_step_8', [UserProfileController::class, 'save_onboarding_profile_step_8'])->name('trucker.save_onboarding_profile_step_8');
        Route::get('/trucker/get_cities/{id}', [UserProfileController::class, 'get_cities'])->name('trucker.get_cities');


    //Update OnBoarding
       
        Route::post('/trucker/update_onboarding_profile_step_1', [UserProfileController::class, 'update_onboarding_profile_step_1'])->name('trucker.update_onboarding_profile_step_1');
        Route::post('/trucker/update_onboarding_profile_step_2', [UserProfileController::class, 'update_onboarding_profile_step_2'])->name('trucker.update_onboarding_profile_step_2');
        Route::post('/trucker/update_onboarding_profile_step_3', [UserProfileController::class, 'update_onboarding_profile_step_3'])->name('trucker.update_onboarding_profile_step_3');
        Route::post('/trucker/update_onboarding_profile_step_4', [UserProfileController::class, 'update_onboarding_profile_step_4'])->name('trucker.update_onboarding_profile_step_4');
        Route::post('/trucker/update_onboarding_profile_step_6', [UserProfileController::class, 'update_onboarding_profile_step_6'])->name('trucker.update_onboarding_profile_step_6');
        Route::post('/trucker/update_onboarding_profile_step_7', [UserProfileController::class, 'update_onboarding_profile_step_7'])->name('trucker.update_onboarding_profile_step_7');


        Route::middleware(['check-subscription', 'onBoardingMiddleware'])->group(function () {
            
             
             
             
            Route::get('/trucker/show-onboarding-profile', [UserProfileController::class, 'show_onboarding_profile'])->name('trucker.show_onboarding_profile');
            Route::get('/trucker/map', [NewTrackingRequestController::class, 'map'])->name('trucker.map');
            Route::post('/trucker/state-city', [PostAShipmentController::class, 'state_city'])->name('trucker.state_city');
            Route::get('/trucker/dashboard', [HomeController::class, 'truckerDashboard'])->name('trucker.dashboard');
            Route::get('/trucker/live-support/{id}', [LiveSupportController::class, 'live_support'])->name('trucker.live_support');
            Route::get('/trucker/tools', [ToolsController::class, 'tools'])->name('trucker.tools');
            Route::get('/trucker/help-center', [ToolsController::class, 'helpCenter'])->name('trucker.help-center');
            Route::get('/trucker/cross-border-services', [ToolsController::class, 'helpCenterDetail'])->name('trucker.help-center-detail');
            Route::post('/trucker/form-tools', [ToolsController::class, 'form_tools'])->name('trucker.form_tools');



            Route::post('/trucker/create-users-subscription', [BillingController::class, 'createUserSubscription'])->name('trucker.create_users_subscription');
            

            
            Route::post('/trucker/update-user-subscription', [UserManagementController::class, 'updateSubscriptionFromCustomerProfile'])->name('trucker.update_user_subscription');





            // Route::get('/trucker/my-shipments', [MyShipmentController::class, 'my_shipments'])->name('trucker.my_shipments');
            Route::get('/trucker/feedback-form', [HomeController::class, 'feedback'])->name('trucker.feedback_foam');
            Route::post('/trucker/feedback', [HomeController::class, 'feedbackSubmit'])->name('trucker.feedback_submit');

            //Notification
            Route::get('/trucker/notification-detail/{id}', [PushNotificationController::class, 'notification_detail'])->name('trucker.notification_detail');
            Route::post('/trucker/save-token', [App\Http\Controllers\HomeController::class, 'saveToken'])->name('trucker.save_token');
            Route::post('/trucker/send-notification', [PushNotificationController::class, 'sendNotification'])->name('trucker.send_notification');
            Route::get('/trucker/all-notifications', [PushNotificationController::class, 'all_notifications'])->name('trucker.all_notifications');
            Route::get('/trucker/get_all_notifications', [PushNotificationController::class, 'get_all_notifications'])->name('trucker.get_all_notifications');
            Route::get('/trucker/notification-setting', [PushNotificationController::class, 'notificationSetting'])->name('trucker.notification_setting');
            Route::post('/trucker/notification-settings', [PushNotificationController::class, 'notificationSettingStore'])->name('trucker.notification_setting_store');
            Route::get('/trucker/delete-notification/{id}', [PushNotificationController::class, 'deleteNotification'])->name('trucker.delete_notification');

            //user-management

            Route::get('/trucker/user-management', [UserManagementController::class, 'index'])->name('trucker.user_management.index');
            Route::get('/trucker/user-management-status/{id}', [UserManagementController::class, 'ChangeStatus'])->name('trucker.user_management_status');
            Route::get('/trucker/user-management/new-user', [UserManagementController::class, 'createUser'])->name('trucker.user_management.create_user');
            Route::get('/trucker/user-management/payment', [UserManagementController::class, 'userPayment'])->name('trucker.user_management.user_payment');
            Route::post('/trucker/user-management/subscription', [UserManagementController::class, 'handlePayment'])->name('trucker.user_management.user_subscription');
            Route::post('/trucker/user-management/email-validation', [UserManagementController::class, 'emailValidation'])->name('trucker.user_management.email_validation');

            //billing
            Route::get('/trucker/billing', [BillingController::class, 'index'])->name('trucker.billing.index');
            Route::get('/trucker/billing/{id}/detail', [BillingController::class, 'show'])->name('trucker.billing.show');
            Route::get('/trucker/billing/{id}', [BillingController::class, 'cancelSubscription'])->name('trucker.billing.destroy');
            Route::get('/trucker/billing/{id}/download-pdf', [BillingController::class, 'pdf'])->name('trucker.billing.download_pdf');
            Route::get('/trucker/update-subscriptions/{id}', [BillingController::class, 'updateSubscription'])->name('trucker.update_subscriptions');
            Route::post('/trucker/update-users-subscription', [BillingController::class, 'updateUserSubscription'])->name('trucker.update_users_subscription');
            Route::get('/trucker/create-subscriptions/{id}', [BillingController::class, 'createSubscription'])->name('trucker.create_subscriptions');
            Route::post('/trucker/create-users-subscription', [BillingController::class, 'createUserSubscription'])->name('trucker.create_users_subscription');

            // Invoice
            Route::get('/trucker/invoice/index', [InvoiceController::class, 'index'])->name('trucker.invoice.index');
            Route::get('/trucker/invoice/new', [InvoiceController::class, 'create'])->name('trucker.invoice.create');
            Route::post('/trucker/invoice/store', [InvoiceController::class, 'store'])->name('trucker.invoice.store');
            Route::get('/trucker/invoice/view/{id}', [InvoiceController::class, 'show'])->name('trucker.invoice.show');
            Route::get('/trucker/invoice/destroy/{id}', [InvoiceController::class, 'destroy'])->name('trucker.invoice.destroy');

            //truck
            Route::get('/trucker/truck', [TruckController::class, 'index'])->name('trucker.truck.index');
            Route::get('/trucker/truck/create', [TruckController::class, 'create'])->name('trucker.truck.create');
            Route::post('/trucker/truck/store', [TruckController::class, 'store'])->name('trucker.truck.store');
            Route::get('/trucker/truck/detail/{id}', [TruckController::class, 'show'])->name('trucker.truck.detail');
            Route::get('/trucker/truck/edit/{id}', [TruckController::class, 'edit'])->name('trucker.truck.edit');
            Route::post('/trucker/truck/update/{id}', [TruckController::class, 'update'])->name('trucker.truck.update');
            Route::get('/trucker/truck/delete/{id}', [TruckController::class, 'destroy'])->name('trucker.truck.delete');

            //search loads
            Route::get('/trucker/search-loads', [SearchLoadsController::class, 'search_loads'])->name('trucker.search_loads');
            Route::get('/trucker/book-loads/{id}', [SearchLoadsController::class, 'bookLoad'])->name('trucker.book_load');
            Route::get('/trucker/bid-loads/{id}', [SearchLoadsController::class, 'bidLoad'])->name('trucker.bid_load');
            Route::get('/trucker/private-leads', [SearchLoadsController::class, 'privateLeads'])->name('trucker.private_leads');

            //My Loads
            Route::get('/trucker/my-loads-open', [MyLoadsController::class, 'myloads'])->name('trucker.my_loads');
            Route::get('/trucker/my-loads-active', [MyLoadsController::class, 'my_loads_active'])->name('trucker.my_loads_active');
            Route::get('/trucker/my-loads-history', [MyLoadsController::class, 'my_loads_history'])->name('trucker.my_loads_history');
            Route::get('/trucker/my-loads-overview/{id}', [MyLoadsController::class, 'my_loads_overview'])->name('trucker.my_loads_overview');
            Route::get('/trucker/my-loads-bid-activity/{id}', [MyLoadsController::class, 'my_loads_bid_activity'])->name('trucker.my_loads_bid_activity');
            Route::get('/trucker/my-loads-requests-activity/{id}', [MyLoadsController::class, 'my_loads_requests_activity'])->name('trucker.my_loads_requests_activity');
            Route::get('/trucker/my-loads-status-tracking/{id}', [MyLoadsController::class, 'my_loads_status_tracking'])->name('trucker.my_loads_status_tracking');
            Route::get('/trucker/my-loads-tracking/{id}', [MyLoadsController::class, 'my_loads_tracking'])->name('trucker.my_loads_tracking');
            Route::post('/trucker/my-loads-update-tracking/{id}', [MyLoadsController::class, 'my_loads_update_tracking'])->name('trucker.my_loads_update_tracking');
            // Route::post('/trucker/status-accept-decline/{id}', [MyLoadsController::class, 'status_accept_decline'])->name('trucker.status_accept_decline');
            Route::get('/trucker/delete-a-shipment/{id}', [PostAShipmentController::class, 'delete_a_shipment'])->name('trucker.delete_a_shipment');
            Route::get('/trucker/borker-details/{id}', [MyShipmentController::class, 'carrierDetail'])->name('trucker.broker_details');

            //Private Network Start
            Route::get('/trucker/private-network', [PrivateNetworkController::class, 'private_network'])->name('trucker.private_network');
            Route::get('/trucker/private-network-detail/{id}', [PrivateNetworkController::class, 'private_network_deatil'])->name('trucker.private_network_deatil');
            Route::get('/trucker/create-contact', [PrivateNetworkController::class, 'create_contact'])->name('trucker.create_contact');
            Route::post('/trucker/create-contact-store', [PrivateNetworkController::class, 'create_contact_store'])->name('trucker.create_contact_store');
            Route::post('/trucker/contact-assign-group', [PrivateNetworkController::class, 'contact_assign_group'])->name('trucker.contact_assign_group');
            Route::get('/trucker/groups', [PrivateNetworkController::class, 'groups'])->name('trucker.groups');
            Route::get('/trucker/groups-detail/{id}', [PrivateNetworkController::class, 'groups_detail'])->name('trucker.groups_detail');
            Route::post('/trucker/groups-store', [PrivateNetworkController::class, 'groups_store'])->name('trucker.groups_store');
            Route::post('/trucker/groups-update/{id}', [PrivateNetworkController::class, 'groups_update'])->name('trucker.groups_update');
            Route::get('/trucker/groups-delete/{id}', [PrivateNetworkController::class, 'groups_delete'])->name('trucker.groups_delete');
            Route::get('/trucker/group-remove-contact/{group_id}/{contact_id}', [PrivateNetworkController::class, 'group_remove_contact'])->name('trucker.group_remove_contact');
            Route::get('/trucker/contact-remove-groups/{contact_id}', [PrivateNetworkController::class, 'contact_remove_groups'])->name('trucker.contact_remove_groups');
            Route::get('/trucker/edit-contact/{id}', [PrivateNetworkController::class, 'edit_contact'])->name('trucker.edit_contact');
            Route::put('/trucker/contact-update/{contact}', [PrivateNetworkController::class, 'contact_update'])->name('trucker.contact_update');
            Route::get('/trucker/contact-delete/{id}', [PrivateNetworkController::class, 'contact_delete'])->name('trucker.contact_delete');

            //Private Network End
        });

        //my-plans
        Route::get('/trucker/my-payment-methods', [MyPlansController::class, 'addCard'])->name('trucker.add_card');
        Route::post('/trucker/my-plans', [MyPlansController::class, 'myPlans'])->name('trucker.my_plans');
        Route::get('/trucker/payment-profile/{id}', [MyPlansController::class, 'getCustomerPaymentProfile'])->name('trucker.payment_profile');
        Route::get('/trucker/payment-profile-delete/{id}', [MyPlansController::class, 'deleteCustomerPaymentProfile'])->name('trucker.delete_customer_payment_profile');
        Route::get('/trucker/payment-profile-auto/{id}', [MyPlansController::class, 'autoCustomerPaymentProfile'])->name('trucker.auto_customer_payment_profile');
        Route::get('/trucker/get-states/{id}', [BillingController::class, 'getStates'])->name('get.states');
        Route::get('/trucker/get-cities/{stateId}', [BillingController::class, 'getCities']);
        
        //user-profile
        Route::get('/trucker/user-profile', [UserProfileController::class, 'user_profile'])->name('trucker.user_profile');
        Route::post('/trucker/update_profile', [UserProfileController::class, 'update_profile'])->name('trucker.update_profile');
        Route::post('/trucker/update_company_profile', [UserProfileController::class, 'update_company_profile'])->name('trucker.update_company_profile');
        Route::post('/trucker/change-password', [UserProfileController::class, 'changePassword'])->name('trucker.change_password');
        Route::post('/trucker/update-user-subscription', [UserManagementController::class, 'updateSubscriptionFromCustomerProfile'])->name('trucker.update_user_subscription');
        Route::get('/trucker/update-subscription', [HomeController::class, 'updateSubscription'])->name('trucker.update_subscription');
        Route::get('/trucker/contact-owner', [HomeController::class, 'contactOwner'])->name('trucker.contact_owner');
        Route::get('/trucker/company-profile', [UserProfileController::class, 'user_company_profile'])->name('trucker.user_company_profile');
    });

    Route::middleware(['auth', 'user-access:shipper'])->group(function () {

        Route::get('/shipper/map', [NewTrackingRequestController::class, 'map'])->name('shipper.map');

        Route::get('/shipper/dashboard', [HomeController::class, 'shipperDashboard'])->name('shipper.dashboard');
        Route::get('/shipper/search-trucks', [SearchTrucksController::class, 'search_trucks'])->name('shipper.search_trucks');
        Route::get('/shipper/search-loads', [SearchLoadsController::class, 'search_loads'])->name('shipper.search_loads');

        //tools
        Route::get('/shipper/tools', [ToolsController::class, 'tools'])->name('shipper.tools');
        Route::get('/shipper/help-center', [ToolsController::class, 'helpCenter'])->name('shipper.help-center');
        Route::get('/shipper/cross-border-services', [ToolsController::class, 'helpCenterDetail'])->name('shipper.help-center-detail');
        Route::post('/shipper/state-city', [PostAShipmentController::class, 'state_city'])->name('shipper.state_city');
        Route::post('/shipper/form-tools', [ToolsController::class, 'form_tools'])->name('shipper.form_tools');

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
        Route::get('/shipper/my-shipments-status-tracking/{id}', [MyShipmentController::class, 'my_shipments_status_tracking'])->name('shipper.my_shipments_status_tracking');
        Route::get('/shipper/my-shipments-tracking/{id}', [MyShipmentController::class, 'my_shipments_tracking'])->name('shipper.my_shipments_tracking');
        Route::post('/shipper/my-shipment-update-tracking/{id}', [MyShipmentController::class, 'my_shipment_update_tracking'])->name('shipper.my_shipment_update_tracking');
        Route::post('/shipper/status-accept-decline/{id}', [MyShipmentController::class, 'status_accept_decline'])->name('shipper.status_accept_decline');
        Route::get('/shipper/delete-a-shipment/{id}', [PostAShipmentController::class, 'delete_a_shipment'])->name('shipper.delete_a_shipment');
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
        Route::post('/shipper/user-management/email-validation', [UserManagementController::class, 'emailValidation'])->name('shipper.user_management.email_validation');

        // userprorfile

        Route::get('/shipper/user-profile', [UserProfileController::class, 'user_profile'])->name('shipper.user_profile');
        Route::post('/shipper/change-password', [UserProfileController::class, 'changePassword'])->name('shipper.change_password');
        Route::get('/shipper/company-profile', [UserProfileController::class, 'user_company_profile'])->name('shipper.user_company_profile');

        //Notification

        Route::post('/shipper/save-token', [App\Http\Controllers\HomeController::class, 'saveToken'])->name('shipper.save_token');
        Route::post('/shipper/send-notification', [PushNotificationController::class, 'sendNotification'])->name('shipper.send_notification');
        Route::get('/shipper/all-notifications', [PushNotificationController::class, 'all_notifications'])->name('shipper.all_notifications');
        Route::get('/shipper/get_all_notifications', [PushNotificationController::class, 'get_all_notifications'])->name('shipper.get_all_notifications');
        Route::get('/shipper/notification-setting', [PushNotificationController::class, 'notificationSetting'])->name('shipper.notification_setting');
        Route::post('/shipper/notification-settings', [PushNotificationController::class, 'notificationSettingStore'])->name('shipper.notification_setting_store');
        Route::get('/shipper/delete-notification/{id}', [PushNotificationController::class, 'deleteNotification'])->name('shipper.delete_notification');

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

        Route::middleware(['check-subscription'])->group(function () {
            Route::get('/broker/dashboard', [HomeController::class, 'brokerDashboard'])->name('broker.dashboard');
            Route::get('/broker/search-trucks', [SearchTrucksController::class, 'search_trucks'])->name('broker.search_trucks');
            // Route::get('/broker/search-loads', [SearchLoadsController::class, 'search_loads'])->name('broker.search_loads');

            // Tracking
            Route::get('/broker/map', [NewTrackingRequestController::class, 'map'])->name('broker.map');
            Route::get('/broker/trackings', [NewTrackingRequestController::class, 'trackings'])->name('broker.trackings');
            Route::get('/broker/tracking-details/{id}', [NewTrackingRequestController::class, 'tracking_details'])->name('broker.tracking_details');
            Route::get('/broker/new-tracking-request', [NewTrackingRequestController::class, 'new_tracking_request'])->name('broker.new_tracking_request');
            Route::post('/broker/new-tracking-store', [NewTrackingRequestController::class, 'new_tracking_store'])->name('broker.new_tracking_store');
            Route::get('/broker/edit-tracking-request/{id}', [NewTrackingRequestController::class, 'edit_tracking_request'])->name('broker.edit_tracking_request');
            Route::get('/broker/delete-tracking-request/{id}', [NewTrackingRequestController::class, 'delete_tracking_request'])->name('broker.delete_tracking_request');
            Route::post('/broker/new-tracking-update/{id}', [NewTrackingRequestController::class, 'new_tracking_update'])->name('broker.new_tracking_update');
            Route::get('/broker/new-tracking-request', [NewTrackingRequestController::class, 'new_tracking_request'])->name('broker.new_tracking_request');

            // Invoice
            
            Route::post('/broker/create-users-subscription', [BillingController::class, 'createUserSubscription'])->name('broker.create_users_subscription');
            

            
            Route::post('/broker/update-user-subscription', [UserManagementController::class, 'updateSubscriptionFromCustomerProfile'])->name('broker.update_user_subscription');




            // Route::resource('/shipper/invoice', InvoiceController::class);

            //Shipments
            Route::post('/broker/state-city', [PostAShipmentController::class, 'state_city'])->name('broker.state_city');
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
            Route::any('/broker/status-accept-decline/{id}', [MyShipmentController::class, 'status_accept_decline'])->name('broker.status_accept_decline');
            Route::get('/broker/delete-a-shipment/{id}', [PostAShipmentController::class, 'delete_a_shipment'])->name('broker.delete_a_shipment');
            Route::get('/broker/my-shipments-status-tracking/{id}', [MyShipmentController::class, 'my_shipments_status_tracking'])->name('broker.my_shipments_status_tracking');
            Route::get('/broker/shipment-invoice', [MyShipmentController::class, 'shipmentInvoice'])->name('broker.shipment_invoice');
            Route::get('/broker/shipment-invoice/download/{id}', [MyShipmentController::class, 'shipmentInvoiceDownload'])->name('broker.shipment_invoice.download');
            Route::get('/broker/carrier-detail/{id}', [MyShipmentController::class, 'carrierDetail'])->name('broker.carrier_detail');

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
            Route::get('/broker/edit-contact/{id}', [PrivateNetworkController::class, 'edit_contact'])->name('broker.edit_contact');
            Route::put('/broker/contact-update/{contact}', [PrivateNetworkController::class, 'contact_update'])->name('broker.contact_update');
            Route::get('/broker/contact-delete/{id}', [PrivateNetworkController::class, 'contact_delete'])->name('broker.contact_delete');

            //Private Network End

            //Notification
            Route::post('/broker/save-token', [App\Http\Controllers\HomeController::class, 'saveToken'])->name('broker.save_token');
            Route::post('/broker/send-notification', [PushNotificationController::class, 'sendNotification'])->name('broker.send_notification');
            Route::get('broker/all-notifications', [PushNotificationController::class, 'all_notifications'])->name('broker.all_notifications');
            Route::any('/broker/get_all_notifications', [PushNotificationController::class, 'get_all_notifications'])->name('broker.get_all_notifications');
            Route::get('/broker/delete-notification/{id}', [PushNotificationController::class, 'deleteNotification'])->name('broker.delete_notification');

            // live
            Route::get('/broker/live-support/{id}', [LiveSupportController::class, 'live_support'])->name('broker.live_support');

            //tools
            Route::get('/broker/tools', [ToolsController::class, 'tools'])->name('broker.tools');
            Route::get('/broker/help-center', [ToolsController::class, 'helpCenter'])->name('broker.help-center');
            Route::get('/broker/cross-border-services', [ToolsController::class, 'helpCenterDetail'])->name('broker.help-center-detail');
            Route::post('/broker/form-tools', [ToolsController::class, 'form_tools'])->name('broker.form_tools');

            //user-management
            Route::get('/broker/user-management', [UserManagementController::class, 'index'])->name('broker.user_management.index');
            Route::get('/broker/user-management-status/{id}', [UserManagementController::class, 'ChangeStatus'])->name('broker.user_management_status');
            Route::get('/broker/user-management/new-user', [UserManagementController::class, 'createUser'])->name('broker.user_management.create_user');
            Route::get('/broker/user-management/payment', [UserManagementController::class, 'userPayment'])->name('broker.user_management.user_payment');
            Route::post('/broker/user-management/subscription', [UserManagementController::class, 'handlePayment'])->name('broker.user_management.user_subscription');
            Route::post('/broker/user-management/email-validation', [UserManagementController::class, 'emailValidation'])->name('broker.user_management.email_validation');

            //billing
            Route::get('/broker/billing', [BillingController::class, 'index'])->name('broker.billing.index');
            Route::get('/broker/billing/{id}/detail', [BillingController::class, 'show'])->name('broker.billing.show');
            // Route::get('/broker/billing/{id}', [BillingController::class, 'cancelSubscription'])->name('broker.billing.destroy');
            Route::get('/broker/billing/{id}/download-pdf', [BillingController::class, 'pdf'])->name('broker.billing.download_pdf');
            Route::get('/broker/update-subscriptions/{id}', [BillingController::class, 'updateSubscription'])->name('broker.update_subscriptions');
            Route::post('/broker/update-users-subscription', [BillingController::class, 'updateUserSubscription'])->name('broker.update_users_subscription');

            Route::get('/broker/notification-setting', [PushNotificationController::class, 'notificationSetting'])->name('broker.notification_setting');
            Route::post('/broker/notification-settings', [PushNotificationController::class, 'notificationSettingStore'])->name('broker.notification_setting_store');
        });
        
        Route::get('/broker/my-payment-methods', [MyPlansController::class, 'addCard'])->name('broker.add_card');
        Route::post('/broker/my-plans', [MyPlansController::class, 'myPlans'])->name('broker.my_plans');
        Route::get('/broker/payment-profile/{id}', [MyPlansController::class, 'getCustomerPaymentProfile'])->name('broker.payment_profile');
        Route::get('/broker/payment-profile-delete/{id}', [MyPlansController::class, 'deleteCustomerPaymentProfile'])->name('broker.delete_customer_payment_profile');
        Route::get('/broker/payment-profile-auto/{id}', [MyPlansController::class, 'autoCustomerPaymentProfile'])->name('broker.auto_customer_payment_profile');
        Route::get('/broker/get-states/{id}', [BillingController::class, 'getStates'])->name('get.states');
        Route::get('/broker/get-cities/{stateId}', [BillingController::class, 'getCities']);

        //broker Profile
        
        Route::post('/broker/update_profile', [UserProfileController::class, 'update_profile'])->name('broker.update_profile');
        Route::post('/broker/update_company_profile', [UserProfileController::class, 'update_company_profile'])->name('broker.update_company_profile');
        
        
        
        Route::get('/broker/user-profile', [UserProfileController::class, 'user_profile'])->name('broker.user_profile');
        Route::post('/broker/change-password', [UserProfileController::class, 'changePassword'])->name('broker.change_password');
        Route::get('/broker/company-profile', [UserProfileController::class, 'user_company_profile'])->name('broker.user_company_profile');

        Route::post('/broker/update-user-subscription', [UserManagementController::class, 'updateSubscriptionFromCustomerProfile'])->name('broker.update_user_subscription');
        Route::get('/broker/update-subscription', [HomeController::class, 'updateSubscription'])->name('broker.update_subscription');
        Route::get('/broker/contact-owner', [HomeController::class, 'contactOwner'])->name('broker.contact_owner');

    });

    Route::middleware(['auth', 'user-access:combo'])->group(function () {
         //onboarding
         Route::get('/combo/on-boarding-profile', [UserProfileController::class, 'on_boarding_proflie'])->name('combo.on_boarding_proflie');
         Route::get('/combo/on-boarding-profile-notify', [UserProfileController::class, 'on_boarding_proflie_notify'])->name('combo.on_boarding_proflie_notify');
         Route::post('/combo/save_onboarding_profile_step_1', [UserProfileController::class, 'save_onboarding_profile_step_1'])->name('combo.save_onboarding_profile_step_1');
         Route::post('/combo/save_onboarding_profile_step_2', [UserProfileController::class, 'save_onboarding_profile_step_2'])->name('combo.save_onboarding_profile_step_2');
         Route::post('/combo/save_onboarding_profile_step_3', [UserProfileController::class, 'save_onboarding_profile_step_3'])->name('combo.save_onboarding_profile_step_3');
         Route::post('/combo/save_onboarding_profile_step_4', [UserProfileController::class, 'save_onboarding_profile_step_4'])->name('combo.save_onboarding_profile_step_4');
         Route::post('/combo/save_onboarding_profile_step_5', [UserProfileController::class, 'save_onboarding_profile_step_5'])->name('combo.save_onboarding_profile_step_5');
         Route::post('/combo/save_onboarding_profile_step_6', [UserProfileController::class, 'save_onboarding_profile_step_6'])->name('combo.save_onboarding_profile_step_6');
         Route::post('/combo/save_onboarding_profile_step_7', [UserProfileController::class, 'save_onboarding_profile_step_7'])->name('combo.save_onboarding_profile_step_7');
         Route::post('/combo/save_onboarding_profile_step_8', [UserProfileController::class, 'save_onboarding_profile_step_8'])->name('combo.save_onboarding_profile_step_8');
         
         Route::get('/combo/get_cities/{id}', [UserProfileController::class, 'get_cities'])->name('combo.get_cities');
         
         
         //Update OnBoarding
    
        Route::post('/combo/update_onboarding_profile_step_1', [UserProfileController::class, 'update_onboarding_profile_step_1'])->name('combo.update_onboarding_profile_step_1');
        Route::post('/combo/update_onboarding_profile_step_2', [UserProfileController::class, 'update_onboarding_profile_step_2'])->name('combo.update_onboarding_profile_step_2');
        Route::post('/combo/update_onboarding_profile_step_3', [UserProfileController::class, 'update_onboarding_profile_step_3'])->name('combo.update_onboarding_profile_step_3');
        Route::post('/combo/update_onboarding_profile_step_4', [UserProfileController::class, 'update_onboarding_profile_step_4'])->name('combo.update_onboarding_profile_step_4');
        Route::post('/combo/update_onboarding_profile_step_6', [UserProfileController::class, 'update_onboarding_profile_step_6'])->name('combo.update_onboarding_profile_step_6');
        Route::post('/combo/update_onboarding_profile_step_7', [UserProfileController::class, 'update_onboarding_profile_step_7'])->name('combo.update_onboarding_profile_step_7');
        
        
        

        Route::middleware(['check-subscription','onBoardingMiddleware'])->group(function () {
            
            Route::get('/combo/show-onboarding-profile', [UserProfileController::class, 'show_onboarding_profile'])->name('combo.show_onboarding_profile');
                
                
            Route::get('/combo/dashboard', [HomeController::class, 'comboDashboard'])->name('combo.dashboard');
            Route::get('/combo/search-trucks', [SearchTrucksController::class, 'search_trucks'])->name('combo.search_trucks');
            Route::get('/combo/search-loads', [SearchLoadsController::class, 'search_loads'])->name('combo.search_loads');


            Route::get('/combo/invoice/index', [InvoiceController::class, 'index'])->name('combo.invoice.index');
            Route::get('/combo/invoice/new', [InvoiceController::class, 'create'])->name('combo.invoice.create');
            Route::post('/combo/invoice/store', [InvoiceController::class, 'store'])->name('combo.invoice.store');
            Route::get('/combo/invoice/view/{id}', [InvoiceController::class, 'show'])->name('combo.invoice.show');
            Route::get('/combo/invoice/destroy/{id}', [InvoiceController::class, 'destroy'])->name('combo.invoice.destroy');

            // Tracking
            Route::get('/combo/map', [NewTrackingRequestController::class, 'map'])->name('combo.map');
            Route::get('/combo/trackings', [NewTrackingRequestController::class, 'trackings'])->name('combo.trackings');
            Route::get('/combo/tracking-details/{id}', [NewTrackingRequestController::class, 'tracking_details'])->name('combo.tracking_details');
            Route::get('/combo/new-tracking-request', [NewTrackingRequestController::class, 'new_tracking_request'])->name('combo.new_tracking_request');
            Route::post('/combo/new-tracking-store', [NewTrackingRequestController::class, 'new_tracking_store'])->name('combo.new_tracking_store');
            Route::get('/combo/edit-tracking-request/{id}', [NewTrackingRequestController::class, 'edit_tracking_request'])->name('combo.edit_tracking_request');
            Route::get('/combo/delete-tracking-request/{id}', [NewTrackingRequestController::class, 'delete_tracking_request'])->name('combo.delete_tracking_request');
            Route::post('/combo/new-tracking-update/{id}', [NewTrackingRequestController::class, 'new_tracking_update'])->name('combo.new_tracking_update');
            Route::get('/combo/new-tracking-request', [NewTrackingRequestController::class, 'new_tracking_request'])->name('combo.new_tracking_request');

            // Invoice

            // Route::resource('/shipper/invoice', InvoiceController::class);
            Route::post('/combo/state-city', [PostAShipmentController::class, 'state_city'])->name('combo.state_city');
            //Shipments
            Route::get('/combo/my-shipments', [MyShipmentController::class, 'my_shipments'])->name('combo.my_shipments');
            Route::get('/combo/post-a-shipment', [PostAShipmentController::class, 'post_a_shipment'])->name('combo.post_a_shipment');
            Route::post('/combo/store-a-shipment', [PostAShipmentController::class, 'store_a_shipment'])->name('combo.store_a_shipment');
            Route::get('/combo/edit-a-shipment/{id}', [PostAShipmentController::class, 'edit_a_shipment'])->name('combo.edit_a_shipment');
            Route::post('/combo/update-a-shipment/{id}', [PostAShipmentController::class, 'update_a_shipment'])->name('combo.update_a_shipment');
            Route::get('/combo/my-shipments-open', [MyShipmentController::class, 'my_shipments'])->name('combo.my_shipments');
            Route::get('/combo/my-shipments-active', [MyShipmentController::class, 'my_shipments_active'])->name('combo.my_shipments_active');
            Route::get('/combo/my-shipments-history', [MyShipmentController::class, 'my_shipments_history'])->name('combo.my_shipments_history');
            Route::get('/combo/my-shipments-overview/{id}', [MyShipmentController::class, 'my_shipments_overview'])->name('combo.my_shipments_overview');
            Route::get('/combo/my-shipments-bid-activity/{id}', [MyShipmentController::class, 'my_shipments_bid_activity'])->name('combo.my_shipments_bid_activity');
            Route::get('/combo/my-shipments-requests-activity/{id}', [MyShipmentController::class, 'my_shipments_requests_activity'])->name('combo.my_shipments_requests_activity');
            Route::get('/combo/my-shipments-tracking/{id}', [MyShipmentController::class, 'my_shipments_tracking'])->name('combo.my_shipments_tracking');
            Route::post('/combo/my-shipment-update-tracking/{id}', [MyShipmentController::class, 'my_shipment_update_tracking'])->name('combo.my_shipment_update_tracking');
            Route::any('/combo/status-accept-decline/{id}', [MyShipmentController::class, 'status_accept_decline'])->name('combo.status_accept_decline');
            Route::get('/combo/delete-a-shipment/{id}', [PostAShipmentController::class, 'delete_a_shipment'])->name('combo.delete_a_shipment');
            Route::get('/combo/my-shipments-status-tracking/{id}', [MyShipmentController::class, 'my_shipments_status_tracking'])->name('combo.my_shipments_status_tracking');
            Route::get('/combo/shipment-invoice', [MyShipmentController::class, 'shipmentInvoice'])->name('combo.shipment_invoice');
            Route::get('/combo/shipment-invoice/download/{id}', [MyShipmentController::class, 'shipmentInvoiceDownload'])->name('combo.shipment_invoice.download');
            Route::get('/combo/carrier-detail/{id}', [MyShipmentController::class, 'carrierDetail'])->name('combo.carrier_detail');


            Route::post('/combo/create-users-subscription', [BillingController::class, 'createUserSubscription'])->name('combo.create_users_subscription');

            
            Route::post('/combo/update-user-subscription', [UserManagementController::class, 'updateSubscriptionFromCustomerProfile'])->name('combo.update_user_subscription');




            //feedback
            Route::get('/combo/feedback-form', [HomeController::class, 'feedback'])->name('combo.feedback_foam');
            Route::post('/combo/feedback', [HomeController::class, 'feedbackSubmit'])->name('combo.feedback_submit');

            //Private Network Start
            Route::get('/combo/private-network', [PrivateNetworkController::class, 'private_network'])->name('combo.private_network');
            Route::get('/combo/private-network-detail/{id}', [PrivateNetworkController::class, 'private_network_deatil'])->name('combo.private_network_deatil');
            Route::get('/combo/create-contact', [PrivateNetworkController::class, 'create_contact'])->name('combo.create_contact');
            Route::post('/combo/create-contact-store', [PrivateNetworkController::class, 'create_contact_store'])->name('combo.create_contact_store');
            Route::post('/combo/contact-assign-group', [PrivateNetworkController::class, 'contact_assign_group'])->name('combo.contact_assign_group');
            Route::get('/combo/groups', [PrivateNetworkController::class, 'groups'])->name('combo.groups');
            Route::get('/combo/groups-detail/{id}', [PrivateNetworkController::class, 'groups_detail'])->name('combo.groups_detail');
            Route::post('/combo/groups-store', [PrivateNetworkController::class, 'groups_store'])->name('combo.groups_store');
            Route::post('/combo/groups-update/{id}', [PrivateNetworkController::class, 'groups_update'])->name('combo.groups_update');
            Route::get('/combo/groups-delete/{id}', [PrivateNetworkController::class, 'groups_delete'])->name('combo.groups_delete');
            Route::get('/combo/group-remove-contact/{group_id}/{contact_id}', [PrivateNetworkController::class, 'group_remove_contact'])->name('combo.group_remove_contact');
            Route::get('/combo/contact-remove-groups/{contact_id}', [PrivateNetworkController::class, 'contact_remove_groups'])->name('combo.contact_remove_groups');
            Route::get('/combo/edit-contact/{id}', [PrivateNetworkController::class, 'edit_contact'])->name('combo.edit_contact');
            Route::put('/combo/contact-update/{contact}', [PrivateNetworkController::class, 'contact_update'])->name('combo.contact_update');
            Route::get('/combo/contact-delete/{id}', [PrivateNetworkController::class, 'contact_delete'])->name('combo.contact_delete');

            //Private Network End

            //Notification
            Route::get('/combo/notification-detail/{id}', [PushNotificationController::class, 'notification_detail'])->name('combo.notification_detail');
            Route::post('/combo/save-token', [App\Http\Controllers\HomeController::class, 'saveToken'])->name('combo.save_token');
            Route::post('/combo/send-notification', [PushNotificationController::class, 'sendNotification'])->name('combo.send_notification');
            Route::get('/combo/all-notifications', [PushNotificationController::class, 'all_notifications'])->name('combo.all_notifications');
            Route::any('/combo/get_all_notifications', [PushNotificationController::class, 'get_all_notifications'])->name('combo.get_all_notifications');
            Route::get('/combo/notification-setting', [PushNotificationController::class, 'notificationSetting'])->name('combo.notification_setting');
            Route::post('/combo/notification-settings', [PushNotificationController::class, 'notificationSettingStore'])->name('combo.notification_setting_store');
            Route::get('/combo/delete-notification/{id}', [PushNotificationController::class, 'deleteNotification'])->name('combo.delete_notification');

            // live
            Route::get('/combo/live-support/{id}', [LiveSupportController::class, 'live_support'])->name('combo.live_support');

            //tools
            Route::get('/combo/tools', [ToolsController::class, 'tools'])->name('combo.tools');
            Route::post('/combo/form-tools', [ToolsController::class, 'form_tools'])->name('combo.form_tools');
            Route::get('/combo/help-center', [ToolsController::class, 'helpCenter'])->name('combo.help-center');
            Route::get('/combo/cross-border-services', [ToolsController::class, 'helpCenterDetail'])->name('combo.help-center-detail');

            //user-management
            Route::get('/combo/user-management', [UserManagementController::class, 'index'])->name('combo.user_management.index');
            Route::get('/combo/user-management-status/{id}', [UserManagementController::class, 'ChangeStatus'])->name('combo.user_management_status');
            Route::get('/combo/user-management/new-user', [UserManagementController::class, 'createUser'])->name('combo.user_management.create_user');
            Route::get('/combo/user-management/payment', [UserManagementController::class, 'userPayment'])->name('combo.user_management.user_payment');
            Route::post('/combo/user-management/subscription', [UserManagementController::class, 'handlePayment'])->name('combo.user_management.user_subscription');
            Route::post('/combo/user-management/email-validation', [UserManagementController::class, 'emailValidation'])->name('combo.user_management.email_validation');

            //billing
            Route::get('/combo/billing', [BillingController::class, 'index'])->name('combo.billing.index');
            Route::get('/combo/billing/{id}/detail', [BillingController::class, 'show'])->name('combo.billing.show');
            Route::get('/combo/billing/{id}', [BillingController::class, 'cancelSubscription'])->name('combo.billing.destroy');
            Route::get('/combo/billing/{id}/download-pdf', [BillingController::class, 'pdf'])->name('combo.billing.download_pdf');
            Route::get('/combo/update-subscriptions/{id}', [BillingController::class, 'updateSubscription'])->name('combo.update_subscriptions');
            Route::post('/combo/update-users-subscription', [BillingController::class, 'updateUserSubscription'])->name('combo.update_users_subscription');

            Route::get('/combo/notification-setting', [PushNotificationController::class, 'notificationSetting'])->name('combo.notification_setting');
            Route::post('/combo/notification-settings', [PushNotificationController::class, 'notificationSettingStore'])->name('combo.notification_setting_store');

            //truck
            Route::get('/combo/truck', [TruckController::class, 'index'])->name('combo.truck.index');
            Route::get('/combo/truck/create', [TruckController::class, 'create'])->name('combo.truck.create');
            Route::post('/combo/truck/store', [TruckController::class, 'store'])->name('combo.truck.store');
            Route::get('/combo/truck/detail/{id}', [TruckController::class, 'show'])->name('combo.truck.detail');
            Route::get('/combo/truck/edit/{id}', [TruckController::class, 'edit'])->name('combo.truck.edit');
            Route::post('/combo/truck/update/{id}', [TruckController::class, 'update'])->name('combo.truck.update');
            Route::get('/combo/truck/delete/{id}', [TruckController::class, 'destroy'])->name('combo.truck.delete');

            //search loads
            Route::get('/combo/search-loads', [SearchLoadsController::class, 'search_loads'])->name('combo.search_loads');
            Route::get('/combo/book-loads/{id}', [SearchLoadsController::class, 'bookLoad'])->name('combo.book_load');
            Route::get('/combo/bid-loads/{id}', [SearchLoadsController::class, 'bidLoad'])->name('combo.bid_load');
            Route::get('/combo/private-leads', [SearchLoadsController::class, 'privateLeads'])->name('combo.private_leads');

            //My Loads
            Route::get('/combo/my-loads-open', [MyLoadsController::class, 'myloads'])->name('combo.my_loads');
            Route::get('/combo/my-loads-active', [MyLoadsController::class, 'my_loads_active'])->name('combo.my_loads_active');
            Route::get('/combo/my-loads-history', [MyLoadsController::class, 'my_loads_history'])->name('combo.my_loads_history');
            Route::get('/combo/my-loads-overview/{id}', [MyLoadsController::class, 'my_loads_overview'])->name('combo.my_loads_overview');
            Route::get('/combo/my-loads-bid-activity/{id}', [MyLoadsController::class, 'my_loads_bid_activity'])->name('combo.my_loads_bid_activity');
            Route::get('/combo/my-loads-requests-activity/{id}', [MyLoadsController::class, 'my_loads_requests_activity'])->name('combo.my_loads_requests_activity');
            Route::get('/combo/my-loads-status-tracking/{id}', [MyLoadsController::class, 'my_loads_status_tracking'])->name('combo.my_loads_status_tracking');
            Route::get('/combo/my-loads-tracking/{id}', [MyLoadsController::class, 'my_loads_tracking'])->name('combo.my_loads_tracking');
            Route::post('/combo/my-loads-update-tracking/{id}', [MyLoadsController::class, 'my_loads_update_tracking'])->name('combo.my_loads_update_tracking');
            Route::get('/combo/delete-a-shipment/{id}', [PostAShipmentController::class, 'delete_a_shipment'])->name('combo.delete_a_shipment');
            Route::get('/combo/borker-details/{id}', [MyShipmentController::class, 'carrierDetail'])->name('combo.broker_details');
        });
        
        //my-plans
        Route::get('/combo/my-payment-methods', [MyPlansController::class, 'addCard'])->name('combo.add_card');
        Route::post('/combo/my-plans', [MyPlansController::class, 'myPlans'])->name('combo.my_plans');
        Route::get('/combo/payment-profile/{id}', [MyPlansController::class, 'getCustomerPaymentProfile'])->name('combo.payment_profile');
        Route::get('/combo/payment-profile-delete/{id}', [MyPlansController::class, 'deleteCustomerPaymentProfile'])->name('combo.delete_customer_payment_profile');
        Route::get('/combo/payment-profile-auto/{id}', [MyPlansController::class, 'autoCustomerPaymentProfile'])->name('combo.auto_customer_payment_profile');
        Route::get('/combo/get-states/{id}', [BillingController::class, 'getStates'])->name('get.states');
        Route::get('/combo/get-cities/{stateId}', [BillingController::class, 'getCities']);

        //combo Profile
        Route::post('/combo/update_profile', [UserProfileController::class, 'update_profile'])->name('combo.update_profile');
        Route::post('/combo/update_company_profile', [UserProfileController::class, 'update_company_profile'])->name('combo.update_company_profile');
        
        Route::get('/combo/user-profile', [UserProfileController::class, 'user_profile'])->name('combo.user_profile');
        Route::post('/combo/change-password', [UserProfileController::class, 'changePassword'])->name('combo.change_password');
        Route::get('/combo/company-profile', [UserProfileController::class, 'user_company_profile'])->name('combo.user_company_profile');
        Route::post('/combo/update-user-subscription', [UserManagementController::class, 'updateSubscriptionFromCustomerProfile'])->name('combo.update_user_subscription');
        Route::get('/combo/update-subscription', [HomeController::class, 'updateSubscription'])->name('combo.update_subscription');
        Route::get('/combo/contact-owner', [HomeController::class, 'contactOwner'])->name('combo.contact_owner');

    });

    //update subscription

    //global chat system
    Route::post('/send-message/{id}', [ChatController::class, 'sendMessage'])->name('send_message');
    Route::get('/notification_redirect/{notification_id}', [PushNotificationController::class, 'notification_redirect'])->name('notification_redirect');
    Route::get('/dissmiss_all_notifications', [PushNotificationController::class, 'dissmiss_all_notifications'])->name('dissmiss_all_notifications');

});
