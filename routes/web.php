<?php

use App\Http\Controllers\Authentication\LoginController as AuthenticationLoginController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\Payments\paymentController;
use App\Http\Controllers\Start\LandingPageController;
use App\Http\Controllers\transferController;
use App\Http\Controllers\Transfers\LocalBankController;
use App\Http\Controllers\Transfers\OwnAccountController;
use App\Http\Controllers\Transfers\SameBankController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [LandingPageController::class, 'index'])->name('starter');

Route::get('/login', [AuthenticationLoginController::class, 'login'])->name('login');

Route::get('/reset-password', [loginController::class, 'reset_password'])->name('reset-password');

Route::get('/forget-password', [loginController::class, 'forget_password'])->name('forget-password');


// Transfer Routes
// Route::get('/transfer', [transferController::class, 'transfer'])->name('transfer');
Route::get('/add-beneficiary', [transferController::class, 'add_beneficiary'])->name('add-beneficiary');
Route::get('/add-beneficiary/own-account-beneficiary', [transferController::class, 'own_account_beneficiary'])->name('own-account-beneficiary');
Route::get('/add-beneficiary/same-bank-beneficiary', [transferController::class, 'same_bank_beneficiary'])->name('same-bank-beneficiary');
Route::get('/add-beneficiary/local-bank-beneficiary', [transferController::class, 'local_bank'])->name('local-bank-beneficiary');
Route::get('/add-beneficiary/international-bank-beneficiary', [transferController::class, 'international_bank'])->name('international-bank-beneficiary');


// OWN ACCOUNT
Route::get('/own-account', [OwnAccountController::class, 'own_account'])->name('own-account');
Route::post('/submit-own-account-transfer', [OwnAccountController::class, 'submit_own_account_transfer'])->name('submit-own-account-transfer');

// SAME ACCOUNT
Route::get('/same-bank', [SameBankController::class, 'same_bank'])->name('same-bank');


// LOCAL BANK
Route::get('/other-local-bank', [LocalBankController::class, 'other_local_bank'])->name('other-local-bank');



Route::get('/international-bank', [transferController::class, 'international_bank_'])->name('international-bank');


// PAYMENTS ROUTES
Route::get('/payment-add-beneficiary', [paymentController::class, 'add_beneficiary'])->name('payment-add-beneficiary');
Route::get('/payment-add-beneficiary/mobile-money-beneficiary', [paymentController::class, 'mobile_money_beneficiary'])->name('mobile-money-beneficiary');
Route::get('/payment-add-beneficiary/utility-payment-beneficiary', [paymentController::class, 'utility_payment_beneficiary'])->name('utility-payment-beneficiary');

// SAVED BENEFICIARY
Route::get('/saved-beneficiary', [paymentController::class, 'saved_beneficiary'])->name('saved-beneficiary');



// Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
