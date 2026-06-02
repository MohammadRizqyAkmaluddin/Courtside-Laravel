<?php

use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\LookupController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserAuthController;
use App\Http\Controllers\Api\VenueAuthController;
use App\Http\Controllers\Api\VenueController;
use App\Http\Controllers\Api\CourtAvailabilityController;
use App\Http\Controllers\Api\BookingHoldController;
use App\Http\Controllers\Api\CommunityController;
use App\Http\Controllers\Api\CSM\CourtBookingController;
use App\Http\Controllers\Api\CSM\CourtController;
use App\Http\Controllers\Api\CSM\EmployeeController;
use App\Http\Controllers\Api\CSM\FinanceController;
use App\Http\Controllers\Api\CSM\SettingController;
use App\Http\Controllers\Api\CSM\StoreProductController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\CSM\VenueManagementController;
use Illuminate\Http\Request;

Route::get('/test', function () {
    return 'API OK';
});

Route::get('sport-types', [LookupController::class, 'sportType']);
Route::get('court-types', [LookupController::class, 'courtType']);
Route::get('court-material', [LookupController::class, 'courtMaterial']);
Route::get('cities', [LookupController::class, 'city']);
Route::get('venues', [VenueController::class, 'index']);
Route::get('venues/{venue}', [VenueController::class, 'show']);
Route::get('communities', [CommunityController::class, 'index']);
Route::get('suggestion/{community}', [CommunityController::class, 'suggestion']);
Route::get('communities/{community}', [CommunityController::class, 'show']);

Route::post('/booking-holds/{id}/pay', [BookingHoldController::class, 'createPayment']);

Route::post('/midtrans/callback', [BookingHoldController::class, 'handle']);

Route::get('/booking-holds/{id}', [BookingHoldController::class, 'show']);

Route::post('/booking-holds/guest', [BookingHoldController::class, 'storeGuest']);

Route::get('/profile', [UserAuthController::class, 'profile']);

Route::post('/booking-holds/cancel', [BookingHoldController::class, 'cancel']);

Route::get('/courts/{court}/availability', [CourtAvailabilityController::class, 'show']);
Route::get('/courts/{court}/availability/month', [CourtAvailabilityController::class, 'month']);
Route::get('courts/{court}/availability/day', [CourtAvailabilityController::class, 'day']);
Route::get('courts/{court}/availability/additional', [CourtAvailabilityController::class, 'courtAdditional']);

Route::prefix('auth/venue')->group(function () {
    Route::post('register', [VenueAuthController::class, 'register']);
    Route::post('login', [VenueAuthController::class, 'login']);
});

Route::prefix('auth/user')->group(function () {
    Route::post('register', [UserAuthController::class, 'register']);
    Route::post('login', [UserAuthController::class, 'login']);
});

Route::post('/community/store', [CommunityController::class, 'store']);


// Route::middleware('auth:sanctum')->get('auth/venue/me', [VenueManagementController::class, 'me']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('auth/user/me', function (Request $request) {
        return response()->json([
            'user' => $request->user()
        ]);
    });

    Route::get('/my-activity/booking-holds', [ActivityController::class, 'myActiveHolds']);
    Route::get('/my-activity/active-booking', [ActivityController::class, 'getActiveBookings']);
    Route::get('/my-activity/booking-history', [ActivityController::class, 'history']);
    Route::get('/my-activity/community-membership', [ActivityController::class, 'myMembership']);
    Route::get('/my-activity/level', [ActivityController::class, 'level']);
    Route::post('/my-activity/{community}/leave-community', [ActivityController::class, 'leaveCommunity']);

    Route::post('/my-activity/rate', [RatingController::class, 'store']);

    Route::post('/booking-holds/auth', [BookingHoldController::class, 'storeAuth']);
    Route::post('/booking-holds/auth/check', [BookingHoldController::class, 'check']);


    Route::get('/venue/booking-index', [VenueManagementController::class, 'bookingIndex']);
    Route::get('/income', [FinanceController::class, 'income']);
    Route::get('/balance', [FinanceController::class, 'balance']);
    Route::get('/bank-account', [FinanceController::class, 'bankAccount']);
    Route::post('/change-bank-account', [FinanceController::class, 'changeBankAccount']);
    Route::get('/main-bank-account', [FinanceController::class, 'mainBankAccount']);
    Route::post('/withdraw', [FinanceController::class, 'withdraw']);
    Route::get('/pending-exists', [FinanceController::class, 'pendingExists']);
    Route::post('/cancel-request', [FinanceController::class, 'cancelRequest']);
    Route::post('/add-account', [FinanceController::class, 'addBankAccount']);
    Route::get('/wd-history', [FinanceController::class, 'indexWithdraw']);
    Route::get('/income/monthly', [FinanceController::class, 'getMonthlyIncome']);
    Route::get('/income/breakdown', [FinanceController::class, 'courtIncomeBreakdown']);
    Route::get('/income/productIncome', [FinanceController::class, 'overallProductIncome']);

    Route::get('/store/product', [StoreProductController::class, 'indexProduct']);
    Route::post('/store/addProduct', [StoreProductController::class, 'addProduct']);
    Route::post('/store/addStock', [StoreProductController::class, 'addStock']);
    Route::post('/store/changePrice', [StoreProductController::class, 'changePrice']);
    Route::post('/store/removeProduct', [StoreProductController::class, 'removeProduct']);

    Route::get('/store/indexCart', [StoreProductController::class, 'indexCart']);
    Route::post('/store/addToCart', [StoreProductController::class, 'addToCart']);
    Route::post('/store/removeCart', [StoreProductController::class, 'removeCart']);
    Route::post('/store/createTransaction', [StoreProductController::class, 'createTransaction']);

    Route::get('/booking/index', [CourtBookingController::class, 'index']);
    Route::get('/booking/todayBooking', [CourtBookingController::class, 'todayBooking']);
    Route::get('/booking/upcomingBooking', [CourtBookingController::class, 'upcomingBooking']);
    Route::post('/booking/cancelBooking', [CourtBookingController::class, 'cancelBooking']);
    Route::post('/booking/rejectCancel', [CourtBookingController::class, 'rejectCancel']);
    Route::get('/venue/indexCourt', [CourtBookingController::class, 'indexCourt']);
    Route::get('/booking/cancelRequest', [CourtBookingController::class, 'cancelRequest']);
    Route::get('/booking/cancelRequestMobile', [CourtBookingController::class, 'cancelRequestMobile']);
    Route::get('/booking/cancelDetail', [CourtBookingController::class, 'cancelDetail']);
    Route::post('/booking/manualBooking', [CourtBookingController::class, 'bookingHold']);
    Route::get('/booking/paymentSummary', [CourtBookingController::class, 'paymentSummary']);
    Route::post('/booking/cancelPayment', [CourtBookingController::class, 'cancelPayment']);
    Route::post('/booking/pay', [CourtBookingController::class, 'pay']);


    Route::get('/auth/venue/me', [VenueManagementController::class, 'me']);
    Route::get('/auth/venue', [VenueManagementController::class, 'auth']);

    Route::get('/auth/detail', [VenueManagementController::class, 'meDetail']);
    Route::get('/auth/venueImages', [VenueManagementController::class, 'venueImages']);
    Route::get('/auth/operationalHour', [VenueManagementController::class, 'operationHours']);
    Route::get('/auth/facility', [VenueManagementController::class, 'facility']);


    Route::get('/employee/indexEmployee', [EmployeeController::class, 'indexEmployee']);
    Route::get('/employee/getPositions', [EmployeeController::class, 'getPositions']);
    Route::get('/employee/employeeSummary', [EmployeeController::class, 'employeeSummary']);
    Route::post('/employee/addEmployee', [EmployeeController::class, 'addEmployee']);
    Route::post('/employee/editPosition', [EmployeeController::class, 'editPosition']);
    Route::post('/employee/editSalary', [EmployeeController::class, 'editSalary']);

    Route::get('/court/indexCourt', [CourtController::class, 'indexCourt']);
    Route::get('/court/{court}', [CourtController::class, 'showCourt']);
    Route::post('/court/addCourt', [CourtController::class, 'addCourt']);

    Route::post('/setting/editName', [SettingController::class, 'editName']);
    Route::post('/setting/editAddress', [SettingController::class, 'editAddress']);
    Route::post('/setting/editDescription', [SettingController::class, 'editDescription']);
    Route::post('/setting/editRules', [SettingController::class, 'editRules']);
    Route::post('/setting/editPhone', [SettingController::class, 'editPhone']);
    Route::post('/setting/removeFacility', [SettingController::class, 'removeFacility']);
    Route::post('/setting/addFacility', [SettingController::class, 'addFacility']);
    Route::post('/setting/addImage', [SettingController::class, 'addImage']);
    Route::post('/setting/setPrimary', [SettingController::class, 'setPrimary']);
    Route::post('/setting/removeImage', [SettingController::class, 'removeImage']);

    Route::post('/setting/editOperationalHour', [SettingController::class, 'editOperationalHour']);
    Route::post('/setting/setOpen', [SettingController::class, 'setOpen']);
    Route::post('/setting/setClose', [SettingController::class, 'setClose']);
    Route::post('/setting/setTime', [SettingController::class, 'setTime']);

    Route::post('/setting/changeEmail', [SettingController::class, 'changeEmail']);
    Route::post('/setting/changePassword', [SettingController::class, 'changePassword']);

    Route::post('/setting/accountStatus', [SettingController::class, 'accountStatus']);
});
