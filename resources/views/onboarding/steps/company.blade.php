<div class="mb-3">
    <span class="badge badge-success">30 dias gratuitos</span>
</div>
<div class="d-flex gap-2 mb-3" aria-label="Progresso do onboarding">
    @for ($bar = 1; $bar <= 3; $bar++)
        <div class="flex-fill rounded-pill h-10px {{ ($currentStepIndex + 1) >= $bar ? 'bg-primary' : 'bg-gray-200' }}"></div>
    @endfor
</div>

<h1 class="fs-2x fw-bolder mt-6 mb-10 me-md-13">
    Conte pra gente o perfil da sua empresa para personalizarmos sua experiência.
</h1>

<div class="mb-3">
    <p class="form-label mb-2">Qual o perfil da empresa?</p>

    <div class="row g-4 mt-1">
        <div class="col-12 col-lg-6">
            <input class="btn-check" id="profile_lucro_presumido" type="radio" name="company_profile" value="lucro_presumido" autocomplete="off" @checked(old('company_profile', $data['company_profile'] ?? '') === 'lucro_presumido')>
            <label class="btn btn-light border border-2 rounded-4 p-6 text-start w-100 h-100 d-flex flex-column justify-content-center align-items-start" for="profile_lucro_presumido">
                <span class="fs-2 fw-bold text-gray-900 mb-2">Lucro Presumido</span>
                <span class="fs-4 text-gray-700 lh-sm">Regime baseado na estimativa de lucro</span>
            </label>
        </div>

        <div class="col-12 col-lg-6">
            <input class="btn-check" id="profile_lucro_real" type="radio" name="company_profile" value="lucro_real" autocomplete="off" @checked(old('company_profile', $data['company_profile'] ?? '') === 'lucro_real')>
            <label class="btn btn-light border border-2 rounded-4 p-6 text-start w-100 h-100 d-flex flex-column justify-content-center align-items-start" for="profile_lucro_real">
                <span class="fs-2 fw-bold text-gray-900 mb-2">Lucro Real</span>
                <span class="fs-4 text-gray-700 lh-sm">Regime baseado no lucro efetivo da empresa</span>
            </label>
        </div>

        <div class="col-12 col-lg-6">
            <input class="btn-check" id="profile_simples_nacional" type="radio" name="company_profile" value="simples_nacional" autocomplete="off" @checked(old('company_profile', $data['company_profile'] ?? '') === 'simples_nacional')>
            <label class="btn btn-light border border-2 rounded-4 p-6 text-start w-100 h-100 d-flex flex-column justify-content-center align-items-start" for="profile_simples_nacional">
                <span class="fs-2 fw-bold text-gray-900 mb-2">Simples Nacional</span>
                <span class="fs-4 text-gray-700 lh-sm">Regime simplificado para microempresa e empresa de pequeno porte</span>
            </label>
        </div>

        <div class="col-12 col-lg-6">
            <input class="btn-check" id="profile_mei" type="radio" name="company_profile" value="mei" autocomplete="off" @checked(old('company_profile', $data['company_profile'] ?? '') === 'mei')>
            <label class="btn btn-light border border-2 rounded-4 p-6 text-start w-100 h-100 d-flex flex-column justify-content-center align-items-start" for="profile_mei">
                <span class="fs-2 fw-bold text-gray-900 mb-2">MEI</span>
                <span class="fs-4 text-gray-700 lh-sm">Regime simplificado para microempreendedor individual</span>
            </label>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between mt-4 gap-3">
    <button class="btn btn-light" type="submit" name="navigation" value="back" formnovalidate>Voltar</button>
    <button class="btn btn-primary w-100" type="submit" name="navigation" value="next">Continuar</button>
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
         * Marca uma opcao de radio quando ela existir para evitar falhas silenciosas.
         * Centraliza a regra de selecao para manter o script simples.
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
         * Preenche a opcao padrao de perfil para acelerar testes da etapa.
         * Mantem a mesma opcao usada antes da refatoracao.
         */
        function fillTestDataStep() {
            setRadioValue('input[name="company_profile"][value="simples_nacional"]');
        }

        // Event listeners
        /**
         * Explica o que este listener escuta, o que ele dispara
         * e por que esse comportamento é necessário neste arquivo.
         */
        $fillTestDataButton.on('click', fillTestDataStep);
    </script>
@endsection
