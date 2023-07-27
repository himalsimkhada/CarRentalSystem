<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\CompanyAuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingTypeController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CarImageController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompanyCredentialController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PartnerReqController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserCredentialController;
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
Route::get('/car/category/{type_id}', [PagesController::class, 'getCategory'])->name('car.category');
Route::get('/car/list', [PagesController::class, 'car_list'])->name('cars.list');
Route::get('/car/list/hightolow', [PagesController::class, 'car_list'])->name('car.list.pricedesc');
Route::get('/car/list/lowtohigh', [PagesController::class, 'car_list'])->name('car.list.priceasc');
Route::post('/car/list/location', [PagesController::class, 'car_list'])->name('car.list.location');
Route::get('/car/list/category/{type_id}/hightolow', [PagesController::class, 'getCategory'])->name('car.list.category.pricedesc');
Route::get('/car/list/category/{type_id}/lowtohigh', [PagesController::class, 'getCategory'])->name('car.list.category.priceasc');
Route::post('/car/list/category/{type_id}/location', [PagesController::class, 'getCategory'])->name('car.list.category.location');
Route::get('/car/detail', [PagesController::class, 'show'])->name('car.detail');
Route::get('/contactus', [ContactUsController::class, 'create'])->name('contactus.create');
Route::post('/contactus/post', [ContactUsController::class, 'store'])->name('contactus.post');
Route::get('/partner/create', [PartnerReqController::class, 'create'])->name('partner-req.create');
Route::post('/partner/store', [PartnerReqController::class, 'store'])->name('partner-req.store');
Route::view('/faqs', 'faqs')->name('faqs');

//group routes for admin pages
Route::middleware(['auth', 'user_type:1'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/car', [CarController::class, 'index'])->name('admin.index.car');
    Route::get('/admin/car/{id}', [CarController::class, 'destroy'])->name('admin.delete.car');
    Route::get('/admin/company', [CompanyController::class, 'index'])->name('admin.index.company');
    Route::get('/admin/company/create', [CompanyController::class, 'create'])->name('admin.create.company');
    Route::post('/admin/company/store', [CompanyController::class, 'store'])->name('admin.store.company');
    Route::get('/admin/company/edit/{id}', [CompanyController::class, 'edit'])->name('admin.edit.company');
    Route::post('/admin/company/update', [CompanyController::class, 'update'])->name('admin.update.company');
    Route::get('/admin/company/{id}', [CompanyController::class, 'destroy'])->name('admin.delete.company');
    Route::get('/admin/user', [UserController::class, 'index'])->name('admin.index.user');
    Route::get('/admin/user/{id}', [UserController::class, 'destroy'])->name('admin.delete.user');
    Route::get('/admin/type', [BookingTypeController::class, 'index'])->name('admin.index.type');
    Route::get('/admin/type/create', [BookingTypeController::class, 'create'])->name('admin.create.type');
    Route::post('/admin/type/store', [BookingTypeController::class, 'store'])->name('admin.store.type');
    Route::get('/admin/type/edit/{id}', [BookingTypeController::class, 'edit'])->name('admin.edit.type');
    Route::post('/admin/type/update', [BookingTypeController::class, 'update'])->name('admin.update.type');
    Route::get('/admin/type/delete/{id}', [BookingTypeController::class, 'destroy'])->name('admin.delete.type');
    Route::get('/admin/notifications', [NotificationController::class, 'index'])->name('admin.notification');
    Route::get('/admin/request/partner', [PartnerReqController::class, 'index'])->name('admin.index.partner-req');
    Route::get('/admin/company/request/approve/{id}', [PartnerReqController::class, 'approve'])->name('admin.approve.partner');
    Route::get('/admin/company/request/deny/{id}', [PartnerReqController::class, 'deny'])->name('admin.deny.partner');
    Route::get('/admin/messages', [ContactUsController::class, 'index'])->name('admin.messages');
});

//group routes for company pages
Route::middleware('auth:company')->group(function () {
    Route::get('/company/dashboard', [CompanyController::class, 'dashboard'])->name('company.dashboard');
    Route::get('/company/car', [CarController::class, 'index'])->name('company.index.car');
    Route::get('/company/car/create', [CarController::class, 'create'])->name('company.create.car');
    Route::post('/company/car/store', [CarController::class, 'store'])->name('company.store.car');
    Route::get('/company/car/edit/{id}', [CarController::class, 'edit'])->name('company.edit.car');
    Route::post('/company/car/update', [CarController::class, 'update'])->name('company.update.car');
    Route::get('/company/car/delete/{id}', [CarController::class, 'destroy'])->name('company.delete.car');
    Route::post('/company/car/image', [CarImageController::class, 'store'])->name('company.car.store.image');
    Route::get('/company/booking', [BookingController::class, 'index'])->name('company.index.booking');
    Route::get('/company/booking/srt/paid', [BookingController::class, 'index'])->name('company.index.booking.paid');
    Route::get('/company/booking/srt/unpaid', [BookingController::class, 'index'])->name('company.index.booking.unpaid');
    Route::get('/company/booking/show/{id}', [BookingController::class, 'show'])->name('company.show.booking');
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
    Route::get('/company/notifications', [NotificationController::class, 'index'])->name('company.notification');
    Route::get('/company/messages', [ContactUsController::class, 'index'])->name('company.messages');
    Route::post('/company/contact/customer/{id}/{user_id}', [ContactUsController::class, 'emailCustomer'])->name('company.support.customer');
});

//group routes for user pages
Route::middleware(['auth', 'user_type:3'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/booking/book/searched', [BookingController::class, 'storeFromIndex'])->name('user.car.book.index');
    Route::post('/booking/book/list', [BookingController::class, 'storeFromList'])->name('user.car.book.list');
    Route::get('/user/booking', [BookingController::class, 'index'])->name('user.index.booking');
    Route::get('/user/booking/srt/paid', [UserController::class, 'reservation'])->name('user.reservation.paid.srt');
    Route::get('/user/booking/srt/unpaid', [UserController::class, 'reservation'])->name('user.reservation.unpaid.srt');
    Route::get('/user/booking/delete/{id}', [BookingController::class, 'destroy'])->name('user.delete.booking');
    Route::post('/user/edit/password/check', [UserController::class, 'password'])->name('password.change');
    Route::get('/user/profile/credential', [UserCredentialController::class, 'index'])->name('user.index.credential');
    Route::get('/user/profile/credential/create', [UserCredentialController::class, 'create'])->name('user.create.credential');
    Route::post('/user/profile/credential/store', [UserCredentialController::class, 'store'])->name('user.store.credential');
    Route::get('/user/profile/credential/edit/{id}', [UserCredentialController::class, 'edit'])->name('user.edit.credential');
    Route::post('/user/profile/credential/update', [UserCredentialController::class, 'update'])->name('user.update.credential');
    Route::get('/user/profile/credential/delete/{id}', [UserCredentialController::class, 'destroy'])->name('user.delete.credential');
    Route::get('/user/booking/payment', [PaymentController::class, 'handlePayment'])->name('paypal.make.payment');
    Route::get('/user/booking/payment/success/{id}', [PaymentController::class, 'paymentSuccess'])->name('paypal.success.payment');
    Route::get('/user/booking/payment/cancel', [PaymentController::class, 'paymentCancel'])->name('paypal.cancel.payment');
    Route::get('/user/notifications', [NotificationController::class, 'index'])->name('user.notification');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/user/profile/{id}', [UserController::class, 'edit'])->name('user.edit.profile');
    Route::post('/user/profile/update', [UserController::class, 'update'])->name('user.update.profile');
    Route::post('/user/profile/update/picture', [UserController::class, 'updatePicture'])->name('user.update.picture');

    Route::get('/user/booking', [BookingController::class, 'index'])->name('user.index.booking');
    Route::get('/user/booking/show/{id}', [BookingController::class, 'show'])->name('user.show.booking');
});

Route::middleware('auth:web,company')->group(function () {
    Route::post('/notification/mark-as-read', [NotificationController::class, 'markNotification'])->name('notification.mark-as-read');
    Route::get('/notification/count/unread', [NotificationController::class, 'getUnreadNotificationCount'])
        ->name('notification.count.unread');
});
