<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OnboardingController extends Controller
{
    public function showStep(Request $request, int $step = 1): View|RedirectResponse
    {
        $step = $this->normalizeStep($step);
        $data = $request->session()->get('onboarding.form', []);

        return view('onboarding.form', [
            'step' => $step,
            'data' => $data,
        ]);
    }

    public function submitStep(Request $request, int $step): RedirectResponse
    {
        $step = $this->normalizeStep($step);
        $submittedData = $request->except(['_token']);
        $storedData = array_merge($request->session()->get('onboarding.form', []), $submittedData);
        $request->session()->put('onboarding.form', $storedData);

        if ($step < 4) {
            return redirect()->route('onboarding.step', ['step' => $step + 1]);
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
            return redirect()->route('onboarding.step', ['step' => 1]);
        }

        return view('onboarding.success', [
            'data' => $submittedData,
        ]);
    }

    private function normalizeStep(int $step): int
    {
        return max(1, min(4, $step));
    }
}
