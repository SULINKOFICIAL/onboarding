<h1 class="fs-2x fw-bolder mt-6 mb-10 me-md-13">
    Finalize seu cadastro com o endereco da empresa e comece a testar.
</h1>

<div class="mb-3">
    <label class="form-label text-gray-700 fw-bolder mb-0" for="company_zip_code">Qual o CEP da empresa?</label>
    <div class="position-relative">
        <input
            class="form-control pe-13"
            id="company_zip_code"
            name="company_zip_code"
            value="{{ old('company_zip_code', $data['company_zip_code'] ?? '') }}"
            maxlength="9"
            placeholder="00000-000"
            pattern="\d{5}-\d{3}"
            required
        >
        <div id="zip-code-loading" class="position-absolute top-50 translate-middle-y end-0 me-4 d-none">
            <span class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span>
        </div>
    </div>
</div>

<div id="zip-address-fields" class="{{ old('company_zip_code', $data['company_zip_code'] ?? '') ? '' : 'd-none' }}">
    <div class="row g-3 mb-3">
        <div class="col-md-8">
            <label class="form-label text-gray-700 fw-bolder mb-0" for="company_city_name">Cidade</label>
            <input
                class="form-control"
                id="company_city_name"
                value="{{ old('company_city_name', $data['company_city_name'] ?? '') }}"
                placeholder="Cidade"
                required
            >
        </div>
        <div class="col-md-4">
            <label class="form-label text-gray-700 fw-bolder mb-0" for="company_state_id">Estado</label>
            <select class="form-select" id="company_state_id" name="company_state_id" required>
                <option value="">Selecione</option>
                @foreach ($states as $state)
                    <option
                        value="{{ $state->id }}"
                        data-acronym="{{ $state->acronym }}"
                        @selected((string) old('company_state_id', $data['company_state_id'] ?? '') === (string) $state->id)
                    >
                        {{ $state->acronym }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <input type="hidden" id="company_city_id" name="company_city_id" value="{{ old('company_city_id', $data['company_city_id'] ?? '') }}">
    <div class="mb-3">
        <label class="form-label text-gray-700 fw-bolder mb-0" for="company_address">Endereco</label>
        <input
            class="form-control"
            id="company_address"
            name="company_address"
            value="{{ old('company_address', $data['company_address'] ?? '') }}"
            placeholder="Rua, avenida, etc."
            required
        >
    </div>
    <div class="row g-3 mb-3">
        <div class="col-md-8">
            <label class="form-label text-gray-700 fw-bolder mb-0" for="company_neighborhood">Bairro</label>
            <input
                class="form-control"
                id="company_neighborhood"
                name="company_neighborhood"
                value="{{ old('company_neighborhood', $data['company_neighborhood'] ?? '') }}"
                placeholder="Nome do bairro"
                required
            >
        </div>
        <div class="col-md-4">
            <label class="form-label text-gray-700 fw-bolder mb-0" for="company_number">Numero</label>
            <input
                class="form-control"
                id="company_number"
                name="company_number"
                value="{{ old('company_number', $data['company_number'] ?? '') }}"
                placeholder="Nº"
                required
            >
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label text-gray-700 fw-bolder mb-0" for="company_complement">Complemento</label>
        <input
            class="form-control"
            id="company_complement"
            name="company_complement"
            value="{{ old('company_complement', $data['company_complement'] ?? '') }}"
            placeholder="Apto, bloco, sala (opcional)"
        >
    </div>
</div>

<div class="d-flex justify-content-between mt-4 gap-3">
    {{-- <button class="btn btn-light" type="submit" name="navigation" value="back" formnovalidate>Voltar</button> --}}
    <button id="onboarding-finish-button" class="btn btn-primary w-100" type="submit" name="navigation" value="next" disabled>Finalizar e acessar o sistema</button>
</div>

<button
    id="fill-test-data-address"
    type="button"
    class="btn btn-dark position-fixed bottom-0 end-0 m-4 shadow"
>
    Preencher teste
</button>

@push('step-scripts')
<script>
    $(function () {
        // Estado global
        const resolveLocationUrl = '{{ route('onboarding.resolve-location') }}';
        const $companyZipCodeInput = $('#company_zip_code');
        const $zipCodeLoading = $('#zip-code-loading');
        const $zipAddressFields = $('#zip-address-fields');
        const $companyCityInput = $('#company_city_name');
        const $companyStateInput = $('#company_state_id');
        const $companyCityIdInput = $('#company_city_id');
        const $companyAddressInput = $('#company_address');
        const $companyNeighborhoodInput = $('#company_neighborhood');
        const $fillTestDataAddressButton = $('#fill-test-data-address');
        const $finishButton = $('#onboarding-finish-button');
        const $addressStep = $('.onboarding-step[data-step="address"]');
        let activeLocationRequestId = 0;

        // Helpers / utilitarios
        /**
         * Extrai apenas numeros do CEP e limita ao total de 8 digitos.
         * Padroniza entrada para mascara e consulta do ViaCEP.
         */
        function getZipCodeDigits(value) {
            return value.replace(/\D/g, '').slice(0, 8);
        }

        /**
         * Formata o CEP no padrao brasileiro 00000-000 durante digitacao.
         * Melhora legibilidade sem alterar o valor numerico base.
         */
        function formatZipCode(value) {
            const zipCodeDigits = getZipCodeDigits(value);
            if (zipCodeDigits.length <= 5) {
                return zipCodeDigits;
            }

            return `${zipCodeDigits.slice(0, 5)}-${zipCodeDigits.slice(5)}`;
        }

        // Funcoes de renderizacao / UI
        /**
         * Exibe os campos complementares de endereco apos CEP valido.
         * Mantem a interface enxuta ate haver dados suficientes.
         */
        function showZipAddressFields() {
            $zipAddressFields.removeClass('d-none');
        }

        /**
         * Seleciona estado local pelo acronym retornado no ViaCEP.
         */
        function selectCompanyStateByAcronym(stateAcronym) {
            const normalizedAcronym = (stateAcronym || '').trim().toUpperCase();
            const $stateOption = $companyStateInput
                .find('option')
                .filter(function () {
                    return ($(this).data('acronym') || '') === normalizedAcronym;
                })
                .first();

            $companyStateInput.val($stateOption.val() || '');
        }

        /**
         * Limpa o ID relacional de cidade quando cidade ou estado visual mudam.
         */
        function clearCompanyLocationIds() {
            $companyCityIdInput.val('');
        }

        /**
         * Verifica se a localidade visual ja foi resolvida na base local.
         */
        function hasResolvedCompanyLocation() {
            return Boolean($companyStateInput.val()) && Boolean($companyCityIdInput.val());
        }

        /**
         * Resolve UF e cidade preenchidas para os IDs exigidos no cadastro final.
         */
        function resolveCompanyLocation() {
            const city = $companyCityInput.val() || '';
            const stateId = $companyStateInput.val() || '';

            if (!city || !stateId) {
                clearCompanyLocationIds();
                updateFinishButtonState();
                return;
            }

            activeLocationRequestId += 1;
            const requestId = activeLocationRequestId;
            $finishButton.prop('disabled', true);

            $.ajax({
                url: resolveLocationUrl,
                method: 'GET',
                dataType: 'json',
                data: {
                    city,
                    state_id: stateId,
                },
            })
                .done(function (payload) {
                    if (requestId !== activeLocationRequestId) {
                        return;
                    }

                    if (!payload.success) {
                        clearCompanyLocationIds();
                        return;
                    }

                    $companyCityIdInput.val(payload.company_city_id || '');
                })
                .fail(function () {
                    if (requestId !== activeLocationRequestId) {
                        return;
                    }

                    clearCompanyLocationIds();
                })
                .always(function () {
                    if (requestId !== activeLocationRequestId) {
                        return;
                    }

                    updateFinishButtonState();
                });
        }

        /**
         * Aplica dados retornados pelo ViaCEP nos campos de endereco.
         * Usa fallback para strings vazias em respostas parciais.
         */
        function applyZipCodePayload(payload) {
            $companyCityInput.val(payload.localidade || '');
            selectCompanyStateByAcronym(payload.uf || '');
            $companyAddressInput.val(payload.logradouro || '');
            $companyNeighborhoodInput.val(payload.bairro || '');
            setZipResolvedFieldsLockState(true);
            $('#company_number').trigger('focus');
            resolveCompanyLocation();
        }

        /**
         * Controla bloqueio dos campos preenchidos automaticamente pelo ViaCEP.
         * Evita edição manual após resolução válida de CEP.
         */
        function setZipResolvedFieldsLockState(isLocked) {
            $companyCityInput.prop('readonly', isLocked);
            $companyAddressInput.prop('readonly', isLocked);
            $companyNeighborhoodInput.prop('readonly', isLocked);
            $companyStateInput.prop('disabled', isLocked);
        }

        /**
         * Consulta endereco no ViaCEP e aplica retorno quando o CEP existir.
         * Ignora resposta de erro para nao sobrescrever dados manuais.
         */
        function lookupZipCode(zipCodeDigits) {
            setZipLookupLoadingState(true);

            return $.getJSON(`https://viacep.com.br/ws/${zipCodeDigits}/json/`)
                .done(function (payload) {
                    if (payload.erro) {
                        return;
                    }

                    applyZipCodePayload(payload);
                })
                .always(function () {
                    setZipLookupLoadingState(false);
                });
        }

        /**
         * Controla estado visual de carregamento da consulta de CEP.
         * Evita duplo submit durante requisicoes em andamento.
         */
        function setZipLookupLoadingState(isLoading) {
            $zipCodeLoading.toggleClass('d-none', !isLoading);
            $companyZipCodeInput.prop('readonly', isLoading);
        }

        /**
         * Valida apenas campos obrigatorios visiveis da etapa de endereco.
         * Mantem complemento opcional fora da regra de bloqueio.
         */
        function hasValidRequiredAddressFields() {
            if (!$addressStep.is(':visible')) {
                return false;
            }

            const $requiredFields = $('.onboarding-step[data-step="address"]')
                .find(':input[required]')
                .filter(':enabled:visible');

            let isValid = true;
            $requiredFields.each(function () {
                if (this.checkValidity()) {
                    return true;
                }

                isValid = false;
                return false;
            });

            return isValid;
        }

        /**
         * Atualiza estado do botao finalizar conforme validacao do step.
         * Libera clique apenas quando campos obrigatorios estiverem completos.
         */
        function updateFinishButtonState() {
            $finishButton.prop('disabled', !hasValidRequiredAddressFields() || !hasResolvedCompanyLocation());
        }

        // Event listeners
        /**
         * Escuta digitacao no campo de CEP, aplica mascara progressiva
         * e libera campos de endereco ao atingir quantidade minima de digitos.
         */
        $companyZipCodeInput.on('input', function () {
            setZipResolvedFieldsLockState(false);
            clearCompanyLocationIds();

            const formattedZipCode = formatZipCode($companyZipCodeInput.val() || '');
            $companyZipCodeInput.val(formattedZipCode);
            if (getZipCodeDigits(formattedZipCode).length === 8) {
                showZipAddressFields();
            }

            updateFinishButtonState();
        });

        /**
         * Escuta blur do CEP para consultar ViaCEP quando o valor estiver completo
         * e preencher automaticamente cidade, endereco e bairro.
         */
        $companyZipCodeInput.on('blur', function () {
            const zipCodeDigits = getZipCodeDigits($companyZipCodeInput.val() || '');
            if (zipCodeDigits.length !== 8) {
                updateFinishButtonState();
                return;
            }

            showZipAddressFields();
            lookupZipCode(zipCodeDigits);
            updateFinishButtonState();
        });

        /**
         * Escuta clique no botao de preenchimento para inserir dados de teste
         * e agilizar validacoes visuais deste step.
         */
        $fillTestDataAddressButton.on('click', function () {
            $companyZipCodeInput.val('01310-100');
            showZipAddressFields();
            $companyCityInput.val('Sao Paulo');
            selectCompanyStateByAcronym('SP');
            $companyAddressInput.val('Avenida Paulista');
            $companyNeighborhoodInput.val('Bela Vista');
            $('#company_number').val('1000');
            $('#company_complement').val('Conjunto 101');
            resolveCompanyLocation();
        });

        /**
         * Escuta alteracoes nos campos obrigatorios de endereco para habilitar
         * o botao finalizar somente quando o preenchimento estiver completo.
         */
        $companyCityInput.on('input blur', function () {
            clearCompanyLocationIds();
            updateFinishButtonState();
        });
        $companyCityInput.on('blur', resolveCompanyLocation);
        $companyStateInput.on('input change blur', function () {
            clearCompanyLocationIds();
            updateFinishButtonState();
        });
        $companyStateInput.on('change blur', resolveCompanyLocation);
        $('#company_address, #company_neighborhood, #company_number').on('input blur', updateFinishButtonState);

        if (!hasResolvedCompanyLocation()) {
            resolveCompanyLocation();
        }
        updateFinishButtonState();
    });
</script>
@endpush
