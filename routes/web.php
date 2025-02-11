<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AuthController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('guest.user')->group(function () {
    Route::get('/', [AuthController::class, 'getLoginPage'])->name('login');
    Route::post('/', [AuthController::class, 'postLoginPage'])->name('post.login');
});

Route::get('forget-password',[AuthController::class, 'getForgotPasswordPage'])->name('forget-password');

Route::middleware('auth.user')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route::get('/dashboard-1', [DashboardController::class, 'index2'])->name('dashboard-2');
    Route::get('/logout', [DashboardController::class, 'logout'])->name('logout');
    
    Route::get('user/agreement/{doctor_id}', [DashboardController::class, 'getAgreementPage'])->name('agreement');
    Route::post('user/agreement/{doctor_id}', [DashboardController::class, 'storeAgreementData'])->name('post.agreement');
    Route::get('user/confirmation/{doctor_id}', [DashboardController::class, 'getConfirmationPage'])->name('confirmation');
    Route::post('user/confirmation/{doctor_id}', [DashboardController::class, 'storeConfirmationData'])->name('post.confirmation');
    Route::get('user/account-details/{doctor_id}', [DashboardController::class, 'getAccountDetailPage'])->name('accountDetail');
    Route::post('user/account-details/{doctor_id}', [DashboardController::class, 'storeAccountDetails'])->name('post.accountDetail');
    Route::get('user/survey/{doctor_id}',[DashboardController::class,'getSurveyPage'])->name('get.survey');
    Route::post('survey/store-answer', [DashboardController::class, 'storeAnswer'])->name('survey.storeAnswer');
    Route::post('user/survey/{doctor_id}',[DashboardController::class,'StoreSurveyData'])->name('post.survey');
    // Route::post('user/survey/{doctor_id}',[DashboardController::class,'StoreSurveyData'])->name('post.survey');
    Route::get('user/signature/{doctor_id}', [DashboardController::class, 'getSignaturePage'])->name('signature.page');
    Route::post('user/signature/{doctor_id}', [DashboardController::class, 'verifySignature'])->name('verify.signature');
    Route::get('user/verify-mobile/{doctor_id}', [DashboardController::class, 'getVerifyPage'])->name('verify.mobile');
    Route::post('user/verify-mobile/{doctor_id}', [DashboardController::class, 'verifyOTP'])->name('verify.otp');
    Route::get('user/survay-complete/{survey_id}/{doctor_id}', [DashboardController::class, 'getSurveyFinalPage'])->name('survey');
});

