@extends('app')

@section('title', 'Criando seu sistema')

@section('content')
    <div class="container-fluid">
        <div class="row min-vh-100">
            <div class="col-12 col-lg-6 bg-white d-flex align-items-center z-index-3" style="box-shadow: 20px 0px 100px #10161f97;">
                <div class="w-100 px-4 px-md-5 py-4 mx-auto mw-650px">
                    <div class="mb-8 text-center text-md-start">
                        <span class="fw-bolder fs-3x" style="color: #373f53;">mi<span style="color: #79c400">.</span>Core</span>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('onboarding.submit') }}">
                        @csrf

                        <div class="onboarding-step" data-step="account">
                            @include('onboarding.steps.account')
                        </div>
                        <div class="onboarding-step" data-step="company" style="display: none;">
                            @include('onboarding.steps.company')
                        </div>
                        <div class="onboarding-step" data-step="goal" style="display: none;">
                            @include('onboarding.steps.goal')
                        </div>
                        <div class="onboarding-step" data-step="address" style="display: none;">
                            @include('onboarding.steps.address')
                        </div>
                    </form>
                </div>
            </div>

            <div
                id="onboarding-side-panel"
                class="col-12 col-lg-6 d-flex align-items-end p-4 p-lg-8 justify-content-center position-relative overflow-hidden"
                style="background: url('{{ asset('assets/media/bg-big.jpg') }}') no-repeat center center; background-size: cover;"
            >
                <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(0deg, #131924f2 20%, #1d253438 80%);"></div>

                <div class="z-index-2 w-100 mw-600px">
                    <div class="mb-8 text-white">
                        <span class="badge text-success mb-4" style="background-color: #68c7170f !important;">Teste Gratuitamente</span>
                        <h2 class="fw-bolder lh-sm mb-3 text-white" style="font-size: clamp(1.7rem, 2.8vw, 2.4rem);">
                            <span style="color: #62de04;">Venda mais</span> e
                            <span style="color: #62de04;">ganhe produtividade</span>
                            com uma operação centralizada!
                        </h2>
                        <p class="mb-0 text-gray-200 fs-5">
                            Complete seu cadastro em minutos e comece a usar um sistema pensado para acelerar resultados.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div
        id="onboarding-finalizing-message"
        class="position-fixed top-0 start-0 w-100 h-100 px-5"
        style="display: none; z-index: 2000; background-color: rgba(255, 255, 255, 0.96);"
    >
        <div class="d-flex align-items-center justify-content-center h-100">
            <h1 class="fw-bolder mb-0 text-gray-900">
                Estamos finalizando seu cadastro, vamos te encaminhando para o seu sistema.
            </h1>
        </div>
    </div>

    @env('local')
        <div class="position-fixed top-0 end-0 m-4 bg-white border rounded shadow-sm p-3 z-index-3" style="width: 220px;">
            <label class="form-label fw-bold text-gray-700 mb-1" for="onboarding-local-step-selector">Passo</label>
            <select class="form-select form-select-sm" id="onboarding-local-step-selector">
                <option value="account">Conta</option>
                <option value="company">Empresa</option>
                <option value="goal">Objetivo</option>
                <option value="address">Endereco</option>
            </select>
        </div>
    @endenv

@endsection

@push('step-scripts')
    <script>
        $(function () {
            // Estado global
            const stepOrder = ['account', 'company', 'goal', 'address'];
            const $form = $('form');
            const $sidePanel = $('#onboarding-side-panel');
            const $localStepSelector = $('#onboarding-local-step-selector');
            const csrfToken = $form.find('input[name="_token"]').val();
            const saveStepUrl = '{{ route('onboarding.save-step') }}';
            const finalizeUrl = '{{ route('onboarding.finalize') }}';
            const defaultBackgroundImage = '{{ asset('assets/media/bg-big.jpg') }}';
            const addressBackgroundImage = '{{ asset('assets/media/bg-finish.jpg') }}';
            let currentStep = 'account';

            // Helpers / utilitarios
            /**
             * Retorna o nome do step adjacente conforme a direcao de navegacao.
             * Mantem a ordem do fluxo centralizada em uma unica lista.
             */
            function getAdjacentStep(stepName, direction) {
                const currentIndex = stepOrder.indexOf(stepName);
                if (currentIndex < 0) {
                    return stepOrder[0];
                }

                const nextIndex = direction === 'next' ? currentIndex + 1 : currentIndex - 1;
                if (nextIndex < 0 || nextIndex >= stepOrder.length) {
                    return stepName;
                }

                return stepOrder[nextIndex];
            }

            /**
             * Busca campos obrigatorios visiveis e habilitados do step atual.
             * Evita validar inputs de outras etapas que estao ocultas.
             */
            function getRequiredVisibleFields(stepName) {
                return $(`.onboarding-step[data-step="${stepName}"]`)
                    .find(':input[required]')
                    .filter(':enabled')
                    .filter(function () {
                        if ($(this).is(':radio') || $(this).is(':checkbox')) {
                            return true;
                        }

                        return $(this).is(':visible');
                    });
            }

            /**
             * Valida grupo de radios obrigatorios para garantir uma selecao.
             * Usa reportValidity para manter mensagem nativa do navegador.
             */
            function validateRequiredRadioGroup($requiredFields, radioName) {
                const $radioGroup = $requiredFields.filter(`[name="${radioName}"]`);
                if (!$radioGroup.length) {
                    return true;
                }

                const hasCheckedRadio = $radioGroup.is(':checked');
                $radioGroup.each(function () {
                    this.setCustomValidity('');
                });

                if (hasCheckedRadio) {
                    return true;
                }

                // Define mensagem no primeiro radio visivel para feedback imediato.
                const firstRadio = $radioGroup.get(0);
                firstRadio.setCustomValidity('Selecione uma opcao para continuar.');
                firstRadio.reportValidity();
                firstRadio.setCustomValidity('');

                return false;
            }

            /**
             * Valida grupo de checkboxes obrigatorios exigindo uma selecao.
             * Usa reportValidity para manter feedback nativo no navegador.
             */
            function validateRequiredCheckboxGroup($requiredFields, checkboxName) {
                const $checkboxGroup = $requiredFields.filter(`[name="${checkboxName}"]`);
                if (!$checkboxGroup.length) {
                    return true;
                }

                const hasCheckedCheckbox = $checkboxGroup.is(':checked');
                $checkboxGroup.each(function () {
                    this.setCustomValidity('');
                });

                if (hasCheckedCheckbox) {
                    return true;
                }

                const firstCheckbox = $checkboxGroup.get(0);
                firstCheckbox.setCustomValidity('Selecione ao menos uma opcao para continuar.');
                firstCheckbox.reportValidity();
                firstCheckbox.setCustomValidity('');

                return false;
            }

            /**
             * Valida campos obrigatorios da etapa atual respeitando visibilidade.
             * Interrompe a navegacao no primeiro campo invalido encontrado.
             */
            function validateRequiredFieldsByStep(stepName) {
                const $requiredFields = getRequiredVisibleFields(stepName);
                const processedRadioNames = {};
                const processedCheckboxNames = {};
                let isStepValid = true;

                $requiredFields.each(function () {
                    if (!isStepValid) {
                        return false;
                    }

                    const $field = $(this);
                    if ($field.is(':radio')) {
                        const radioName = $field.attr('name');
                        if (!radioName || processedRadioNames[radioName]) {
                            return true;
                        }

                        processedRadioNames[radioName] = true;
                        isStepValid = validateRequiredRadioGroup($requiredFields, radioName);
                        return isStepValid;
                    }

                    if ($field.is(':checkbox')) {
                        const checkboxName = $field.attr('name');
                        if (!checkboxName || processedCheckboxNames[checkboxName]) {
                            return true;
                        }

                        processedCheckboxNames[checkboxName] = true;
                        isStepValid = validateRequiredCheckboxGroup($requiredFields, checkboxName);
                        return isStepValid;
                    }

                    if (!this.checkValidity()) {
                        this.reportValidity();
                        isStepValid = false;
                        return false;
                    }

                    return true;
                });

                return isStepValid;
            }

            /**
             * Executa validacoes do step atual antes de permitir a navegacao.
             * Evita avancar para o proximo step quando ha erro local.
             */
            function canProceedFromCurrentStep(stepName, direction) {
                if (direction !== 'next') {
                    return true;
                }

                if (!validateRequiredFieldsByStep(stepName)) {
                    return false;
                }

                // Mantem compatibilidade com validacao isolada no step account.
                if (stepName !== 'account' || typeof window.validateAccountStep !== 'function') {
                    return true;
                }

                return window.validateAccountStep();
            }

            /**
             * Converte seleção booleana de checkbox para inteiro esperado no backend.
             * Mantém payload consistente para campos opcionais de preferência.
             */
            function checkboxValue(selector) {
                return $(selector).is(':checked') ? 1 : 0;
            }

            /**
             * Coleta apenas os campos relevantes da etapa atual para persistência.
             * Evita sobrescrever dados de outras etapas com valores vazios.
             */
            function collectStepPayload(stepName) {
                const payload = {
                    _token: csrfToken,
                    step: stepName,
                };

                // Identidade sempre vai em todas as etapas para resolução no backend.
                payload.email = ($('#email').val() || '').trim();
                payload.cpf = ($('#cpf').val() || '').trim();
                payload.cnpj = ($('#cnpj').val() || '').trim();
                payload.document_type = ($('#document_type').val() || '').trim();

                if (stepName === 'account') {
                    const fullName = ($('#full_name').val() || '').trim();
                    payload.name = fullName;
                    payload.company = fullName;
                    payload.whatsapp = ($('#phone').val() || '').trim();
                    payload.password = ($('#password').val() || '').trim();
                    payload.has_coupon = checkboxValue('#has_coupon');
                    payload.coupon_code = ($('#coupon_code').val() || '').trim();
                    payload.tips_whatsapp = checkboxValue('#tips_whatsapp');
                    payload.tips_email = checkboxValue('#tips_email');
                    return payload;
                }

                if (stepName === 'company') {
                    payload.company_profile = $('input[name="company_profile"]:checked').val() || '';
                    return payload;
                }

                if (stepName === 'goal') {
                    payload.main_goals = $('input[name="main_goals[]"]:checked')
                        .map(function () {
                            return $(this).val();
                        })
                        .get();
                    return payload;
                }

                if (stepName === 'address') {
                    payload.company_zip_code = ($('#company_zip_code').val() || '').trim();
                    payload.company_state_id = $('#company_state_id').val() || '';
                    payload.company_city_id = $('#company_city_id').val() || '';
                    payload.company_address = ($('#company_address').val() || '').trim();
                    payload.company_neighborhood = ($('#company_neighborhood').val() || '').trim();
                    payload.company_number = ($('#company_number').val() || '').trim();
                    payload.company_complement = ($('#company_complement').val() || '').trim();
                }

                return payload;
            }

            /**
             * Persiste etapa atual na central resolvendo o tenant por identidade.
             * Mantém o fluxo de onboarding incremental sem recarregar a tela.
             */
            function persistStep(stepName) {
                return $.ajax({
                    url: saveStepUrl,
                    method: 'POST',
                    dataType: 'json',
                    data: collectStepPayload(stepName),
                });
            }

            /**
             * Finaliza onboarding na central e dispara provisionamento do tenant.
             * Reaproveita payload da última etapa para garantir consistência final.
             */
            function finalizeStep(stepName) {
                const payload = collectStepPayload(stepName);

                return $.ajax({
                    url: finalizeUrl,
                    method: 'POST',
                    dataType: 'json',
                    data: payload,
                });
            }

            // Funcoes de renderizacao / UI
            /**
             * Retorna o step atualmente visivel no DOM.
             * Evita dessicronia entre estado em memoria e interface.
             */
            function getVisibleStepName() {
                const visibleStep = $('.onboarding-step:visible').first().data('step');
                return visibleStep || currentStep;
            }

            /**
             * Exibe apenas o step informado e oculta os demais no formulario.
             * Garante que todos os steps permanecam montados no DOM.
             */
            function showStep(stepName) {
                $('.onboarding-step').hide();
                $(`.onboarding-step[data-step="${stepName}"]`).show();
                $localStepSelector.val(stepName);
                updateSidePanelBackground(stepName);
            }

            /**
             * Atualiza imagem lateral conforme etapa visivel do onboarding.
             * Usa imagem de finalizacao apenas na etapa de endereco.
             */
            function updateSidePanelBackground(stepName) {
                const backgroundImage = stepName === 'address' ? addressBackgroundImage : defaultBackgroundImage;
                $sidePanel.css('background-image', `url('${backgroundImage}')`);
            }

            /**
             * Finaliza fluxo do onboarding com feedback visual na tela.
             * Esta acao deve ocorrer apenas no botao final da etapa CEP.
             */
            function finalizeOnboardingFlow(redirectUrl) {
                $('#onboarding-finalizing-message').stop(true, true).fadeIn(300, function () {
                    if (!redirectUrl) {
                        alert('Cadastro finalizado, mas a URL do sistema não foi retornada.');
                        return;
                    }

                    window.setTimeout(function () {
                        window.location.href = redirectUrl;
                    }, 700);
                });
            }

            /**
             * Monta mensagem de erro preservando detalhes retornados pela central.
             */
            function buildRequestErrorMessage(xhr, fallbackMessage) {
                const response = xhr.responseJSON || {};
                let errorMessage = response.message || fallbackMessage;

                if (response.error) {
                    errorMessage += `\n\nDetalhe: ${response.error}`;
                }

                if (response.provisioning && response.provisioning.step) {
                    errorMessage += `\nEtapa: ${response.provisioning.step}`;
                }

                return errorMessage;
            }

            /**
             * Move o fluxo para o step alvo considerando regras de navegacao.
             * Reinicia no primeiro step ao finalizar o ultimo.
             */
            function navigateSteps(stepName, direction) {
                currentStep = getAdjacentStep(stepName, direction);
                showStep(currentStep);
            }

            // Event listeners
            /**
             * Permite navegar direto entre passos no ambiente local.
             */
            $localStepSelector.on('change', function () {
                currentStep = $(this).val();
                showStep(currentStep);
            });

            /**
             * Escuta cliques nos botoes de navegacao, valida o step atual
             * e executa a transicao de tela sem recarregar a pagina.
             */
            $form.on('click', 'button[name="navigation"]', function (event) {
                if ($(this).is('#onboarding-finish-button')) {
                    return;
                }

                event.preventDefault();

                const $button = $(this);
                const clickedStepName = $(this).closest('.onboarding-step').data('step') || getVisibleStepName();
                const direction = $(this).val();
                if (!canProceedFromCurrentStep(clickedStepName, direction)) {
                    return;
                }

                if (direction !== 'next') {
                    navigateSteps(clickedStepName, direction);
                    return;
                }

                $button.prop('disabled', true);
                persistStep(clickedStepName)
                    .done(function () {
                        navigateSteps(clickedStepName, direction);
                    })
                    .fail(function (xhr) {
                        const errorMessage = buildRequestErrorMessage(xhr, 'Não foi possível salvar esta etapa agora.');
                        alert(errorMessage);
                    })
                    .always(function () {
                        $button.prop('disabled', false);
                    });
            });

            /**
             * Escuta clique apenas no botao final do step de endereco.
             * Mantem gatilho de finalizacao isolado do listener generico.
             */
            $form.on('click', '#onboarding-finish-button', function (event) {
                event.preventDefault();

                const $button = $(this);
                const clickedStepName = $button.closest('.onboarding-step').data('step') || getVisibleStepName();
                const direction = $(this).val();
                if (!canProceedFromCurrentStep(clickedStepName, direction)) {
                    return;
                }

                $button.prop('disabled', true);
                persistStep(clickedStepName)
                    .then(function () {
                        return finalizeStep(clickedStepName);
                    })
                    .done(function (response) {
                        finalizeOnboardingFlow(response.redirect_url);
                    })
                    .fail(function (xhr) {
                        const errorMessage = buildRequestErrorMessage(xhr, 'Não foi possível finalizar o onboarding agora.');
                        alert(errorMessage);
                    })
                    .always(function () {
                        $button.prop('disabled', false);
                    });
            });

            /**
             * Escuta o submit do formulario para impedir envio imediato
             * e manter o fluxo atual totalmente controlado no front-end.
             */
            $form.on('submit', function (event) {
                event.preventDefault();
            });

            showStep(currentStep);
        });
    </script>
@endpush
