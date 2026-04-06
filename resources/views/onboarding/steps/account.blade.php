<div class="mb-3">
    <span class="badge badge-success onboarding-trial-badge">30 dias gratuitos</span>
</div>
<div class="d-flex gap-2 mb-3" aria-label="Progresso do onboarding">
    <div class="flex-fill rounded-pill h-10px bg-primary"></div>
    <div class="flex-fill rounded-pill h-10px bg-gray-200"></div>
    <div class="flex-fill rounded-pill h-10px bg-gray-200"></div>
</div>

<h1 class="fs-2x fw-bolder mt-6 mb-10 me-md-13">
    Experimente o mi.Core: organize seu atendimento e impulsione o crescimento da sua empresa.
</h1>

<div class="mb-3">
    <label class="form-label text-gray-700 fw-bolder mb-0" for="full_name">Nome</label>
    <input class="form-control" id="full_name" name="full_name" value="{{ old('full_name', $data['full_name'] ?? '') }}" placeholder="Digite seu nome completo">
</div>
<div class="mb-3">
    <label class="form-label text-gray-700 fw-bolder mb-0" for="email">E-mail</label>
    <input class="form-control" id="email" type="email" name="email" value="{{ old('email', $data['email'] ?? '') }}" placeholder="voce@empresa.com">
</div>
<div class="mb-3">
    <label class="form-label text-gray-700 fw-bolder mb-0" for="phone">Numero</label>
    <input class="form-control input-phone" id="phone" name="phone" value="{{ old('phone', $data['phone'] ?? '') }}" placeholder="(11) 99999-9999">
</div>
<div class="mb-3 d-none" id="cpf-field">
    <label class="form-label text-gray-700 fw-bolder mb-0" for="cpf">CPF</label>
    <input class="form-control input-cpf" id="cpf" name="cpf" value="{{ old('cpf', $data['cpf'] ?? ($data['cif'] ?? '')) }}" placeholder="000.000.000-00">
    <div id="cpf-error" class="invalid-feedback d-none">Informe um CPF valido.</div>
</div>
<div class="mb-3" id="cnpj-field">
    <label class="form-label text-gray-700 fw-bolder mb-0" for="cnpj">CNPJ</label>
    <input class="form-control input-cnpj" id="cnpj" name="cnpj" value="{{ old('cnpj', $data['cnpj'] ?? '') }}" placeholder="00.000.000/0000-00">
</div>
<div class="form-check mb-3">
    <input class="form-check-input" id="no_cnpj" type="checkbox" name="no_cnpj" value="1" @checked(old('no_cnpj', $data['no_cnpj'] ?? false))>
    <label class="form-check-label" for="no_cnpj">Nao tenho CNPJ</label>
</div>
<div class="mb-3">
    <label class="form-label text-gray-700 fw-bolder mb-0" for="password">Senha</label>
    <input class="form-control" id="password" type="password" name="password" value="{{ old('password', $data['password'] ?? '') }}" placeholder="Crie uma senha">
</div>
<div class="form-check mb-3">
    <input class="form-check-input" id="has_coupon" type="checkbox" name="has_coupon" value="1" @checked(old('has_coupon', $data['has_coupon'] ?? false))>
    <label class="form-check-label" for="has_coupon">Tenho cupom</label>
</div>
<div class="mb-3 d-none" id="coupon-field">
    <label class="form-label text-gray-700 fw-bolder mb-0" for="coupon_code">Cupom</label>
    <input class="form-control" id="coupon_code" name="coupon_code" value="{{ old('coupon_code', $data['coupon_code'] ?? '') }}" placeholder="Digite o código do cupom">
</div>

<button
    id="fill-test-data-account"
    type="button"
    class="btn btn-dark position-fixed bottom-0 end-0 m-4 shadow"
>
    Preencher teste
</button>

<div class="d-flex justify-content-between mt-4">
    <span></span>
    <button class="btn btn-primary w-100" type="submit" name="navigation" value="next">
        Comecar a testar
    </button>
</div>

@push('step-scripts')
<script>
    $(function () {
        // Estado global
        const $noCnpjCheckbox = $('#no_cnpj');
        const $cnpjField = $('#cnpj-field');
        const $cpfField = $('#cpf-field');
        const $hasCouponCheckbox = $('#has_coupon');
        const $couponField = $('#coupon-field');
        const $fillTestDataButton = $('#fill-test-data-account');
        const $cpfInput = $('#cpf');
        const $cpfError = $('#cpf-error');

        // Helpers / utilitarios
        /**
         * Remove caracteres nao numericos de um valor digitado no formulario.
         * Centraliza conversao para validacoes e comparacoes numericas.
         */
        function getDigits(value) {
            return (value || '').replace(/\D/g, '');
        }

        /**
         * Valida os digitos verificadores de um CPF informado pelo usuario.
         * Evita aceitar combinacoes invalidas ou sequenciais repetidas.
         */
        function isValidCpf(value) {
            const cpfDigits = getDigits(value);
            if (cpfDigits.length !== 11 || /^(\d)\1{10}$/.test(cpfDigits)) {
                return false;
            }

            let firstDigitSum = 0;
            for (let index = 0; index < 9; index += 1) {
                firstDigitSum += Number(cpfDigits.charAt(index)) * (10 - index);
            }

            let firstDigit = (firstDigitSum * 10) % 11;
            if (firstDigit === 10) {
                firstDigit = 0;
            }

            if (firstDigit !== Number(cpfDigits.charAt(9))) {
                return false;
            }

            let secondDigitSum = 0;
            for (let index = 0; index < 10; index += 1) {
                secondDigitSum += Number(cpfDigits.charAt(index)) * (11 - index);
            }

            let secondDigit = (secondDigitSum * 10) % 11;
            if (secondDigit === 10) {
                secondDigit = 0;
            }

            return secondDigit === Number(cpfDigits.charAt(10));
        }

        // Funcoes de renderizacao / UI
        /**
         * Exibe mensagem de erro para o campo CPF quando a validacao falha.
         * Mantem o feedback visual padronizado com classes do Bootstrap.
         */
        function showCpfError() {
            $cpfInput.addClass('is-invalid');
            $cpfError.removeClass('d-none');
        }

        /**
         * Remove o estado de erro do CPF para evitar mensagens persistentes.
         * E usada quando o usuario corrige o valor ou muda de contexto.
         */
        function hideCpfError() {
            $cpfInput.removeClass('is-invalid');
            $cpfError.addClass('d-none');
        }

        /**
         * Alterna entre campos de CNPJ e CPF conforme opcao do usuario.
         * Mantem o erro de CPF oculto quando o documento nao e necessario.
         */
        function toggleDocumentFields() {
            const withoutCnpj = $noCnpjCheckbox.is(':checked');
            $cnpjField.toggleClass('d-none', withoutCnpj);
            $cpfField.toggleClass('d-none', !withoutCnpj);
            if (!withoutCnpj) {
                hideCpfError();
            }
        }

        /**
         * Exibe ou oculta o campo de cupom com base na selecao atual.
         * Evita mostrar campo opcional quando a opcao nao foi marcada.
         */
        function toggleCouponField() {
            $couponField.toggleClass('d-none', !$hasCouponCheckbox.is(':checked'));
        }

        /**
         * Preenche dados de exemplo para acelerar testes do step account.
         * Reaplica mascaras ao final para refletir o formato visual esperado.
         */
        function fillTestDataStep() {
            $('#full_name').val('Usuario Teste');
            $('#email').val('teste+onboarding@micore.com');
            $('#phone').val('11999999999');
            $('#no_cnpj').prop('checked', false).trigger('change');
            $('#cnpj').val('12345678000199');
            $('#password').val('Senha@12345');
            $('#has_coupon').prop('checked', true).trigger('change');
            $('#coupon_code').val('BEMVINDO10');
            $('#tips_whatsapp').prop('checked', true);
            $('#tips_email').prop('checked', true);

            if (typeof generateMasks === 'function') {
                generateMasks();
            }
        }

        /**
         * Valida CPF considerando estado do checkbox e modo forcar validacao.
         * Retorna true quando nao houver erro bloqueante para o step.
         */
        function validateCpfField(forceValidation = false) {
            if (!$noCnpjCheckbox.is(':checked')) {
                hideCpfError();
                return true;
            }

            const cpfDigits = getDigits($cpfInput.val());
            if (!cpfDigits.length) {
                if (forceValidation) {
                    showCpfError();
                    return false;
                }

                hideCpfError();
                return true;
            }

            if (isValidCpf($cpfInput.val())) {
                hideCpfError();
                return true;
            }

            showCpfError();
            return false;
        }

        /**
         * Executa validacoes do step account antes de avancar no wizard.
         * Garante foco no campo CPF quando houver erro de preenchimento.
         */
        function validateAccountStep() {
            const isCpfValid = validateCpfField(true);
            if (!isCpfValid) {
                $cpfInput.trigger('focus');
            }

            return isCpfValid;
        }

        // Event listeners
        /**
         * Escuta mudanca no checkbox de CNPJ para atualizar os campos visiveis
         * e manter a interface coerente com o tipo de documento escolhido.
         */
        $noCnpjCheckbox.on('change', toggleDocumentFields);

        /**
         * Escuta mudanca na opcao de cupom e controla a exibicao do campo.
         * Evita estados inconsistentes entre checkbox e input de codigo.
         */
        $hasCouponCheckbox.on('change', toggleCouponField);

        /**
         * Escuta clique no botao de preenchimento para inserir dados de teste
         * e facilitar validacoes manuais durante o desenvolvimento.
         */
        $fillTestDataButton.on('click', fillTestDataStep);

        /**
         * Escuta digitacao no CPF para validar apenas quando houver 11 digitos
         * e evitar feedback de erro prematuro durante o preenchimento.
         */
        $cpfInput.on('input', function () {
            if (!$noCnpjCheckbox.is(':checked')) {
                hideCpfError();
                return;
            }

            if (getDigits($cpfInput.val()).length === 11) {
                validateCpfField();
                return;
            }

            hideCpfError();
        });

        /**
         * Escuta saida do campo CPF para validar valor completo digitado
         * e manter a regra de erro apenas quando o documento estiver finalizado.
         */
        $cpfInput.on('blur', function () {
            if (!$noCnpjCheckbox.is(':checked')) {
                hideCpfError();
                return;
            }

            if (getDigits($cpfInput.val()).length === 11) {
                validateCpfField(true);
                return;
            }

            hideCpfError();
        });

        /**
         * Escuta mudanca no checkbox de CNPJ para limpar erro residual do CPF
         * quando o usuario alterna rapidamente entre os tipos de documento.
         */
        $noCnpjCheckbox.on('change', hideCpfError);

        if (typeof generateMasks === 'function') {
            generateMasks();
        }

        window.validateAccountStep = validateAccountStep;

        toggleDocumentFields();
        toggleCouponField();
    });
</script>
@endpush

<div class="mt-15">
    <p class="form-label text-gray-700 fw-bolder mb-1">Receber dicas</p>
    <div class="d-flex gap-4">
        <div class="form-check">
            <input class="form-check-input" id="tips_whatsapp" type="checkbox" name="tips_whatsapp" value="1" @checked(old('tips_whatsapp', $data['tips_whatsapp'] ?? false))>
            <label class="form-check-label" for="tips_whatsapp">Receber por WhatsApp</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" id="tips_email" type="checkbox" name="tips_email" value="1" @checked(old('tips_email', $data['tips_email'] ?? false))>
            <label class="form-check-label" for="tips_email">Receber por e-mail</label>
        </div>
    </div>
    <p class="text-muted small mt-3 mb-0">
        Este site e protegido por reCAPTCHA. A Politica de Privacidade e os Termos de Uso do Google se aplicam.
    </p>
</div>
