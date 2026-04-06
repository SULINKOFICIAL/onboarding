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

    public function show(Request $request): View
    {
        $data = $request->session()->get('onboarding.form', []);

        return view('onboarding.index', [
            'data' => $data,
        ]);
    }

    public function submit(Request $request): RedirectResponse
    {
        $sessionStep = $request->session()->get('onboarding.current_step');
        $currentStep = $this->normalizeStep($request->input('current_step', $sessionStep));
        $navigation = $request->input('navigation', 'next');

        $submittedData = $request->except(['_token', 'current_step', 'navigation']);
        $storedData = array_merge($request->session()->get('onboarding.form', []), $submittedData);
        $request->session()->put('onboarding.form', $storedData);

        if ($navigation === 'back') {
            $request->session()->put('onboarding.current_step', $this->getPreviousStep($currentStep) ?? $currentStep);

            return redirect()->route('onboarding.show');
        }

        $nextStep = $this->getNextStep($currentStep);
        if ($nextStep) {
            $request->session()->put('onboarding.current_step', $nextStep);

            return redirect()->route('onboarding.show');
        }

        $request->session()->forget('onboarding.form');
        $request->session()->forget('onboarding.current_step');

        return redirect()
            ->route('onboarding.success')
            ->with('onboarding_submitted', $storedData);
    }

    public function success(Request $request): View|RedirectResponse
    {
        $submittedData = $request->session()->get('onboarding_submitted');
        if (!$submittedData) {
            return redirect()->route('onboarding.show');
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

    private function getStepNames(): array
    {
        return array_keys(self::STEPS);
    }

    private function getStepIndex(string $step): int
    {
        return array_search($step, $this->getStepNames(), true);
    }

    private function getPreviousStep(string $currentStep): ?string
    {
        $currentStepIndex = $this->getStepIndex($currentStep);
        if ($currentStepIndex <= 0) {
            return null;
        }

        return $this->getStepNames()[$currentStepIndex - 1];
    }

    private function getNextStep(string $currentStep): ?string
    {
        $currentStepIndex = $this->getStepIndex($currentStep);
        $stepNames = $this->getStepNames();
        if ($currentStepIndex >= count($stepNames) - 1) {
            return null;
        }

        return $stepNames[$currentStepIndex + 1];
    }
}
