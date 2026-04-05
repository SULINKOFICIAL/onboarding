<?php

use App\Http\Controllers\OnboardingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('onboarding.show');
});

Route::get('/onboarding', [OnboardingController::class, 'show'])->name('onboarding.show');
Route::post('/onboarding', [OnboardingController::class, 'submit'])->name('onboarding.submit');
Route::get('/onboarding/success', [OnboardingController::class, 'success'])->name('onboarding.success');
