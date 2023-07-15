<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\CarCompanyController;
use App\Http\Controllers\CarController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\AdminController;
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
use Illuminate\Support\Facades\Auth;

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

//routes for global pages
Route::get('/', [PagesController::class, 'index'])->name('index');
Route::get('/listing', [PagesController::class, 'listing'])->name('listing');
Route::get('/car/lists', [PagesController::class, 'car_list'])->name('cars.list');
Route::get('/car/detail', [CarController::class, 'getDetail'])->name('car.detail');
Route::get('/car/category/{type_id}', [CarController::class, 'getCategory'])->name('car.category');
Route::get('/contactus', [ContactUsController::class, 'index'])->name('contactus');
Route::post('/contactus/post', [ContactUsController::class, 'store'])->name('contactus.post');
Route::get('/car/list/hightolow', [PagesController::class, 'car_list'])->name('car.list.pricedesc');
Route::get('/car/list/lowtohigh', [PagesController::class, 'car_list'])->name('car.list.priceasc');
Route::post('/car/list/location', [PagesController::class, 'car_list'])->name('car.list.location');
Route::get('/car/list/category/{type_id}/hightolow', [CarController::class, 'getCategory'])->name('car.list.category.pricedesc');
Route::get('/car/list/category/{type_id}/lowtohigh', [CarController::class, 'getCategory'])->name('car.list.category.priceasc');
Route::post('/car/list/category/{type_id}/location', [CarController::class, 'getCategory'])->name('car.list.category.location');
Route::view('/faqs', 'faqs')->name('faqs');

//group routes for admin pages
Route::middleware(['auth', 'user_type:1'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/car', [AdminController::class, 'carList'])->name('admin.car.list');
    Route::get('/admin/company', [AdminController::class, 'companyList'])->name('admin.company.list');
    Route::get('/admin/user', [AdminController::class, 'userList'])->name('admin.user.list');
    Route::post('/admin/company', [CarCompanyController::class, 'store'])->name('admin.add.company');
    Route::get('/admin/car/{id}', [CarController::class, 'destroy'])->name('admin.delete.car');
    Route::get('/admin/user/{id}', [UserController::class, 'destroy'])->name('admin.delete.user');
    Route::get('/admin/companies/{id}', [CarCompanyController::class, 'destroy'])->name('admin.delete.company');
    Route::get('/admin/reservations', [AdminController::class, 'reservations'])->name('admin.list.reservations');
    Route::get('/admin/types', [BookingTypeController::class, 'index'])->name('admin.booking.types');
    Route::post('/admin/type/add', [BookingTypeController::class, 'store'])->name('admin.booking.type.add');
    Route::post('/admin/type/edit', [BookingTypeController::class, 'update'])->name('admin.booking.type.edit');
    Route::get('/admin/type/delete/{id}', [BookingTypeController::class, 'destroy'])->name('admin.booking.type.delete');
    Route::get('/admin/lastest/notifications', [NotificationController::class, 'notification'])->name('admin.notification');
    Route::post('/admin/mark-as-read', [NotificationController::class, 'markNotification'])->name('admin.markNotification');
    Route::get('/admin/company/requests', [PartnerReqController::class, 'adminReq'])->name('admin.requests');
    Route::get('/admin/company/request/approve/{r_id}', [PartnerReqController::class, 'approved'])->name('admin.req.approve');
    Route::get('/admin/company/request/deny/{deny_id}', [PartnerReqController::class, 'denied'])->name('admin.req.deny');
    Route::post('/admin/user/admin/add', [AdminController::class, 'addAdmin'])->name('admin.user.admin.add');
    Route::post('/admin/user/admin/edit', [AdminController::class, 'editAdmin'])->name('admin.user.admin.edit');
    Route::get('/admin/messages', [ContactUsController::class, 'adminSupport'])->name('admin.messages');
});

//group routes for company pages
Route::middleware(['auth', 'user_type:2'])->group(function () {
    Route::get('/company/dashboard', [CarCompanyController::class, 'index'])->name('company.dashboard');
    Route::get('/owner/dashboard', [UserController::class, 'index'])->name('owner.dashboard');
    Route::get('/company/car/list', [CarCompanyController::class, 'cars'])->name('company.car.list');
    Route::get('/company/car/add', [CarController::class, 'addview'])->name('company.add.car.view');
    Route::post('/company/car/store', [CarController::class, 'store'])->name('company.add.car');
    Route::get('/company/edit/car', [CarController::class, 'editCar'])->name('company.edit.view.car');
    Route::post('/company/car/edit', [CarController::class, 'edit'])->name('company.edit.car');
    Route::get('/company/car/{id}', [CarController::class, 'destroy'])->name('company.delete.car');
    Route::post('/company/car/image', [CarImageController::class, 'store'])->name('company.car.store.image');
    Route::get('/company/reservations', [CarCompanyController::class, 'reservations'])->name('company.list.reservations');
    Route::get('/company/reservations/srt/paid', [CarCompanyController::class, 'reservations'])->name('company.list.reservations.paid');
    Route::get('/company/reservations/srt/unpaid', [CarCompanyController::class, 'reservations'])->name('company.list.reservations.unpaid');
    Route::get('/company/reservation-detail', [CarCompanyController::class, 'reservation_details'])->name('company.reservation.detail');
    Route::get('/user/profile/details', [UserController::class, 'editProfile'])->name('user.profile.edit');
    Route::post('/user/profile/edit', [UserController::class, 'update'])->name('user.profile.edited');
    Route::get('/company/profile/details', [CarCompanyController::class, 'editCompanyProfile'])->name('company.profile.edit');
    Route::post('/company/profile/edit', [CarCompanyController::class, 'update'])->name('company.profile.edited');
    Route::get('/company/location', [LocationController::class, 'index'])->name('company.locations');
    Route::post('/company/location/add', [LocationController::class, 'store'])->name('company.location.add');
    Route::post('/company/location/edited/{id}', [LocationController::class, 'update'])->name('company.location.edit');
    Route::get('/company/location/{id}', [LocationController::class, 'destroy'])->name('company.delete.location');
    Route::get('/company/profile/credentials', [CompanyCredentialController::class, 'index'])->name('company.credential');
    Route::post('/company/profile/credential/store', [CompanyCredentialController::class, 'store'])->name('company.store.credential');
    Route::post('/company/profile/credential/edit', [CompanyCredentialController::class, 'update'])->name('company.update.credential');
    Route::get('/company/profile/credential/delete/{id}', [CompanyCredentialController::class, 'destroy'])->name('company.delete.credential');
    Route::get('/company/lastest/notifications', [NotificationController::class, 'companyNotifications'])->name('company.notification');
    Route::post('/company/mark-as-read', [NotificationController::class, 'markNotification'])->name('company.markNotification');
    Route::get('/company/messages', [ContactUsController::class, 'companySupport'])->name('company.messages');
    Route::post('/company/contact/customer/{id}/{user_id}', [ContactUsController::class, 'emailCustomer'])->name('company.support.customer');
});

//group routes for user pages
Route::middleware(['auth', 'user_type:3'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/booking/book/searched', [BookingController::class, 'storeFromIndex'])->name('user.car.book.index');
    Route::post('/booking/book/list', [BookingController::class, 'storeFromList'])->name('user.car.book.list');
    Route::get('/user/reservation', [UserController::class, 'reservation'])->name('user.reservation');
    Route::get('/user/reservation/paidsrt', [UserController::class, 'reservation'])->name('user.reservation.paid.srt');
    Route::get('/user/reservation/unpaidsrt', [UserController::class, 'reservation'])->name('user.reservation.unpaid.srt');
    Route::get('/user/profile/details', [UserController::class, 'editProfile'])->name('user.profile.edit');
    Route::post('/user/profile/edit', [UserController::class, 'update'])->name('user.profile.edited');
    Route::post('/user/profile/edit/picture', [UserController::class, 'updatePicture'])->name('user.profile.pic.edited');
    Route::get('/user/reservation/delete/{id}', [BookingController::class, 'destroy'])->name('user.reservation.delete');
    Route::post('/user/edit/password/check', [UserController::class, 'password'])->name('password.change');
    Route::get('/user/profile/credentials', [UserCredentialController::class, 'index'])->name('user.credential');
    Route::post('/user/profile/credential/store', [UserCredentialController::class, 'store'])->name('user.store.credential');
    Route::post('/user/profile/credential/edit', [UserCredentialController::class, 'update'])->name('user.update.credential');
    Route::get('/user/profile/credential/delete/{id}', [UserCredentialController::class, 'destroy'])->name('user.delete.credential');
    Route::get('/user/reservation/payment/paid', [PaymentController::class, 'store'])->name('payment.paid');
    Route::get('/user/req/company', [PartnerReqController::class, 'index'])->name('req.partnership');
    Route::post('user/req/company/store', [PartnerReqController::class, 'store'])->name('req.partnership.store');
    Route::get('/user/lastest/notifications', [NotificationController::class, 'userNotifications'])->name('user.notification');
    Route::post('/user/mark-as-read', [NotificationController::class, 'markNotification'])->name('user.markNotification');
});
