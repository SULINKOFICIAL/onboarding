<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class CentralApiService
{
    private const CHECK_IDENTITY_ENDPOINT = '/api/central/onboarding/verificar-identidade';
    private const SAVE_STEP_ENDPOINT = '/api/central/onboarding/salvar-etapa';
    private const FINALIZE_ENDPOINT = '/api/central/onboarding/finalizar';
    private const PROVISION_ENDPOINT = '/api/central/onboarding/provisionar';
    private const DEFAULT_TIMEOUT_SECONDS = 6;
    private const FINALIZE_TIMEOUT_SECONDS = 30;
    private const PROVISION_TIMEOUT_SECONDS = 30;

    /**
     * Verifica se a autenticação da central foi configurada.
     * Evita chamadas HTTP sem token válido.
     */
    public function hasConfiguredToken(): bool
    {
        return $this->getToken() !== '';
    }

    /**
     * Consulta identidade de onboarding na central.
     * Repassa payload já validado pelo controller.
     */
    public function checkOnboardingIdentity(array $payload): Response
    {
        return $this->post(self::CHECK_IDENTITY_ENDPOINT, $payload);
    }

    /**
     * Salva etapa incremental de onboarding na central.
     * Mantém persistência parcial entre passos do formulário.
     */
    public function saveOnboardingStep(array $payload): Response
    {
        return $this->post(self::SAVE_STEP_ENDPOINT, $payload);
    }

    /**
     * Finaliza onboarding na central, criando os registros técnicos do tenant.
     * Retorna rápido; o provisionamento em si roda em passos via advanceProvisioning.
     */
    public function finalizeOnboarding(array $payload): Response
    {
        return $this->post(self::FINALIZE_ENDPOINT, $payload, self::FINALIZE_TIMEOUT_SECONDS);
    }

    /**
     * Avança uma etapa do provisionamento na central.
     * Consumido em polling curto pelo front até a instalação concluir.
     */
    public function advanceProvisioning(array $payload): Response
    {
        return $this->post(self::PROVISION_ENDPOINT, $payload, self::PROVISION_TIMEOUT_SECONDS);
    }

    /**
     * Executa requisição autenticada para a central.
     * Centraliza timeout e cabeçalhos padrão da integração.
     */
    private function post(string $endpointPath, array $payload, int $timeoutSeconds = self::DEFAULT_TIMEOUT_SECONDS): Response
    {
        return Http::baseUrl($this->getBaseUrl())
            ->withToken($this->getToken())
            ->acceptJson()
            ->timeout($timeoutSeconds)
            ->post($endpointPath, $payload);
    }

    /**
     * Obtém URL base da central vinda da configuração do projeto.
     * Remove barra final para manter concatenação consistente.
     */
    private function getBaseUrl(): string
    {
        return rtrim((string) config('services.core_business.url'), '/');
    }

    /**
     * Obtém token de autenticação para chamadas da central.
     * Mantém leitura encapsulada para simplificar manutenção.
     */
    private function getToken(): string
    {
        return (string) config('services.core_business.token', '');
    }
}
