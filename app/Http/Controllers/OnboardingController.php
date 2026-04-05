<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OnboardingController extends Controller
{
    private const STEPS = [
        'account' => 'Account',
        'company' => 'Company',
        'goal' => 'Goal',
        'address' => 'Address',
    ];

    public function showStep(Request $request, ?string $step = null): View|RedirectResponse
    {
        $currentStep = $this->normalizeStep($step);
        $stepNames = array_keys(self::STEPS);
        $currentStepIndex = array_search($currentStep, $stepNames, true);
        $previousStep = $currentStepIndex > 0 ? $stepNames[$currentStepIndex - 1] : null;
        $data = $request->session()->get('onboarding.form', []);

        return view('onboarding.index', [
            'currentStep' => $currentStep,
            'currentStepIndex' => $currentStepIndex,
            'previousStep' => $previousStep,
            'stepLabels' => self::STEPS,
            'data' => $data,
        ]);
    }

    public function submitStep(Request $request, string $step): RedirectResponse
    {
        $currentStep = $this->normalizeStep($step);
        $stepNames = array_keys(self::STEPS);
        $currentStepIndex = array_search($currentStep, $stepNames, true);
        $submittedData = $request->except(['_token']);
        $storedData = array_merge($request->session()->get('onboarding.form', []), $submittedData);
        $request->session()->put('onboarding.form', $storedData);

        if ($currentStepIndex < count($stepNames) - 1) {
            return redirect()->route('onboarding.step', ['step' => $stepNames[$currentStepIndex + 1]]);
        }

        $request->session()->forget('onboarding.form');

        return redirect()
            ->route('onboarding.success')
            ->with('onboarding_submitted', $storedData);
    }

    public function success(Request $request): View|RedirectResponse
    {
        $submittedData = $request->session()->get('onboarding_submitted');
        if (!$submittedData) {
            return redirect()->route('onboarding.step', ['step' => 'account']);
        }

        return view('onboarding.success', [
            'data' => $submittedData,
        ]);
    }

    private function normalizeStep(?string $step): string
    {
        if (!$step || !array_key_exists($step, self::STEPS)) {
            return 'account';
        }

        return $step;
    }
}
