<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\AdController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\LocationController;
use App\Http\Controllers\Frontend\MemberAuthController;
use App\Http\Controllers\Frontend\MessageController;

Route::get('/', [PageController::class, 'homePage'])->name('home');
Route::get('/pricing-plans', [PageController::class, 'pricingPlans'])->name('pricing.plans');

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
    Route::get('/member/my-listings', [AdController::class, 'myListings'])->name('member.my.listings');
    Route::get('/member/ad/edit/{uid}', [AdController::class, 'editAd'])->name('member.ad.edit');
    Route::post('/member/ad/update/{uid}', [AdController::class, 'updateAd'])->name('member.ad.update');

    // Favourites
    Route::post('/ad/favourite/toggle', [AdController::class, 'toggleFavourite'])->name('ad.favourite.toggle');
    Route::get('/member/favourites', [AdController::class, 'myFavourites'])->name('member.favourites');

    // Messaging
    Route::get('/member/messages', [MessageController::class, 'index'])->name('member.messages.index');
    Route::get('/member/messages/{uid}', [MessageController::class, 'show'])->name('member.messages.show');
    Route::post('/member/messages/start', [MessageController::class, 'start'])->name('member.messages.start');
    Route::post('/member/messages/{uid}/send', [MessageController::class, 'sendMessage'])->name('member.messages.send');
});

//Listing Routes
Route::get('/post/listing', [AdController::class, 'addPostPage'])->name('ad.post.page');
Route::post('/post/ad', [AdController::class, 'storeAd'])->name('ad.store');
Route::get('/ad/subcategories', [AdController::class, 'getSubcategories'])->name('ad.subcategories');
Route::get('/ad/custom-fields', [AdController::class, 'getCustomFields'])->name('ad.custom.fields');
Route::get('/ad/countries', [AdController::class, 'getCountries'])->name('ad.countries');
Route::get('/ad/states', [AdController::class, 'getStates'])->name('ad.states');
Route::get('/ad/cities', [AdController::class, 'getCities'])->name('ad.cities');
Route::get('listings/{category_slug?}', [AdController::class, 'adListingPage'])->name('ad.listing.page');
Route::get('/listings/details/{slug}', [AdController::class, 'adDetailsPage'])->name('ad.details.page');

//Location Routes
Route::get('/state/list', [LocationController::class, 'stateListofCountry'])->name('location.country.states.options');
Route::get('/city/list', [LocationController::class, 'cityListofState'])->name('location.state.cities.options');

require __DIR__ . '/admin.php';
