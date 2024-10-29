<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::middleware('auth')->group(function () {
    Route::get('/noviciate', [HomeController::class, 'noviciate'])->name('noviciate');
    Route::get('/invite', [HomeController::class, 'invite'])->name('invite');
    Route::get('/team', [HomeController::class, 'team'])->name('team');
    Route::get('/system', [HomeController::class, 'system'])->name('system');
    Route::get('/user', [HomeController::class, 'user'])->name('user');
    Route::get('/asset', [HomeController::class, 'asset'])->name('asset');
    Route::get('/bank', [HomeController::class, 'bank'])->name('bank');
    Route::get('/detail', [HomeController::class, 'detail'])->name('detail');
    Route::get('/intro', [HomeController::class, 'intro'])->name('intro');
    Route::get('/information', [HomeController::class, 'information'])->name('information');
    Route::post('/information', [HomeController::class, 'informationUpdate'])->name('informationUpdate');
    Route::get('/sell', [HomeController::class, 'sell'])->name('sell');
    Route::post('/sell_now', [HomeController::class, 'sellNow'])->name('sellNow');
    Route::post('/sell', [HomeController::class, 'postSell'])->name('postSell');
    Route::get('/buy', [HomeController::class, 'buy'])->name('buy');
    Route::post('/buy', [HomeController::class, 'postBuy'])->name('postBuy');
    Route::post('/sell_update', [HomeController::class, 'sellUpdate'])->name('sellUpdate');
    Route::post('/delete_sell', [HomeController::class, 'deleteSell'])->name('deleteSell');
    Route::get('/cskh', [HomeController::class, 'cskh'])->name('cskh');
    Route::get('/hail', [HomeController::class, 'hail'])->name('hail');
    Route::get('/deposit', [HomeController::class, 'deposit'])->name('deposit');
    Route::post('/deposit', [HomeController::class, 'postDeposit'])->name('postDeposit');
    Route::post('/bank', [HomeController::class, 'postBank'])->name('postBank');
    Route::get('/withdraw', [HomeController::class, 'withdraw'])->name('withdraw');
    Route::post('/withdraw', [HomeController::class, 'postWithdraw'])->name('postWithdraw');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/buy_gifbox', [HomeController::class, 'buyGifbox'])->name('buyGifbox');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'postRegister'])->name('postRegister');
Route::post('/login', [AuthController::class, 'postLogin'])->name('postLogin');
