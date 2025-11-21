<?php

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

use Illuminate\Support\Facades\Route;
use Workdo\Paystack\Http\Controllers\PaystackController;

Route::prefix('paystack')->middleware('web')->group(function () {

    Route::middleware(['auth', 'verified'])->group(function () {
        // Setting
        Route::post('/setting/store', [PaystackController::class, 'settingConfig'])->name('paystack.setting.store')->middleware('PlanModuleCheck:Paystack');

        // Plan
        Route::post('plan-pay-with/paystack', [PaystackController::class, 'planPayWithPaystack'])->name('plan.pay.with.paystack');
        Route::get('plan-get-payment-status/', [PaystackController::class, 'planGetPaystackStatus'])->name('plan.get.paystack.status');
    });

    // Appointment
    Route::post('appointment-pay-with-paystack', [PaystackController::class, 'appointmentPayWithPaystack'])->name('appointment.pay.with.paystack');
    Route::get('appointment-pay-paystack-status/{slug}', [PaystackController::class, 'getAppointmentPaymentStatus'])->name('appointment.paystack.status');
});