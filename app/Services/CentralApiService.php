<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class CentralApiService
{
    private const CHECK_IDENTITY_ENDPOINT = '/api/central/onboarding/verificar-identidade';
    private const SAVE_STEP_ENDPOINT = '/api/central/onboarding/salvar-etapa';
    private const FINALIZE_ENDPOINT = '/api/central/onboarding/finalizar';

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
     * Finaliza onboarding na central e dispara provisionamento.
     * Envia payload consolidado da última etapa.
     */
    public function finalizeOnboarding(array $payload): Response
    {
        return $this->post(self::FINALIZE_ENDPOINT, $payload);
    }

    /**
     * Executa requisição autenticada para a central.
     * Centraliza timeout e cabeçalhos padrão da integração.
     */
    private function post(string $endpointPath, array $payload): Response
    {
        return Http::baseUrl($this->getBaseUrl())
            ->withToken($this->getToken())
            ->acceptJson()
            ->timeout(6)
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
