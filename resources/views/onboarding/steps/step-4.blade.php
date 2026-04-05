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

<button
    id="fill-test-data"
    type="button"
    class="btn btn-dark position-fixed bottom-0 end-0 m-4 shadow"
>
    Preencher teste
</button>

@section('custom-footer')
    <script>
        const companyZipCodeInput = document.getElementById('company_zip_code');
        const zipAddressFields = document.getElementById('zip-address-fields');
        const companyCityStateInput = document.getElementById('company_city_state');
        const companyAddressInput = document.getElementById('company_address');
        const companyNeighborhoodInput = document.getElementById('company_neighborhood');

        function showZipAddressFields() {
            if (!zipAddressFields) {
                return;
            }
            zipAddressFields.classList.remove('d-none');
        }

        function formatZipCode(value) {
            const digits = value.replace(/\D/g, '').slice(0, 8);
            if (digits.length <= 5) {
                return digits;
            }
            return `${digits.slice(0, 5)}-${digits.slice(5)}`;
        }

        async function lookupZipCode(zipCodeDigits) {
            try {
                const response = await fetch(`https://viacep.com.br/ws/${zipCodeDigits}/json/`);
                if (!response.ok) {
                    return;
                }

                const payload = await response.json();
                if (payload.erro) {
                    return;
                }

                if (companyCityStateInput) {
                    companyCityStateInput.value = `${payload.localidade || ''} - ${payload.uf || ''}`.trim();
                }
                if (companyAddressInput) {
                    companyAddressInput.value = payload.logradouro || '';
                }
                if (companyNeighborhoodInput) {
                    companyNeighborhoodInput.value = payload.bairro || '';
                }
            } catch (error) {
                console.error('Falha ao buscar CEP', error);
            }
        }

        companyZipCodeInput?.addEventListener('input', function () {
            companyZipCodeInput.value = formatZipCode(companyZipCodeInput.value);
            if (companyZipCodeInput.value.replace(/\D/g, '').length === 8) {
                showZipAddressFields();
            }
        });

        companyZipCodeInput?.addEventListener('blur', function () {
            const zipCodeDigits = companyZipCodeInput.value.replace(/\D/g, '');
            if (zipCodeDigits.length === 8) {
                showZipAddressFields();
                lookupZipCode(zipCodeDigits);
            }
        });

        document.getElementById('fill-test-data')?.addEventListener('click', function () {
            companyZipCodeInput.value = '01310-100';
            showZipAddressFields();
            document.getElementById('company_city_state').value = 'Sao Paulo - SP';
            document.getElementById('company_address').value = 'Avenida Paulista';
            document.getElementById('company_neighborhood').value = 'Bela Vista';
            document.getElementById('company_number').value = '1000';
            document.getElementById('company_complement').value = 'Conjunto 101';
        });
    </script>
@endsection
