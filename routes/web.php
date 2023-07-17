<?php

use App\Http\Controllers\C2CAuthController;
use App\Http\Controllers\C2CCrawlController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index']);
Route::post('/c2clogin', [C2CAuthController::class, 'login'])->name('c2c.login');
Route::post('/c2ccrawl', [C2CCrawlController::class, 'crawl'])->name('c2c.crawl');
Route::post('/c2cparsePhones', [C2CCrawlController::class, 'parsePhones'])->name('c2c.parsePhones');
