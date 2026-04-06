@extends('app')

@section('title', 'Onboarding')

@section('content')
    <div class="container-fluid">
        <div class="row min-vh-100">
            <div class="col-12 col-lg-6 bg-white d-flex align-items-center z-index-3" style="box-shadow: 20px 0px 100px #10161f97;">
                <div class="w-100 px-4 px-md-5 py-4 mx-auto" style="max-width: 640px;">
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

            <div class="col-12 col-lg-6 d-flex align-items-end p-4 p-lg-8 justify-content-center position-relative overflow-hidden" style="background: url('{{ asset('assets/media/bg-big.jpg') }}') no-repeat center center; background-size: cover;">
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

@endsection

@push('step-scripts')
    <script>
        $(function () {
            // Estado global
            const stepOrder = ['account', 'company', 'goal', 'address'];
            const $form = $('form');
            const $finalizingMessage = $('#onboarding-finalizing-message');
            let currentStep = 'account';
            let isFinishing = false;

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
            function canProceedFromCurrentStep(direction) {
                if (direction !== 'next') {
                    return true;
                }

                if (!validateRequiredFieldsByStep(currentStep)) {
                    return false;
                }

                // Mantem compatibilidade com validacao isolada no step account.
                if (currentStep !== 'account' || typeof window.validateAccountStep !== 'function') {
                    return true;
                }

                return window.validateAccountStep();
            }

            // Funcoes de renderizacao / UI
            /**
             * Exibe apenas o step informado e oculta os demais no formulario.
             * Garante que todos os steps permanecam montados no DOM.
             */
            function showStep(stepName) {
                $('.onboarding-step').hide();
                $(`.onboarding-step[data-step="${stepName}"]`).show();
                if (stepName !== 'address') {
                    $finalizingMessage.stop(true, true).hide();
                }
            }

            /**
             * Exibe mensagem final com animacao para indicar encaminhamento.
             * Reforca feedback ao usuario antes do encerramento do fluxo.
             */
            function showFinalizingMessage() {
                $finalizingMessage.stop(true, true).fadeIn(300);
            }

            /**
             * Move o fluxo para o step alvo considerando regras de navegacao.
             * Reinicia no primeiro step ao finalizar o ultimo.
             */
            function navigateSteps(direction) {
                if (direction === 'next' && currentStep === 'address') {
                    isFinishing = true;
                    showFinalizingMessage();

                    // Aguarda o feedback visual antes de reiniciar o fluxo.
                    setTimeout(function () {
                        currentStep = 'account';
                        showStep(currentStep);
                        isFinishing = false;
                    }, 1600);

                    return;
                }

                currentStep = getAdjacentStep(currentStep, direction);
                showStep(currentStep);
            }

            // Event listeners
            /**
             * Escuta cliques nos botoes de navegacao, valida o step atual
             * e executa a transicao de tela sem recarregar a pagina.
             */
            $form.on('click', 'button[name="navigation"]', function (event) {
                event.preventDefault();

                if (isFinishing) {
                    return;
                }

                const direction = $(this).val();
                if (!canProceedFromCurrentStep(direction)) {
                    return;
                }

                navigateSteps(direction);
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
