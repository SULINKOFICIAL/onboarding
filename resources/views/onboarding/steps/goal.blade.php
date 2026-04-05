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
        // Estado global
        const $fillTestDataButton = $('#fill-test-data');

        // Helpers / utilitários
        /**
         * Marca uma opcao de radio quando o elemento estiver disponivel no DOM.
         * Evita duplicar validacoes de existencia no restante do script.
         */
        function setRadioValue(selector) {
            const $radio = $(selector);
            if (!$radio.length) {
                return;
            }

            $radio.prop('checked', true);
        }

        // Funções de renderização / UI
        /**
         * Preenche a meta principal padrao para testes rapidos desta etapa.
         * Preserva o comportamento anterior sem alterar regra de negocio.
         */
        function fillTestDataStep() {
            setRadioValue('input[name="main_goal"][value="vender_online"]');
        }

        // Event listeners
        /**
         * Explica o que este listener escuta, o que ele dispara
         * e por que esse comportamento é necessário neste arquivo.
         */
        $fillTestDataButton.on('click', fillTestDataStep);
    </script>
@endsection
