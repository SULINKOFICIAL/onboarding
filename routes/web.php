<?php

use App\Http\Controllers\OnboardingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('onboarding.step', ['step' => 'account']);
});

Route::prefix('onboarding')->group(function () {
    Route::get('/step/{step?}', [OnboardingController::class, 'showStep'])->name('onboarding.step');
    Route::post('/step/{step}', [OnboardingController::class, 'submitStep'])->name('onboarding.submit');
    Route::get('/success', [OnboardingController::class, 'success'])->name('onboarding.success');
});
