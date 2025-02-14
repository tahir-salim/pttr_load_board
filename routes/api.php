<?php

use App\Http\Controllers\API\ChatController;
use App\Http\Controllers\API\FeedbackController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\AdvertisementController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\SearchController;
use App\Http\Controllers\API\ShipmentController;
use App\Http\Controllers\API\TruckController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\NotificationController;
use App\Models\Tracking;
use App\Http\Controllers\API\InvoiceController;
use App\Http\Controllers\API\ServicesController;
use App\Http\Controllers\API\ShopController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
 */
Route::post('register', [RegisterController::class, 'register']);

Route::post('login', [LoginController::class, 'login']);
Route::get('/send-otp/{user_id}/{pass}', [LoginController::class, 'sendOtp'])->name('send_otp');
Route::get('/resend-otp/{user_id}', [LoginController::class, 'resendOtp'])->name('resend_otp');
Route::post('/otp-verify', [LoginController::class, 'otpVerify'])->name('otp_verify');
Route::post('/forget-password', [LoginController::class, 'forgetPassword']);
Route::post('/set-password', [LoginController::class, 'setPassword']);


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/trucker/tracking-request/{id}', [ShipmentController::class, 'tracking_request']);
Route::post('/shipment/status-update/{shipment_id}', [ShipmentController::class, 'shipmentStatusUpdate']);

Route::get('/trucker/services', [ServicesController::class, 'servicesList']);
Route::get('/trucker/services-categories/{id}', [ServicesController::class, 'serviceCategoriesList']);
Route::get('/trucker/services-category-items', [ServicesController::class, 'servicesCategoryItems']);
Route::post('/trucker/cities', [SearchController::class, 'cities']);
        
        
        
Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('api-check-subscription')->group(function () {
        //truck
        Route::post('/trucker/truck/create', [TruckController::class, 'createTruck']);
        Route::get('/trucker/trucks', [TruckController::class, 'truckList']);
        Route::post('/trucker/truck/update/{truck_id}', [TruckController::class, 'truckUpdate']);
        Route::post('/trucker/truck/delete/{truck_id}', [TruckController::class, 'truckDelete']);

        
        //Post
        Route::post('/trucker/posttrucks/create', [TruckController::class, 'truckPostCreate']);
        Route::get('/trucker/posttrucks', [TruckController::class, 'truckPostList']);
        Route::post('/trucker/posttrucks/update/{truck_post_id}', [TruckController::class, 'truckPostUpdate']);
        Route::post('/trucker/posttrucks/delete/{truck_post_id}', [TruckController::class, 'truckPostDelete']);
        Route::post('/trucker/posttrucks/posted/{truck_post_id}', [TruckController::class, 'truckStatusPosted']);
        Route::post('/trucker/quick-rate-lookup', [TruckController::class, 'QuickRateLookup']);


        //search
        Route::post('/trucker/search', [SearchController::class, 'search']);
        Route::get('/trucker/recent-search', [SearchController::class, 'recentSearch']);
        Route::get('/trucker/delete-recent-search/{id}', [SearchController::class, 'deleteRecentSearch']);
        Route::get('/trucker/equipment-types', [SearchController::class, 'equipmentTypes']);
        
        Route::get('/trucker/states', [SearchController::class, 'states']);

        //shipment
        Route::get('/shipment', [ShipmentController::class, 'shipment']);
        Route::get('/trucker/private-loads', [ShipmentController::class, 'private_loads']);

        Route::get('/shipment/detail/{shipment_id}', [ShipmentController::class, 'shipmentDetail']);
        Route::get('/trucker/shipment-request-activity', [ShipmentController::class, 'shipment_request_activity']);
        Route::get('/trucker/bid-request-activity', [ShipmentController::class, 'bid_request_activity']);
        Route::post('/trucker/shimpnet-request', [ShipmentController::class, 'shimpnet_request']);

        Route::get('/trucker/notifications', [NotificationController::class, 'notifications']);
        Route::get('/trucker/notification-clear-all', [NotificationController::class, 'notification_clear_all']);
        Route::get('/trucker/notification-delete/{id}', [NotificationController::class, 'notification_delete']);
        Route::get('/trucker/notification_read/{id}', [NotificationController::class, 'notification_read']);

        //feedback
        Route::post('/feedback', [FeedbackController::class, 'feedback']);
    
        // Rating
        Route::post('/create-rating/{company_id}', [FeedbackController::class, 'create_rating']);

        //chat
        Route::post('/send-message/{id}', [ChatController::class, 'sendMessage'])->name('send_message');

        // Tracking

        Route::post('/trucker/tracking-status-update/{id}', [ShipmentController::class, 'tracking_status_update']);

        //invoice
        Route::post('/trucker/invoice/create', [InvoiceController::class, 'createInvoice']);
        Route::get('/trucker/invoice', [InvoiceController::class, 'invoiceList']);
        Route::get('/trucker/invoice/{invoice_id}', [InvoiceController::class, 'invoiceDetail']);

        //Ship
        Route::post('/trucker/shipment-saved/createOrupdate', [ShipmentController::class, 'shipment_saved_update']);
        Route::get('/trucker/shipment-saved', [ShipmentController::class, 'shipment_saved_list']);

        Route::post('/trucker/advertisement', [AdvertisementController::class, 'advertisement']);
        Route::get('/trucker/shops', [ShopController::class, 'shopList']);

        Route::post('/trucker/save-token', [App\Http\Controllers\API\BaseController::class, 'saveToken'])->name('save_token');
    });
//profile
    Route::get('/trucker/profile', [ProfileController::class, 'truckerProfile']);
    Route::post('/trucker/profile/update', [ProfileController::class, 'truckerProfileUpdate']);
    Route::get('/trucker/logout', [LoginController::class, 'logout']);
    Route::post('/trucker/delete-fcm-token', [LoginController::class, 'delete_fcm_token']);

});
