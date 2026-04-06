<?php

use App\Http\Controllers\OnboardingController;
use Illuminate\Support\Facades\Route;

Route::get('/',                 [OnboardingController::class, 'show'])->name('onboarding.show');
Route::post('/',                [OnboardingController::class, 'submit'])->name('onboarding.submit');
Route::get('/success',          [OnboardingController::class, 'success'])->name('onboarding.success');
Route::get('/check-email',      [OnboardingController::class, 'checkEmail'])->name('onboarding.check-email');
Route::get('/check-document',   [OnboardingController::class, 'checkDocument'])->name('onboarding.check-document');
