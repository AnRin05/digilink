<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PassengerHistoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DriverHistoryController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SystemFeedbackController;
use Illuminate\Support\Facades\DB;

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

// Public routes for home page, choice, and login/signup
Route::get('/', function () {
    return view('index');
})->name('home');
// Page for driver or passenger choice
Route::get('/choice', function () {
    return view('choice'); 
})->name('choice');

// Report Routes
Route::post('/report/urgent-help', [ReportController::class, 'sendUrgentHelp'])->name('report.urgent.help');
Route::post('/report/complaint', [ReportController::class, 'sendComplaint'])->name('report.complaint');

Route::middleware(['auth:passenger,driver'])->group(function () {
    Route::get('/feedback', [SystemFeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [SystemFeedbackController::class, 'store'])->name('feedback.store');
    Route::get('/feedback/thank-you', [SystemFeedbackController::class, 'thankYou'])->name('feedback.thank-you');
});
// Passenger Signup Routes
Route::get('/passign', [PassengerController::class, 'create'])->name('passign');
Route::post('/passenger/signup', [PassengerController::class, 'store'])->name('passenger.signup');

// Driver Signup Routes
Route::get('/driversign', [DriverController::class, 'create'])->name('driversign');
Route::post('/driver/signup', [DriverController::class, 'store'])->name('driver.signup');

// Login routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Passenger Routes
Route::prefix('passenger')->group(function () {
    Route::get('/dashboard', [PassengerController::class, 'dashboard'])->name('passenger.dashboard');
    Route::get('/edit', [PassengerController::class, 'edit'])->name('passenger.edit');
    Route::put('/update', [PassengerController::class, 'update'])->name('passenger.update');
    Route::delete('/delete', [PassengerController::class, 'destroy'])->name('passenger.delete');

    Route::post('/book-ride', [PassengerController::class, 'bookRide'])->name('passenger.book.ride');
    Route::get('/available-drivers', [PassengerController::class, 'getAvailableDrivers'])->name('passenger.available.drivers');
    Route::get('/delivery', [PassengerController::class, 'delivery'])->name('passenger.delivery');
    Route::get('/available-delivery-drivers', [PassengerController::class, 'getAvailableDeliveryDrivers'])->name('passenger.available.delivery.drivers');

    Route::get('/pending-bookings', [PassengerController::class, 'pendingBookings'])->name('passenger.pending.bookings');
    Route::get('/get-pending-bookings', [PassengerController::class, 'getPendingBookings'])->name('passenger.get.pending.bookings');
    Route::post('/cancel-booking/{id}', [PassengerController::class, 'cancelBooking'])->name('passenger.cancel.booking');
    Route::get('/edit-booking/{id}', [PassengerController::class, 'editBooking'])->name('passenger.edit.booking');
    Route::post('/cancel-ongoing-booking/{id}', [PassengerController::class, 'cancelOngoingBooking'])->name('passenger.cancel.ongoing.booking'); // NEW ROUTE
    Route::get('/edit-booking/{id}', [PassengerController::class, 'editBooking'])->name('passenger.edit.booking');
    Route::put('/update-booking/{id}', [PassengerController::class, 'updateBooking'])->name('passenger.update.booking');

    Route::get('/track-booking/{id}', [PassengerController::class, 'trackBooking'])->name('passenger.track.booking');
    Route::get('/get-booking-location/{id}', [PassengerController::class, 'getBookingLocation'])->name('passenger.get.booking.location');
    Route::post('/confirm-completion/{id}', [PassengerController::class, 'confirmCompletion'])->name('passenger.confirm.completion');
    Route::get('/get-driver-location/{id}', [PassengerController::class, 'getDriverLocation'])->name('passenger.get.driver.location');

    Route::get('/history', [PassengerHistoryController::class, 'index'])->name('passenger.history');
    Route::get('/get-history', [PassengerHistoryController::class, 'getHistory'])->name('passenger.get.history');
    Route::delete('/delete-history/{id}', [PassengerHistoryController::class, 'deleteFromHistory'])->name('passenger.delete.history');
    Route::post('/submit-rating', [RatingController::class, 'submitRating'])->name('passenger.submit.rating');
    Route::get('/check-rating-eligibility/{id}', [RatingController::class, 'checkRatingEligibility'])
    ->name('passenger.check-rating-eligibility');
    Route::get('/trip-completed/{id}', [PassengerController::class, 'tripCompleted'])->name('passenger.trip.completed');
});

// Driver Routes
Route::prefix('driver')->group(function () {
    Route::get('/dashboard', [DriverController::class, 'dashboard'])->name('driver.dashboard');
    Route::get('/edit', [DriverController::class, 'edit'])->name('driver.edit');
    Route::get('/pending', [DriverController::class, 'pending'])->name('driver.pending');
    Route::get('/waiting', [DriverController::class, 'waiting'])->name('driver.waiting');
    Route::put('/update', [DriverController::class, 'update'])->name('driver.update');
    Route::put('/update-availability', [DriverController::class, 'updateAvailability'])->name('driver.update.availability');
    Route::get('/booking-stats', [DriverController::class, 'getBookingStats'])->name('driver.booking.stats');
    Route::delete('/delete', [DriverController::class, 'destroy'])->name('driver.delete');

    Route::get('/available-bookings', [DriverController::class, 'availableBookings'])->name('driver.availableBookings');
    Route::get('/get-available-bookings', [DriverController::class, 'getAvailableBookings'])->name('driver.getAvailableBookings');
    Route::get('/booking-details/{id}', [DriverController::class, 'getBookingDetails'])->name('driver.bookingDetails');
    Route::post('/accept-booking/{id}', [DriverController::class, 'acceptBooking'])->name('driver.accept.booking');
    Route::post('/driver/update-location', [DriverController::class, 'updateLocation'])->name('driver.update.location');
    Route::put('/driver/update-currentlocation', [DriverController::class, 'updateCurrentLocation'])->name('driver.updateCurrentLocation');
    Route::get('/driver/today-stats', [DriverController::class, 'getTodayStats'])->name('driver.getTodayStats');

    
    Route::get('/get-accepted-bookings', [DriverController::class, 'getAcceptedBookings'])->name('driver.getAcceptedBookings');
    Route::post('/start-job/{id}', [DriverController::class, 'startJob'])->name('driver.start.job');
    Route::get('/job-tracking/{id}', [DriverController::class, 'jobTracking'])->name('driver.job.tracking');
    Route::post('/update-location', [DriverController::class, 'updateLocation'])->name('driver.update.location');
    Route::get('/can-start-job/{id}', [DriverController::class, 'canStartJob'])->name('driver.can.start.job');
    Route::post('/cancel-accepted-booking/{id}', [DriverController::class, 'cancelAcceptedBooking'])->name('driver.cancel.accepted.booking');
    Route::post('/confirm-completion/{id}', [DriverController::class, 'confirmCompletion'])->name('driver.confirm.completion');
    Route::get('/get-booking-status/{id}', [DriverController::class, 'getBookingStatus'])->name('driver.get.booking.status');
    
    Route::get('/history', [DriverHistoryController::class, 'index'])->name('driver.history');
    Route::get('/get-history', [DriverHistoryController::class, 'getHistory'])->name('driver.get.history');
    Route::delete('/delete-history/{id}', [DriverHistoryController::class, 'deleteFromHistory'])->name('driver.delete.history');
    Route::get('/get-booking-status/{id}', [DriverController::class, 'getBookingStatus'])->name('driver.get.booking.status');
    Route::get('/notifications', [DriverController::class, 'getNotifications'])->name('driver.get.notifications');
    Route::post('/notifications/{id}/read', [DriverController::class, 'markNotificationAsRead'])->name('driver.notifications.read');
    
    Route::get('/rating', [DriverController::class, 'seeRating'])->name('driver.rating');
    Route::get('/rating-data', [DriverController::class, 'seeRatingData'])->name('driver.rating.data');
});

//  Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/passengers', [AdminController::class, 'passengers'])->name('admin.passengers');
    Route::get('/passengers/{id}', [AdminController::class, 'showPassenger'])->name('admin.passenger.show');
    Route::delete('/passengers/{id}', [AdminController::class, 'deletePassenger'])->name('admin.passenger.delete');
    Route::get('/drivers', [AdminController::class, 'drivers'])->name('admin.drivers');
    Route::get('/drivers/{id}', [AdminController::class, 'showDriver'])->name('admin.driver.show');
    Route::post('/drivers/{id}/approve', [AdminController::class, 'approveDriver'])->name('admin.driver.approve');
    Route::post('/drivers/{id}/reject', [AdminController::class, 'rejectDriver'])->name('admin.driver.reject');
    Route::delete('/drivers/{id}', [AdminController::class, 'deleteDriver'])->name('admin.driver.delete');

    Route::get('/analytics', [AdminController::class, 'analytics'])->name('admin.analytics');
    Route::get('/bookings-current', [AdminController::class, 'currentBookings'])->name('admin.bookings.current');
    Route::get('/bookings-completed', [AdminController::class, 'completedBookings'])->name('admin.bookings.completed');
    Route::get('/bookings-cancelled', [AdminController::class, 'cancelledBookings'])->name('admin.bookings.cancelled');
    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
    Route::get('/reports/{id}', [AdminController::class, 'showReport'])->name('admin.reports.show');
    Route::put('/reports/{id}', [AdminController::class, 'updateReport'])->name('admin.reports.update');
    Route::get('/reports-count', [AdminController::class, 'getReportsCount'])->name('admin.reports.count');
    Route::get('/notifications', [AdminController::class, 'notifications'])->name('admin.notifications');

    Route::get('/ongoing-bookings/{type}/{id}', [AdminController::class, 'viewOngoingBookings'])->name('admin.ongoing.bookings');
    Route::get('/view-completed-bookings/{type}/{id}', [AdminController::class, 'viewCompletedBookings'])->name('admin.view.completed.bookings');
    Route::get('/view-cancelled-bookings/{type}/{id}', [AdminController::class, 'viewCancelledBookings'])->name('admin.view.cancelled.bookings');

    Route::get('/booking-tracking/{id}', [AdminController::class, 'trackBooking'])->name('admin.booking.tracking');
    Route::get('/get-driver-location/{id}', [AdminController::class, 'getDriverLocation'])->name('admin.get-driver-location');
    Route::get('/feedback', [SystemFeedbackController::class, 'index'])->name('admin.feedback.index');
    Route::get('/feedback/{feedback}', [SystemFeedbackController::class, 'show'])->name('admin.feedback.show');
    Route::get('/feedback-analytics', [SystemFeedbackController::class, 'analytics'])->name('admin.feedback.analytics');
});
