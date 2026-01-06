<?php

use App\Http\Controllers\Frontend\AdController;
use App\Http\Controllers\Frontend\MemberAuthController;
use App\Http\Controllers\Frontend\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'homePage'])->name('home');

//Auth Routes
Route::get('/member/login', [MemberAuthController::class, 'memberLoginPage'])->name('member.login');
Route::post('/member/login', [MemberAuthController::class, 'memberLogin'])->name('member.login.submit');
Route::get('/member/register', [MemberAuthController::class, 'memberRegisterPage'])->name('member.register');
Route::post('/member/register', [MemberAuthController::class, 'memberRegister'])->name('member.register.submit');
Route::get('/member/logout', [MemberAuthController::class, 'memberLogout'])->name('member.logout');
Route::get('forgot-password', [MemberAuthController::class, 'forgotPasswordPage'])->name('member.forgot.password');
Route::post('forgot-password', [MemberAuthController::class, 'forgotPassword'])->name('member.forgot.password.submit');

//Ad Routes
Route::get('/post/ad', [AdController::class, 'addPostPage'])->name('ad.post.page');
Route::get('/ad/details/{slug}', [AdController::class, 'adDetailsPage'])->name('ad.details.page');

require __DIR__.'/admin.php';
