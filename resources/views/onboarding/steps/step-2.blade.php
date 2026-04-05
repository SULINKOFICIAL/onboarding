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
            const radio = document.querySelector('input[name="company_profile"][value="simples_nacional"]');
            if (radio) {
                radio.checked = true;
            }
        });
    </script>
@endsection
