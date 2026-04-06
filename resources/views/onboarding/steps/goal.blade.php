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
            <input class="btn-check" id="goal_centralizar_atendimentos" type="radio" name="main_goal" value="centralizar_atendimentos" autocomplete="off" @checked(old('main_goal', $data['main_goal'] ?? '') === 'centralizar_atendimentos')>
            <label class="btn bg-gray-200 btn-success-mc rounded-4 p-6 text-start w-100 h-100 d-flex flex-column justify-content-center align-items-start" for="goal_centralizar_atendimentos">
                <span class="fs-4 fw-bold text-gray-800 mb-1">Centralizar Atendimentos</span>
                <span class="fs-6 text-gray-600 lh-sm fw-normal">Organize canais e conversas em um unico lugar</span>
            </label>
        </div>

        <div class="col-12 col-lg-6">
            <input class="btn-check" id="goal_vender_online" type="radio" name="main_goal" value="vender_online" autocomplete="off" @checked(old('main_goal', $data['main_goal'] ?? '') === 'vender_online')>
            <label class="btn bg-gray-200 btn-success-mc rounded-4 p-6 text-start w-100 h-100 d-flex flex-column justify-content-center align-items-start" for="goal_vender_online">
                <span class="fs-4 fw-bold text-gray-800 mb-1">Vender Online</span>
                <span class="fs-6 text-gray-600 lh-sm fw-normal">Acelere vendas com processos simples e rapidos</span>
            </label>
        </div>

        <div class="col-12 col-lg-6">
            <input class="btn-check" id="goal_controlar_estoque" type="radio" name="main_goal" value="controlar_estoque" autocomplete="off" @checked(old('main_goal', $data['main_goal'] ?? '') === 'controlar_estoque')>
            <label class="btn bg-gray-200 btn-success-mc rounded-4 p-6 text-start w-100 h-100 d-flex flex-column justify-content-center align-items-start" for="goal_controlar_estoque">
                <span class="fs-4 fw-bold text-gray-800 mb-1">Controlar Estoque</span>
                <span class="fs-6 text-gray-600 lh-sm fw-normal">Acompanhe entradas, saidas e reposicoes com seguranca</span>
            </label>
        </div>

        <div class="col-12 col-lg-6">
            <input class="btn-check" id="goal_vender_servicos" type="radio" name="main_goal" value="vender_servicos" autocomplete="off" @checked(old('main_goal', $data['main_goal'] ?? '') === 'vender_servicos')>
            <label class="btn bg-gray-200 btn-success-mc rounded-4 p-6 text-start w-100 h-100 d-flex flex-column justify-content-center align-items-start" for="goal_vender_servicos">
                <span class="fs-4 fw-bold text-gray-800 mb-1">Vender Servicos</span>
                <span class="fs-6 text-gray-600 lh-sm fw-normal">Monte pacotes e ganhe produtividade no atendimento</span>
            </label>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between mt-4 gap-3">
    <button class="btn btn-light" type="submit" name="navigation" value="back" formnovalidate>Voltar</button>
    <button class="btn btn-primary w-100" type="submit" name="navigation" value="next">Continuar</button>
</div>

<button
    id="fill-test-data-goal"
    type="button"
    class="btn btn-dark position-fixed bottom-0 end-0 m-4 shadow"
>
    Preencher teste
</button>

<script>
    $(function () {
        function syncGoalActiveState() {
            $('.btn-success-mc').removeClass('active');
            $('input[name="main_goal"]:checked').each(function () {
                $(`label[for="${this.id}"]`).addClass('active');
            });
        }

        $('input[name="main_goal"]').on('change', syncGoalActiveState);
        $('.btn-success-mc').on('click', function () {
            $('.btn-success-mc').removeClass('active');
            $(this).addClass('active');
        });

        $('#fill-test-data-goal').on('click', function () {
            $('input[name="main_goal"][value="vender_online"]').prop('checked', true).trigger('change');
        });

        syncGoalActiveState();
    });
</script>
