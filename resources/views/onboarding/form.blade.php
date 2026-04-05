<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MiCore Onboarding - Etapa {{ $step }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light" data-step="{{ $step }}">
    <div class="container-fluid">
        <div class="row min-vh-100">
            <div class="col-12 col-lg-6 bg-white d-flex align-items-center">
                <div class="w-100 px-4 px-md-5 py-4 mx-auto" style="max-width: 640px;">
                    <h1 class="h3 mb-3">Onboarding - Etapa {{ $step }} de 4</h1>

                    <div class="d-flex gap-2 mb-4">
                        <span class="badge {{ $step === 1 ? 'bg-primary' : 'bg-secondary' }}">1. Conta</span>
                        <span class="badge {{ $step === 2 ? 'bg-primary' : 'bg-secondary' }}">2. Empresa</span>
                        <span class="badge {{ $step === 3 ? 'bg-primary' : 'bg-secondary' }}">3. Endereço</span>
                        <span class="badge {{ $step === 4 ? 'bg-primary' : 'bg-secondary' }}">4. Plano</span>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('onboarding.submit', ['step' => $step]) }}">
                        @csrf

                        @if ($step === 1)
                            <div class="mb-3">
                                <label class="form-label" for="full_name">Nome</label>
                                <input class="form-control" id="full_name" name="full_name" value="{{ old('full_name', $data['full_name'] ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="email">E-mail</label>
                                <input class="form-control" id="email" type="email" name="email" value="{{ old('email', $data['email'] ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="phone">Numero</label>
                                <input class="form-control" id="phone" name="phone" value="{{ old('phone', $data['phone'] ?? '') }}">
                            </div>
                            <div class="mb-3" id="cnpj-field">
                                <label class="form-label" for="cnpj">CNPJ</label>
                                <input class="form-control" id="cnpj" name="cnpj" value="{{ old('cnpj', $data['cnpj'] ?? '') }}">
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" id="no_cnpj" type="checkbox" name="no_cnpj" value="1" @checked(old('no_cnpj', $data['no_cnpj'] ?? false))>
                                <label class="form-check-label" for="no_cnpj">Nao tenho CNPJ</label>
                            </div>
                            <div class="mb-3 d-none" id="cif-field">
                                <label class="form-label" for="cif">CIF</label>
                                <input class="form-control" id="cif" name="cif" value="{{ old('cif', $data['cif'] ?? '') }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password">Senha</label>
                                <input class="form-control" id="password" type="password" name="password" value="{{ old('password', $data['password'] ?? '') }}">
                            </div>
                            <div class="form-check mb-3">
                                <input class="form-check-input" id="has_coupon" type="checkbox" name="has_coupon" value="1" @checked(old('has_coupon', $data['has_coupon'] ?? false))>
                                <label class="form-check-label" for="has_coupon">Tenho cupom</label>
                            </div>
                            <div class="mb-3 d-none" id="coupon-field">
                                <label class="form-label" for="coupon_code">Cupom</label>
                                <input class="form-control" id="coupon_code" name="coupon_code" value="{{ old('coupon_code', $data['coupon_code'] ?? '') }}">
                            </div>
                        @endif

                        @if ($step === 2)
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
                        @endif

                        @if ($step === 3)
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
                        @endif

                        @if ($step === 4)
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
                                        >
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="company_number">Numero</label>
                                        <input
                                            class="form-control"
                                            id="company_number"
                                            name="company_number"
                                            value="{{ old('company_number', $data['company_number'] ?? '') }}"
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
                                    >
                                </div>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between mt-4">
                            @if ($step > 1)
                                <a class="btn btn-outline-secondary" href="{{ route('onboarding.step', ['step' => $step - 1]) }}">Voltar</a>
                            @else
                                <span></span>
                            @endif

                            <button class="btn btn-primary" type="submit">
                                {{ $step === 1 ? 'Comecar a testar' : ($step < 4 ? 'Continuar' : 'Finalizar') }}
                            </button>
                        </div>

                        @if ($step === 1)
                            <div class="mt-4">
                                <p class="fw-semibold mb-2">Receber dicas</p>
                                <div class="form-check">
                                    <input class="form-check-input" id="tips_whatsapp" type="checkbox" name="tips_whatsapp" value="1" @checked(old('tips_whatsapp', $data['tips_whatsapp'] ?? false))>
                                    <label class="form-check-label" for="tips_whatsapp">Receber por WhatsApp</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" id="tips_email" type="checkbox" name="tips_email" value="1" @checked(old('tips_email', $data['tips_email'] ?? false))>
                                    <label class="form-check-label" for="tips_email">Receber por e-mail</label>
                                </div>
                                <p class="text-muted small mt-3 mb-0">
                                    Este site e protegido por reCAPTCHA. A Politica de Privacidade e os Termos de Uso do Google se aplicam.
                                </p>
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center bg-secondary-subtle">
                <div class="w-100 px-4 px-md-5 py-4" style="max-width: 680px;">
                    <h2 class="h5 mb-3">Área para imagens</h2>
                    <p class="text-muted mb-4">Insira aqui as imagens, ilustrações ou banners do onboarding.</p>

                    <div class="row g-3">
                        <div class="col-12">
                            <div class="border rounded-3 bg-white p-2">
                                <img src="https://via.placeholder.com/900x360?text=Imagem+Principal" class="img-fluid rounded-2" alt="Placeholder principal">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded-3 bg-white p-2">
                                <img src="https://via.placeholder.com/420x240?text=Imagem+1" class="img-fluid rounded-2" alt="Placeholder 1">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded-3 bg-white p-2">
                                <img src="https://via.placeholder.com/420x240?text=Imagem+2" class="img-fluid rounded-2" alt="Placeholder 2">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button
        id="fill-test-data"
        type="button"
        class="btn btn-dark position-fixed bottom-0 end-0 m-4 shadow"
    >
        Preencher teste
    </button>
    <script>
        const currentStep = Number(document.body.dataset.step || 1);
        const noCnpjCheckbox = document.getElementById('no_cnpj');
        const cnpjField = document.getElementById('cnpj-field');
        const cnpjInput = document.getElementById('cnpj');
        const cifField = document.getElementById('cif-field');
        const cifInput = document.getElementById('cif');
        const hasCouponCheckbox = document.getElementById('has_coupon');
        const couponField = document.getElementById('coupon-field');
        const couponInput = document.getElementById('coupon_code');
        const companyZipCodeInput = document.getElementById('company_zip_code');
        const zipAddressFields = document.getElementById('zip-address-fields');
        const companyCityStateInput = document.getElementById('company_city_state');
        const companyAddressInput = document.getElementById('company_address');
        const companyNeighborhoodInput = document.getElementById('company_neighborhood');
        const fillTestDataButton = document.getElementById('fill-test-data');

        function toggleDocumentFields() {
            if (!noCnpjCheckbox || !cnpjField || !cifField) {
                return;
            }

            const withoutCnpj = noCnpjCheckbox.checked;
            cnpjField.classList.toggle('d-none', withoutCnpj);
            cifField.classList.toggle('d-none', !withoutCnpj);
        }

        function toggleCouponField() {
            if (!hasCouponCheckbox || !couponField) {
                return;
            }

            const hasCoupon = hasCouponCheckbox.checked;
            couponField.classList.toggle('d-none', !hasCoupon);
        }

        if (noCnpjCheckbox) {
            noCnpjCheckbox.addEventListener('change', toggleDocumentFields);
            toggleDocumentFields();
        }

        if (hasCouponCheckbox) {
            hasCouponCheckbox.addEventListener('change', toggleCouponField);
            toggleCouponField();
        }

        function setInputValue(id, value) {
            const element = document.getElementById(id);
            if (!element) {
                return;
            }
            element.value = value;
        }

        function setCheckedValue(id, checked) {
            const element = document.getElementById(id);
            if (!element) {
                return;
            }
            element.checked = checked;
            element.dispatchEvent(new Event('change'));
        }

        function setRadioValue(name, value) {
            const radio = document.querySelector(`input[name="${name}"][value="${value}"]`);
            if (!radio) {
                return;
            }
            radio.checked = true;
        }

        function fillCurrentStep() {
            if (currentStep === 1) {
                setInputValue('full_name', 'Usuario Teste');
                setInputValue('email', 'teste+onboarding@micore.com');
                setInputValue('phone', '11999999999');
                setCheckedValue('no_cnpj', false);
                setInputValue('cnpj', '12345678000199');
                setInputValue('password', 'Senha@12345');
                setCheckedValue('has_coupon', true);
                setInputValue('coupon_code', 'BEMVINDO10');
                setCheckedValue('tips_whatsapp', true);
                setCheckedValue('tips_email', true);
                return;
            }

            if (currentStep === 2) {
                setRadioValue('company_profile', 'simples_nacional');
                return;
            }

            if (currentStep === 3) {
                setRadioValue('main_goal', 'vender_online');
                return;
            }

            if (currentStep === 4) {
                setInputValue('company_zip_code', '01310-100');
                showZipAddressFields();
                setInputValue('company_city_state', 'Sao Paulo - SP');
                setInputValue('company_address', 'Avenida Paulista');
                setInputValue('company_neighborhood', 'Bela Vista');
                setInputValue('company_number', '1000');
                setInputValue('company_complement', 'Conjunto 101');
            }
        }

        if (fillTestDataButton) {
            fillTestDataButton.addEventListener('click', fillCurrentStep);
        }

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

        if (companyZipCodeInput) {
            companyZipCodeInput.addEventListener('input', function () {
                companyZipCodeInput.value = formatZipCode(companyZipCodeInput.value);
                if (companyZipCodeInput.value.replace(/\D/g, '').length === 8) {
                    showZipAddressFields();
                }
            });

            companyZipCodeInput.addEventListener('blur', function () {
                const zipCodeDigits = companyZipCodeInput.value.replace(/\D/g, '');
                if (zipCodeDigits.length === 8) {
                    showZipAddressFields();
                    lookupZipCode(zipCodeDigits);
                }
            });
        }
    </script>
</body>
</html>
