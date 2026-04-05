<div class="mb-3">
    <p class="form-label mb-2">O que voce mais quer melhorar agora?</p>
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

<button
    id="fill-test-data"
    type="button"
    class="btn btn-dark position-fixed bottom-0 end-0 m-4 shadow"
>
    Preencher teste
</button>

@section('custom-footer')
    <script>
        document.getElementById('fill-test-data')?.addEventListener('click', function () {
            const radio = document.querySelector('input[name="main_goal"][value="vender_online"]');
            if (radio) {
                radio.checked = true;
            }
        });
    </script>
@endsection
