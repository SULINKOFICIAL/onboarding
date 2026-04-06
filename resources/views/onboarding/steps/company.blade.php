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

    <div class="form-check mb-2">
        <input class="form-check-input" id="profile_lucro_presumido" type="radio" name="company_profile" value="lucro_presumido" @checked(old('company_profile', $data['company_profile'] ?? '') === 'lucro_presumido')>
        <label class="form-check-label" for="profile_lucro_presumido">Lucro Presumido</label>
    </div>
    <div class="form-check mb-2">
        <input class="form-check-input" id="profile_lucro_real" type="radio" name="company_profile" value="lucro_real" @checked(old('company_profile', $data['company_profile'] ?? '') === 'lucro_real')>
        <label class="form-check-label" for="profile_lucro_real">Lucro Real</label>
    </div>
    <div class="form-check mb-2">
        <input class="form-check-input" id="profile_simples_nacional" type="radio" name="company_profile" value="simples_nacional" @checked(old('company_profile', $data['company_profile'] ?? '') === 'simples_nacional')>
        <label class="form-check-label" for="profile_simples_nacional">Simples Nacional</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" id="profile_mei" type="radio" name="company_profile" value="mei" @checked(old('company_profile', $data['company_profile'] ?? '') === 'mei')>
        <label class="form-check-label" for="profile_mei">MEI</label>
    </div>
</div>

<div class="d-flex justify-content-between mt-4 gap-3">
    <button class="btn btn-outline-secondary" type="submit" name="navigation" value="back" formnovalidate>Voltar</button>
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
