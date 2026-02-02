<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\AdController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\LocationController;
use App\Http\Controllers\Frontend\MemberAuthController;

Route::get('/', [PageController::class, 'homePage'])->name('home');

//Auth Routes
Route::group(['middleware' => ['guest']], function () {
    Route::get('/member/login', [MemberAuthController::class, 'memberLoginPage'])->name('member.login');
    Route::post('/member/login', [MemberAuthController::class, 'loginAttempt'])->name('member.login.attempt');
    Route::get('/member/register', [MemberAuthController::class, 'memberRegisterPage'])->name('member.register');
    Route::post('/member/register', [MemberAuthController::class, 'memberRegister'])->name('member.register.submit');

    Route::get('forgot-password', [MemberAuthController::class, 'forgotPasswordPage'])->name('member.forgot.password');
    Route::post('forgot-password', [MemberAuthController::class, 'forgotPassword'])->name('member.forgot.password.submit');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/member/logout', [MemberAuthController::class, 'memberLogout'])->name('member.logout');
    Route::get('/member/dashboard', [MemberAuthController::class, 'memberDashboard'])->name('member.dashboard');
});

//Ad Routes
Route::get('/post/ad', [AdController::class, 'addPostPage'])->name('ad.post.page');
Route::post('/post/ad', [AdController::class, 'storeAd'])->name('ad.store');
Route::get('/ad/subcategories', [AdController::class, 'getSubcategories'])->name('ad.subcategories');
Route::get('/ad/custom-fields', [AdController::class, 'getCustomFields'])->name('ad.custom.fields');
Route::get('listings/{category_slug?}', [AdController::class, 'adListingPage'])->name('ad.listing.page');
Route::get('/ad/details/{slug}', [AdController::class, 'adDetailsPage'])->name('ad.details.page');
Route::post('/ad/details/{slug}', [AdController::class, 'adDetailsPage'])->name('ad.details.page');

//Location Routes
Route::get('/state/list', [LocationController::class, 'stateListofCountry'])->name('location.country.states.options');
Route::get('/city/list', [LocationController::class, 'cityListofState'])->name('location.state.cities.options');

require __DIR__ . '/admin.php';
