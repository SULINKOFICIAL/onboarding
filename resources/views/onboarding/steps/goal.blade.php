<div class="mb-3">
    <span class="badge badge-success">30 dias gratuitos</span>
</div>
<div class="d-flex gap-2 mb-3" aria-label="Progresso do onboarding">
    <div class="flex-fill rounded-pill h-10px bg-primary"></div>
    <div class="flex-fill rounded-pill h-10px bg-primary"></div>
    <div class="flex-fill rounded-pill h-10px bg-primary"></div>
</div>

<h1 class="fs-2x fw-bolder mt-6 mb-10 me-md-13">
    Quase la. Escolha seu foco principal para sugerirmos o melhor caminho.
</h1>

<div class="mb-3">
    <p class="form-label text-gray-700 fw-bolder mb-0">O que voce mais quer melhorar agora?</p>
    <div class="form-check mb-2">
        <input class="form-check-input" id="goal_centralizar_atendimentos" type="radio" name="main_goal" value="centralizar_atendimentos" @checked(old('main_goal', $data['main_goal'] ?? '') === 'centralizar_atendimentos')>
        <label class="form-check-label" for="goal_centralizar_atendimentos">Centralizar Atendimentos</label>
    </div>
    <div class="form-check mb-2">
        <input class="form-check-input" id="goal_vender_online" type="radio" name="main_goal" value="vender_online" @checked(old('main_goal', $data['main_goal'] ?? '') === 'vender_online')>
        <label class="form-check-label" for="goal_vender_online">Vender Online</label>
    </div>
    <div class="form-check mb-2">
        <input class="form-check-input" id="goal_controlar_estoque" type="radio" name="main_goal" value="controlar_estoque" @checked(old('main_goal', $data['main_goal'] ?? '') === 'controlar_estoque')>
        <label class="form-check-label" for="goal_controlar_estoque">Controlar estoque</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" id="goal_vender_servicos" type="radio" name="main_goal" value="vender_servicos" @checked(old('main_goal', $data['main_goal'] ?? '') === 'vender_servicos')>
        <label class="form-check-label" for="goal_vender_servicos">Vender Servicos</label>
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
        $('#fill-test-data-goal').on('click', function () {
            $('input[name="main_goal"][value="vender_online"]').prop('checked', true);
        });
    });
</script>
