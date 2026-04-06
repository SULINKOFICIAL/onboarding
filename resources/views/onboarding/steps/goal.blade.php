<div class="mb-3">
    <span class="badge badge-success onboarding-trial-badge">30 dias gratuitos</span>
</div>
<div class="d-flex gap-2 mb-3" aria-label="Progresso do onboarding">
    <div class="flex-fill rounded-pill h-10px bg-primary"></div>
    <div class="flex-fill rounded-pill h-10px bg-primary"></div>
    <div class="flex-fill rounded-pill h-10px bg-primary"></div>
</div>

<h1 class="fs-2x fw-bolder mt-6 mb-10 me-md-13">
    Quase la. Escolha seu foco principal para sugerirmos o melhor caminho.
</h1>

<div class="mb-12">
    <p class="form-label text-gray-700 fw-bolder mb-0">O que voce mais quer melhorar agora?</p>

    <div class="row g-4 mt-1">
        <div class="col-12 col-lg-6">
            <input class="btn-check" id="goal_centralizar_atendimentos" type="checkbox" name="main_goals[]" value="centralizar_atendimentos" autocomplete="off" required @checked(in_array('centralizar_atendimentos', old('main_goals', $data['main_goals'] ?? []), true))>
            <label class="btn bg-gray-200 btn-success-mc rounded-4 p-6 text-start w-100 h-100 d-flex justify-content-between align-items-start gap-4" for="goal_centralizar_atendimentos">
                <span class="d-flex flex-column">
                    <span class="fs-4 fw-bold text-gray-800 mb-1">Centralizar Atendimentos</span>
                    <span class="fs-6 text-gray-600 lh-sm fw-normal">Organize canais e conversas em um unico lugar</span>
                </span>
                <i class="fa-solid fa-comments fs-2 text-gray-700 mt-1"></i>
            </label>
        </div>

        <div class="col-12 col-lg-6">
            <input class="btn-check" id="goal_vender_online" type="checkbox" name="main_goals[]" value="vender_online" autocomplete="off" required @checked(in_array('vender_online', old('main_goals', $data['main_goals'] ?? []), true))>
            <label class="btn bg-gray-200 btn-success-mc rounded-4 p-6 text-start w-100 h-100 d-flex justify-content-between align-items-start gap-4" for="goal_vender_online">
                <span class="d-flex flex-column">
                    <span class="fs-4 fw-bold text-gray-800 mb-1">Vender Online</span>
                    <span class="fs-6 text-gray-600 lh-sm fw-normal">Acelere vendas com processos simples e rapidos</span>
                </span>
                <i class="fa-solid fa-cart-shopping fs-2 text-gray-700 mt-1"></i>
            </label>
        </div>

        <div class="col-12 col-lg-6">
            <input class="btn-check" id="goal_controlar_estoque" type="checkbox" name="main_goals[]" value="controlar_estoque" autocomplete="off" required @checked(in_array('controlar_estoque', old('main_goals', $data['main_goals'] ?? []), true))>
            <label class="btn bg-gray-200 btn-success-mc rounded-4 p-6 text-start w-100 h-100 d-flex justify-content-between align-items-start gap-4" for="goal_controlar_estoque">
                <span class="d-flex flex-column">
                    <span class="fs-4 fw-bold text-gray-800 mb-1">Controlar Estoque</span>
                    <span class="fs-6 text-gray-600 lh-sm fw-normal">Acompanhe entradas, saidas e reposicoes com seguranca</span>
                </span>
                <i class="fa-solid fa-boxes-stacked fs-2 text-gray-700 mt-1"></i>
            </label>
        </div>

        <div class="col-12 col-lg-6">
            <input class="btn-check" id="goal_vender_servicos" type="checkbox" name="main_goals[]" value="vender_servicos" autocomplete="off" required @checked(in_array('vender_servicos', old('main_goals', $data['main_goals'] ?? []), true))>
            <label class="btn bg-gray-200 btn-success-mc rounded-4 p-6 text-start w-100 h-100 d-flex justify-content-between align-items-start gap-4" for="goal_vender_servicos">
                <span class="d-flex flex-column">
                    <span class="fs-4 fw-bold text-gray-800 mb-1">Vender Servicos</span>
                    <span class="fs-6 text-gray-600 lh-sm fw-normal">Monte pacotes e ganhe produtividade no atendimento</span>
                </span>
                <i class="fa-solid fa-briefcase fs-2 text-gray-700 mt-1"></i>
            </label>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between mt-4 gap-3">
    {{-- <button class="btn btn-light" type="submit" name="navigation" value="back" formnovalidate>Voltar</button> --}}
    <button class="btn btn-primary w-100" type="submit" name="navigation" value="next" disabled>Continuar</button>
</div>

<button
    id="fill-test-data-goal"
    type="button"
    class="btn btn-dark position-fixed bottom-0 end-0 m-4 shadow"
>
    Preencher teste
</button>

@push('step-scripts')
<script>
    $(function () {
        // Estado global
        const $goalOptions = $('input[name="main_goals[]"]');
        const $goalCards = $('.btn-success-mc');
        const $fillTestDataGoalButton = $('#fill-test-data-goal');
        const $nextStepButton = $('.onboarding-step[data-step="goal"] button[name="navigation"][value="next"]');

        // Helpers / utilitarios
        /**
         * Remove classe active de todos os cards de objetivo principal.
         * Evita manter mais de uma opcao destacada na interface.
         */
        function clearGoalActiveState() {
            $goalCards.removeClass('active');
        }

        // Funcoes de renderizacao / UI
        /**
         * Sincroniza destaque visual dos cards com o radio selecionado.
         * Preserva estado correto ao retornar para este step.
         */
        function syncGoalActiveState() {
            clearGoalActiveState();
            $goalOptions.filter(':checked').each(function () {
                $(`label[for="${this.id}"]`).addClass('active');
            });
        }

        /**
         * Atualiza estado do botao continuar conforme selecao dos objetivos.
         * Libera avancar apenas quando houver ao menos uma opcao marcada.
         */
        function updateNextStepButtonState() {
            $nextStepButton.prop('disabled', !$goalOptions.is(':checked'));
        }

        // Event listeners
        /**
         * Escuta alteracao dos radios de objetivo para atualizar o card ativo
         * e manter consistencia entre input real e estado visual.
         */
        $goalOptions.on('change', syncGoalActiveState);
        $goalOptions.on('change', updateNextStepButtonState);

        /**
         * Escuta clique no card visual para manter sincronia visual
         * com o estado de checkbox após a atualizacao do input.
         */
        $goalCards.on('click', function () {
            setTimeout(syncGoalActiveState, 0);
        });

        /**
         * Escuta clique no botao de preenchimento para marcar objetivo padrao
         * e acelerar testes de navegacao no fluxo de onboarding.
         */
        $fillTestDataGoalButton.on('click', function () {
            $('input[name="main_goals[]"][value="vender_online"]').prop('checked', true).trigger('change');
        });

        syncGoalActiveState();
        updateNextStepButtonState();
    });
</script>
@endpush
