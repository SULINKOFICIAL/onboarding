<div class="mb-3">
    <span class="badge badge-success onboarding-trial-badge">30 dias gratuitos</span>
</div>
<div class="d-flex gap-2 mb-3" aria-label="Progresso do onboarding">
    <div class="flex-fill rounded-pill h-10px bg-primary"></div>
    <div class="flex-fill rounded-pill h-10px bg-primary"></div>
    <div class="flex-fill rounded-pill h-10px bg-gray-200"></div>
</div>

<div class="mb-10 me-md-13">
    <h1 class="fs-2x fw-bolder mt-6">
        Conte pra gente o perfil da sua empresa para personalizarmos sua experiência.
    </h1>

    <p class="text-gray-600">
        Conte pra gente o perfil da sua empresa para personalizarmos sua experiência.
    </p>
</div>

<div class="mb-12">
    <p class="form-label text-gray-700 fw-bolder mb-2">Qual o perfil da empresa?</p>

    <div class="row g-4">
        <div class="col-12 col-lg-6">
            <input class="btn-check" id="profile_lucro_presumido" type="radio" name="company_profile" value="lucro_presumido" autocomplete="off" @checked(old('company_profile', $data['company_profile'] ?? '') === 'lucro_presumido')>
            <label class="btn bg-gray-200 btn-success-mc rounded-4 p-6 text-start w-100 h-100 d-flex flex-column justify-content-center align-items-start" for="profile_lucro_presumido">
                <span class="fs-4 fw-bold text-gray-800 mb-1">Lucro Presumido</span>
                <span class="fs-6 text-gray-600 lh-sm fw-normal">Regime baseado na estimativa de lucro</span>
            </label>
        </div>

        <div class="col-12 col-lg-6">
            <input class="btn-check" id="profile_lucro_real" type="radio" name="company_profile" value="lucro_real" autocomplete="off" @checked(old('company_profile', $data['company_profile'] ?? '') === 'lucro_real')>
            <label class="btn bg-gray-200 btn-success-mc rounded-4 p-6 text-start w-100 h-100 d-flex flex-column justify-content-center align-items-start" for="profile_lucro_real">
                <span class="fs-4 fw-bold text-gray-800 mb-1">Lucro Real</span>
                <span class="fs-6 text-gray-600 lh-sm fw-normal">Regime baseado no lucro efetivo da empresa</span>
            </label>
        </div>

        <div class="col-12 col-lg-6">
            <input class="btn-check" id="profile_simples_nacional" type="radio" name="company_profile" value="simples_nacional" autocomplete="off" @checked(old('company_profile', $data['company_profile'] ?? '') === 'simples_nacional')>
            <label class="btn bg-gray-200 btn-success-mc rounded-4 p-6 text-start w-100 h-100 d-flex flex-column justify-content-center align-items-start" for="profile_simples_nacional">
                <span class="fs-4 fw-bold text-gray-800 mb-1">Simples Nacional</span>
                <span class="fs-6 text-gray-600 lh-sm fw-normal">Regime simplificado para microempresa e empresa de pequeno porte</span>
            </label>
        </div>

        <div class="col-12 col-lg-6">
            <input class="btn-check" id="profile_mei" type="radio" name="company_profile" value="mei" autocomplete="off" @checked(old('company_profile', $data['company_profile'] ?? '') === 'mei')>
            <label class="btn bg-gray-200 btn-success-mc rounded-4 p-6 text-start w-100 h-100 d-flex flex-column justify-content-center align-items-start" for="profile_mei">
                <span class="fs-4 fw-bold text-gray-800 mb-1">MEI</span>
                <span class="fs-6 text-gray-600 lh-sm fw-normal">Regime simplificado para microempreendedor individual</span>
            </label>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between mt-4 gap-3">
    <button class="btn btn-light" type="submit" name="navigation" value="back" formnovalidate>Voltar</button>
    <button class="btn btn-primary w-100" type="submit" name="navigation" value="next">Continuar</button>
</div>

<button
    id="fill-test-data-company"
    type="button"
    class="btn btn-dark position-fixed bottom-0 end-0 m-4 shadow"
>
    Preencher teste
</button>

<script>
    $(function () {
        function syncCompanyProfileActiveState() {
            $('.btn-success-mc').removeClass('active');
            $('input[name="company_profile"]:checked').each(function () {
                $(`label[for="${this.id}"]`).addClass('active');
            });
        }

        $('input[name="company_profile"]').on('change', syncCompanyProfileActiveState);
        $('.btn-success-mc').on('click', function () {
            $('.btn-success-mc').removeClass('active');
            $(this).addClass('active');
        });

        $('#fill-test-data-company').on('click', function () {
            $('input[name="company_profile"][value="simples_nacional"]').prop('checked', true).trigger('change');
        });

        syncCompanyProfileActiveState();
    });
</script>
