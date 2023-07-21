<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\CompanyAuthController;
use App\Http\Controllers\BookingTypeController;
use App\Http\Controllers\CarImageController;
use App\Http\Controllers\CompanyCredentialController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PartnerReqController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserCredentialController;

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


Route::get('/phpinfo', function () {
    return phpinfo();
});

Auth::routes();

Route::get('/company/login', [CompanyAuthController::class, 'showLoginForm'])->name('company.login.page');
Route::post('/company/login', [CompanyAuthController::class, 'login'])->name('company.login');
Route::get('/company/logout', [CompanyAuthController::class, 'logout'])->name('company.logout');

//routes for global pages
Route::get('/', [PagesController::class, 'index'])->name('index');
Route::get('/listing', [PagesController::class, 'listing'])->name('listing');
Route::get('/car/category/{type_id}', [CarController::class, 'getCategory'])->name('car.category');
Route::get('/car/list', [PagesController::class, 'car_list'])->name('cars.list');
Route::get('/car/list/hightolow', [PagesController::class, 'car_list'])->name('car.list.pricedesc');
Route::get('/car/list/lowtohigh', [PagesController::class, 'car_list'])->name('car.list.priceasc');
Route::post('/car/list/location', [PagesController::class, 'car_list'])->name('car.list.location');
Route::get('/car/list/category/{type_id}/hightolow', [CarController::class, 'getCategory'])->name('car.list.category.pricedesc');
Route::get('/car/list/category/{type_id}/lowtohigh', [CarController::class, 'getCategory'])->name('car.list.category.priceasc');
Route::post('/car/list/category/{type_id}/location', [CarController::class, 'getCategory'])->name('car.list.category.location');
Route::get('/car/detail', [CarController::class, 'getDetail'])->name('car.detail');
Route::get('/contactus', [ContactUsController::class, 'index'])->name('contactus');
Route::post('/contactus/post', [ContactUsController::class, 'store'])->name('contactus.post');
Route::view('/faqs', 'faqs')->name('faqs');

//group routes for admin pages
Route::middleware(['auth', 'user_type:1'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/car', [CarController::class, 'index'])->name('admin.index.car');
    Route::get('/admin/car/{id}', [CarController::class, 'destroy'])->name('admin.delete.car');
    Route::get('/admin/company', [CompanyController::class, 'index'])->name('admin.index.company');
    Route::get('/admin/company/create', [CompanyController::class, 'create'])->name('admin.create.company');
    Route::post('/admin/company/store', [CompanyController::class, 'store'])->name('admin.store.company');
    Route::get('/admin/company/edit/{id}', [CompanyController::class, 'edit'])->name('admin.edit.company');
    Route::post('/admin/company/update', [CompanyController::class, 'update'])->name('admin.update.company');
    Route::get('/admin/company/{id}', [CompanyController::class, 'destroy'])->name('admin.delete.company');
    Route::get('/admin/user', [UserController::class, 'index'])->name('admin.user.list');
    Route::get('/admin/user/{id}', [UserController::class, 'destroy'])->name('admin.delete.user');
    Route::get('/admin/reservations', [AdminController::class, 'reservations'])->name('admin.list.reservations');
    Route::get('/admin/type', [BookingTypeController::class, 'index'])->name('admin.list.type');
    Route::get('/admin/type/create', [BookingTypeController::class, 'create'])->name('admin.create.type');
    Route::post('/admin/type/store', [BookingTypeController::class, 'store'])->name('admin.store.type');
    Route::get('/admin/type/edit/{id}', [BookingTypeController::class, 'edit'])->name('admin.edit.type');
    Route::post('/admin/type/update', [BookingTypeController::class, 'update'])->name('admin.update.type');
    Route::get('/admin/type/delete/{id}', [BookingTypeController::class, 'destroy'])->name('admin.delete.type');
    Route::get('/admin/lastest/notifications', [NotificationController::class, 'notification'])->name('admin.notification');
    Route::post('/admin/mark-as-read', [NotificationController::class, 'markNotification'])->name('admin.markNotification');
    Route::get('/admin/company/requests', [PartnerReqController::class, 'adminReq'])->name('admin.request');
    Route::get('/admin/company/request/approve/{r_id}', [PartnerReqController::class, 'approved'])->name('admin.req.approve');
    Route::get('/admin/company/request/deny/{deny_id}', [PartnerReqController::class, 'denied'])->name('admin.req.deny');
    Route::get('/admin/messages', [ContactUsController::class, 'adminSupport'])->name('admin.messages');
});

//group routes for company pages
Route::middleware('auth:company')->group(function () {
    Route::get('/company/dashboard', [CompanyController::class, 'dashboard'])->name('company.dashboard');
    Route::get('/company/car', [CarController::class, 'index'])->name('company.index.car');
    Route::get('/company/car/create', [CarController::class, 'create'])->name('company.create.car');
    Route::post('/company/car/store', [CarController::class, 'store'])->name('company.store.car');
    Route::get('/company/car/edit/{id}', [CarController::class, 'edit'])->name('company.edit.car');
    Route::post('/company/car/update', [CarController::class, 'update'])->name('company.update.car');
    Route::get('/company/car/{id}', [CarController::class, 'destroy'])->name('company.delete.car');
    Route::post('/company/car/image', [CarImageController::class, 'store'])->name('company.car.store.image');
    Route::get('/company/reservations', [CompanyController::class, 'reservations'])->name('company.list.reservations');
    Route::get('/company/reservations/srt/paid', [CompanyController::class, 'reservations'])->name('company.list.reservations.paid');
    Route::get('/company/reservations/srt/unpaid', [CompanyController::class, 'reservations'])->name('company.list.reservations.unpaid');
    Route::get('/company/reservation-detail', [CompanyController::class, 'reservation_details'])->name('company.reservation.detail');
    Route::get('/company/profile/edit/{id}', [CompanyController::class, 'edit'])->name('company.edit.profile');
    Route::post('/company/profile/update', [CompanyController::class, 'update'])->name('company.update.profile');
    Route::get('/company/location', [LocationController::class, 'index'])->name('company.index.location');
    Route::get('/company/location/create', [LocationController::class, 'create'])->name('company.create.location');
    Route::post('/company/location/store', [LocationController::class, 'store'])->name('company.store.location');
    Route::get('/company/location/edit/{id}', [LocationController::class, 'edit'])->name('company.edit.location');
    Route::post('/company/location/update', [LocationController::class, 'update'])->name('company.update.location');
    Route::get('/company/location/{id}', [LocationController::class, 'destroy'])->name('company.delete.location');
    Route::get('/company/profile/credential', [CompanyCredentialController::class, 'index'])->name('company.index.credential');
    Route::get('/company/profile/credential/create', [CompanyCredentialController::class, 'create'])->name('company.create.credential');
    Route::post('/company/profile/credential/store', [CompanyCredentialController::class, 'store'])->name('company.store.credential');
    Route::get('/company/profile/credential/edit/{id}', [CompanyCredentialController::class, 'edit'])->name('company.edit.credential');
    Route::post('/company/profile/credential/update', [CompanyCredentialController::class, 'update'])->name('company.update.credential');
    Route::get('/company/profile/credential/delete/{id}', [CompanyCredentialController::class, 'destroy'])->name('company.delete.credential');
    Route::get('/company/lastest/notifications', [NotificationController::class, 'companyNotifications'])->name('company.notification');
    Route::post('/company/mark-as-read', [NotificationController::class, 'markNotification'])->name('company.markNotification');
    Route::get('/company/messages', [ContactUsController::class, 'companySupport'])->name('company.messages');
    Route::post('/company/contact/customer/{id}/{user_id}', [ContactUsController::class, 'emailCustomer'])->name('company.support.customer');
});

//group routes for user pages
Route::middleware(['auth', 'user_type:3'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/booking/book/searched', [BookingController::class, 'storeFromIndex'])->name('user.car.book.index');
    Route::post('/booking/book/list', [BookingController::class, 'storeFromList'])->name('user.car.book.list');
    Route::get('/user/reservation', [UserController::class, 'reservation'])->name('user.reservation');
    Route::get('/user/reservation/paidsrt', [UserController::class, 'reservation'])->name('user.reservation.paid.srt');
    Route::get('/user/reservation/unpaidsrt', [UserController::class, 'reservation'])->name('user.reservation.unpaid.srt');
    Route::get('/user/reservation/delete/{id}', [BookingController::class, 'destroy'])->name('user.reservation.delete');
    Route::post('/user/edit/password/check', [UserController::class, 'password'])->name('password.change');
    Route::get('/user/profile/credential', [UserCredentialController::class, 'index'])->name('user.index.credential');
    Route::get('/user/profile/credential/create', [UserCredentialController::class, 'create'])->name('user.create.credential');
    Route::post('/user/profile/credential/store', [UserCredentialController::class, 'store'])->name('user.store.credential');
    Route::get('/user/profile/credential/edit/{id}', [UserCredentialController::class, 'edit'])->name('user.edit.credential');
    Route::post('/user/profile/credential/update', [UserCredentialController::class, 'update'])->name('user.update.credential');
    Route::get('/user/profile/credential/delete/{id}', [UserCredentialController::class, 'destroy'])->name('user.delete.credential');
    Route::get('/user/reservation/payment/paid', [PaymentController::class, 'store'])->name('payment.paid');
    Route::get('/user/req/company', [PartnerReqController::class, 'index'])->name('req.partnership');
    Route::post('user/req/company/store', [PartnerReqController::class, 'store'])->name('req.partnership.store');
    Route::get('/user/lastest/notifications', [NotificationController::class, 'userNotifications'])->name('user.notification');
    Route::post('/user/mark-as-read', [NotificationController::class, 'markNotification'])->name('user.markNotification');
});

Route::middleware(['auth', 'user_type:1,3'])->group(function () {
    Route::get('/user/profile/{id}', [UserController::class, 'edit'])->name('user.edit.profile');
    Route::post('/user/profile/update', [UserController::class, 'update'])->name('user.update.profile');
    Route::post('/user/profile/update/picture', [UserController::class, 'updatePicture'])->name('user.update.picture');
});

// Route::middleware(['auth', 'auth:company'])->group(function () {
//     Route::get('/user/profile/{id}', [UserController::class, 'edit'])->name('user.edit.profile');
//     Route::post('/user/profile/update', [UserController::class, 'update'])->name('user.update.profile');
//     Route::post('/user/profile/update/picture', [UserController::class, 'updatePicture'])->name('user.update.picture');
// });
