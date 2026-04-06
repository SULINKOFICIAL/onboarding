<h1 class="fs-2x fw-bolder mt-6 mb-10 me-md-13">
    Finalize seu cadastro com o endereco da empresa e comece a testar.
</h1>

<div class="mb-3">
    <label class="form-label" for="company_zip_code">Qual o CEP da empresa?</label>
    <input
        class="form-control"
        id="company_zip_code"
        name="company_zip_code"
        value="{{ old('company_zip_code', $data['company_zip_code'] ?? '') }}"
        maxlength="9"
        placeholder="00000-000"
    >
</div>

<div id="zip-address-fields" class="{{ old('company_zip_code', $data['company_zip_code'] ?? '') ? '' : 'd-none' }}">
    <div class="mb-3">
        <label class="form-label" for="company_city_state">Cidade, estado</label>
        <input
            class="form-control"
            id="company_city_state"
            name="company_city_state"
            value="{{ old('company_city_state', $data['company_city_state'] ?? '') }}"
            placeholder="Cidade - UF"
        >
    </div>
    <div class="mb-3">
        <label class="form-label" for="company_address">Endereco</label>
        <input
            class="form-control"
            id="company_address"
            name="company_address"
            value="{{ old('company_address', $data['company_address'] ?? '') }}"
            placeholder="Rua, avenida, etc."
        >
    </div>
    <div class="row g-3 mb-3">
        <div class="col-md-8">
            <label class="form-label" for="company_neighborhood">Bairro</label>
            <input
                class="form-control"
                id="company_neighborhood"
                name="company_neighborhood"
                value="{{ old('company_neighborhood', $data['company_neighborhood'] ?? '') }}"
                placeholder="Nome do bairro"
            >
        </div>
        <div class="col-md-4">
            <label class="form-label" for="company_number">Numero</label>
            <input
                class="form-control"
                id="company_number"
                name="company_number"
                value="{{ old('company_number', $data['company_number'] ?? '') }}"
                placeholder="Nº"
            >
        </div>
    </div>
    <div class="mb-3">
        <label class="form-label" for="company_complement">Complemento</label>
        <input
            class="form-control"
            id="company_complement"
            name="company_complement"
            value="{{ old('company_complement', $data['company_complement'] ?? '') }}"
            placeholder="Apto, bloco, sala (opcional)"
        >
    </div>
</div>

<div class="mt-4">
    <button class="btn btn-primary w-100" type="submit" name="navigation" value="next">Finalizar</button>
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
        const $companyZipCodeInput = $('#company_zip_code');
        const $zipAddressFields = $('#zip-address-fields');
        const $companyCityStateInput = $('#company_city_state');
        const $companyAddressInput = $('#company_address');
        const $companyNeighborhoodInput = $('#company_neighborhood');
        const $fillTestDataButton = $('#fill-test-data');

        // Helpers / utilitários
        /**
         * Retorna apenas os digitos do CEP para garantir validacao consistente.
         * Centraliza a regra de higienizacao usada em mais de um ponto.
         */
        function getZipCodeDigits(value) {
            return value.replace(/\D/g, '').slice(0, 8);
        }

        /**
         * Formata CEP no padrao 00000-000 sem alterar a regra de preenchimento.
         * Mantem o mesmo comportamento do fluxo anterior.
         */
        function formatZipCode(value) {
            const zipCodeDigits = getZipCodeDigits(value);
            if (zipCodeDigits.length <= 5) {
                return zipCodeDigits;
            }

            return `${zipCodeDigits.slice(0, 5)}-${zipCodeDigits.slice(5)}`;
        }

        // Funções de renderização / UI
        /**
         * Exibe campos de endereco quando o CEP estiver completo.
         * Evita esconder campos ja preenchidos apos interacoes do usuario.
         */
        function showZipAddressFields() {
            if (!$zipAddressFields.length) {
                return;
            }

            $zipAddressFields.removeClass('d-none');
        }

        /**
         * Preenche campos de endereco com resposta da API do CEP.
         * Usa fallback vazio para manter estabilidade quando dados vierem incompletos.
         */
        function applyZipCodePayload(payload) {
            $companyCityStateInput.val(`${payload.localidade || ''} - ${payload.uf || ''}`.trim());
            $companyAddressInput.val(payload.logradouro || '');
            $companyNeighborhoodInput.val(payload.bairro || '');
        }

        /**
         * Consulta o CEP na API e aplica os dados quando o retorno for valido.
         * Mantem o comportamento de nao interromper o fluxo em caso de erro de rede.
         */
        function lookupZipCode(zipCodeDigits) {
            return $.getJSON(`https://viacep.com.br/ws/${zipCodeDigits}/json/`)
                .done(function (payload) {
                    // Se a API indicar CEP invalido, nao atualiza os campos.
                    if (payload.erro) {
                        return;
                    }

                    applyZipCodePayload(payload);
                })
                .fail(function (error) {
                    console.error('Falha ao buscar CEP', error);
                });
        }

        /**
         * Preenche dados de teste da etapa de endereco para acelerar validacoes.
         * Mantem os mesmos valores usados anteriormente.
         */
        function fillTestDataStep() {
            $companyZipCodeInput.val('01310-100');
            showZipAddressFields();
            $companyCityStateInput.val('Sao Paulo - SP');
            $companyAddressInput.val('Avenida Paulista');
            $companyNeighborhoodInput.val('Bela Vista');
            $('#company_number').val('1000');
            $('#company_complement').val('Conjunto 101');
        }

        // Event listeners
        /**
         * Explica o que este listener escuta, o que ele dispara
         * e por que esse comportamento é necessário neste arquivo.
         */
        $companyZipCodeInput.on('input', function () {
            const formattedZipCode = formatZipCode($companyZipCodeInput.val() || '');
            $companyZipCodeInput.val(formattedZipCode);

            // Exibe os campos assim que houver CEP completo para reduzir friccao.
            if (getZipCodeDigits(formattedZipCode).length === 8) {
                showZipAddressFields();
            }
        });

        /**
         * Explica o que este listener escuta, o que ele dispara
         * e por que esse comportamento é necessário neste arquivo.
         */
        $companyZipCodeInput.on('blur', function () {
            const zipCodeDigits = getZipCodeDigits($companyZipCodeInput.val() || '');
            if (zipCodeDigits.length !== 8) {
                return;
            }

            showZipAddressFields();
            lookupZipCode(zipCodeDigits);
        });

        /**
         * Explica o que este listener escuta, o que ele dispara
         * e por que esse comportamento é necessário neste arquivo.
         */
        $fillTestDataButton.on('click', fillTestDataStep);
    </script>
@endsection
