<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use App\Services\CentralApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;

class OnboardingController extends Controller
{
    private const DEFAULT_STEP = 'account';
    private const STEPS = [
        'account' => 'Account',
        'company' => 'Company',
        'goal' => 'Goal',
        'address' => 'Address',
    ];

    public function __construct(
        private readonly CentralApiService $centralApiService
    ) {}

    /**
     * Exibe o formulário de onboarding com os dados salvos em sessão.
     * Mantém preenchimento parcial quando o usuário retorna para a página.
     */
    public function show(Request $request): View
    {
        $data = $request->session()->get('onboarding.form', []);

        return view('onboarding.index', [
            'data' => $data,
            'states' => State::where('status', 1)
                ->orderBy('name')
                ->get(['id', 'name', 'acronym']),
        ]);
    }

    /**
     * Processa a navegação do formulário e persiste dados em sessão.
     * Finaliza fluxo quando não houver próximo passo disponível.
     */
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

    /**
     * Exibe tela de sucesso somente quando houver dados recém enviados.
     * Evita acesso direto à página final sem passar pelo fluxo.
     */
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

    /**
     * Consulta na central se já existe cliente com o e-mail informado.
     * Retorna payload padrão para consumo da validação front-end.
     */
    public function checkEmail(Request $request): JsonResponse
    {
        $payload = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        return $this->checkIdentityInCentral(
            ['email' => $payload['email']],
            'Falha ao consultar email na central durante onboarding.',
            ['email' => $payload['email']]
        );
    }

    /**
     * Consulta na central se já existe cliente com CPF ou CNPJ informado.
     * Normaliza apenas números antes de enviar para a API da central.
     */
    public function checkDocument(Request $request): JsonResponse
    {
        $payload = $request->validate([
            'type' => ['required', 'in:cpf,cnpj'],
            'value' => ['required', 'string'],
        ]);

        $documentType = $payload['type'];
        $documentValue = preg_replace('/\D+/', '', $payload['value']);

        return $this->checkIdentityInCentral(
            [
                'document_type' => $documentType,
                $documentType => $documentValue,
            ],
            'Falha ao consultar documento na central durante onboarding.',
            [
                'document_type' => $documentType,
                'document_value' => $documentValue,
            ]
        );
    }

    public function saveStep(Request $request): JsonResponse
    {
        $payload = $request->validate([
            'step' => ['required', 'in:account,company,goal,address'],
        ]);

        return $this->forwardOnboardingPayload(
            'save',
            $request->except(['_token']),
            'Falha ao salvar etapa do onboarding na central.',
            [
                'step' => $payload['step'],
            ]
        );
    }

    public function finalize(Request $request): JsonResponse
    {
        return $this->forwardOnboardingPayload(
            'finalize',
            $request->except(['_token']),
            'Falha ao finalizar onboarding na central.'
        );
    }

    public function resolveLocation(Request $request): JsonResponse
    {
        $payload = $request->validate([
            'state_id' => ['required', 'integer', 'exists:states,id'],
            'city' => ['required', 'string', 'max:255'],
        ]);

        $cityName = Str::lower(Str::ascii($payload['city']));
        $cities = City::where('state_id', $payload['state_id'])
            ->where('status', 1)
            ->get(['id', 'name']);

        $city = $cities->first(function ($cityItem) use ($cityName) {
            return Str::lower(Str::ascii($cityItem->name)) === $cityName;
        });

        if (!$city) {
            return response()->json([
                'success' => false,
                'message' => 'Cidade não encontrada na base local.',
            ], 422);
        }

        return response()->json([
            'success' => true,
            'company_state_id' => $payload['state_id'],
            'company_city_id' => $city->id,
        ]);
    }

    /**
     * Normaliza o passo atual para garantir valor válido no fluxo.
     * Aplica fallback para o passo inicial quando entrada for inválida.
     */
    private function normalizeStep(?string $step): string
    {
        if (!$step || !array_key_exists($step, self::STEPS)) {
            return self::DEFAULT_STEP;
        }

        return $step;
    }

    /**
     * Retorna lista de chaves dos passos na ordem de navegação.
     * Centraliza referência da sequência usada pelo formulário.
     */
    private function getStepNames(): array
    {
        return array_keys(self::STEPS);
    }

    /**
     * Obtém posição do passo na lista de navegação.
     * Assume passo já normalizado antes da chamada.
     */
    private function getStepIndex(string $step): int
    {
        return array_search($step, $this->getStepNames(), true);
    }

    /**
     * Retorna passo anterior quando existir posição válida.
     * Usado para navegação de retorno no formulário.
     */
    private function getPreviousStep(string $currentStep): ?string
    {
        $currentStepIndex = $this->getStepIndex($currentStep);
        if ($currentStepIndex <= 0) {
            return null;
        }

        return $this->getStepNames()[$currentStepIndex - 1];
    }

    /**
     * Retorna próximo passo disponível no fluxo de onboarding.
     * Retorna null quando o passo atual é o último da sequência.
     */
    private function getNextStep(string $currentStep): ?string
    {
        $currentStepIndex = $this->getStepIndex($currentStep);
        $stepNames = $this->getStepNames();
        if ($currentStepIndex >= count($stepNames) - 1) {
            return null;
        }

        return $stepNames[$currentStepIndex + 1];
    }

    /**
     * Consulta endpoint da central e converte resposta para payload padrão.
     * Trata indisponibilidade com retorno seguro para o front-end.
     */
    private function checkIdentityInCentral(
        array $payload,
        string $logMessage,
        array $logContext = []
    ): JsonResponse
    {
        if (!$this->centralApiService->hasConfiguredToken()) {
            Log::warning($logMessage, array_merge($logContext, [
                'error' => 'Token da central não configurado em CENTRAL_TOKEN.',
            ]));
            return $this->makeCheckResponse(false, false);
        }

        try {
            $response = $this->centralApiService->checkOnboardingIdentity($payload);

            if ($response->successful()) {
                $responseData = $response->json();
                // No front, "exists" representa bloqueio de continuidade.
                // A central define esse bloqueio com can_continue=false.
                $exists = !(bool) ($responseData['can_continue'] ?? true);

                return $this->makeCheckResponse($exists, true);
            }
        } catch (\Throwable $exception) {
            Log::warning($logMessage, array_merge($logContext, [
                'error' => $exception->getMessage(),
            ]));
        }

        return $this->makeCheckResponse(false, false);
    }

    private function forwardOnboardingPayload(
        string $operation,
        array $payload,
        string $logMessage,
        array $logContext = []
    ): JsonResponse {
        if (!$this->centralApiService->hasConfiguredToken()) {
            Log::warning($logMessage, array_merge($logContext, [
                'error' => 'Token da central não configurado em CENTRAL_TOKEN.',
            ]));

            return response()->json([
                'success' => false,
                'message' => 'Token da central não configurado.',
            ], 500);
        }

        try {
            $response = $operation === 'finalize'
                ? $this->centralApiService->finalizeOnboarding($payload)
                : $this->centralApiService->saveOnboardingStep($payload);

            if ($response->successful()) {
                return response()->json(array_merge(['success' => true], $response->json()));
            }

            return response()->json([
                'success' => false,
                'message' => (string) ($response->json('message') ?? 'Falha na integração com a central.'),
            ], $response->status());
        } catch (\Throwable $exception) {
            Log::warning($logMessage, array_merge($logContext, [
                'error' => $exception->getMessage(),
            ]));
        }

        return response()->json([
            'success' => false,
            'message' => 'Falha na integração com a central.',
        ], 500);
    }

    /**
     * Padroniza estrutura JSON de resposta das validações remotas.
     * Mantém contrato único esperado pelo JavaScript do onboarding.
     */
    private function makeCheckResponse(bool $exists, bool $checked): JsonResponse
    {
        return response()->json([
            'exists' => $exists,
            'checked' => $checked,
        ]);
    }
}
