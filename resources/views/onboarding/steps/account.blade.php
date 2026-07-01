<div class="mb-3">
    <span class="badge badge-success onboarding-trial-badge">7 dias gratuitos</span>
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
    <input class="form-control" id="full_name" name="full_name" value="{{ old('full_name', $data['full_name'] ?? '') }}" placeholder="Como deseja que chamemos você?" required>
    <div id="full-name-error" class="invalid-feedback d-none">Informe nome e sobrenome.</div>
</div>
<div class="mb-3">
    <label class="form-label text-gray-700 fw-bolder mb-0" for="email">E-mail</label>
    <input class="form-control" id="email" type="email" name="email" value="{{ old('email', $data['email'] ?? '') }}" placeholder="voce@empresa.com" required>
    <div id="email-error" class="invalid-feedback d-none">
        Já existe uma conta associada com esse email no mi.Core. Utilize outro email para continuar
    </div>
</div>
<div class="mb-3">
    <label class="form-label text-gray-700 fw-bolder mb-0" for="phone">Número</label>
    <input class="form-control" id="phone" name="phone" value="{{ old('phone', $data['phone'] ?? '') }}" placeholder="(11) 99999-9999" required>
</div>
<div class="mb-3 d-none" id="cpf-field">
    <label class="form-label text-gray-700 fw-bolder mb-0" for="cpf">CPF</label>
    <input class="form-control" id="cpf" name="cpf" value="{{ old('cpf', $data['cpf'] ?? ($data['cif'] ?? '')) }}" placeholder="000.000.000-00" required>
    <div id="cpf-error" class="invalid-feedback d-none">Informe um CPF valido.</div>
    <div id="cpf-exists-error" class="invalid-feedback d-none">Já existe uma conta associada com esse CPF no mi.Core. Utilize outro CPF para continuar</div>
</div>
<div class="mb-3" id="cnpj-field">
    <label class="form-label text-gray-700 fw-bolder mb-0" for="cnpj">CNPJ</label>
    <input class="form-control" id="cnpj" name="cnpj" value="{{ old('cnpj', $data['cnpj'] ?? '') }}" placeholder="00.000.000/0000-00" required>
    <div id="cnpj-exists-error" class="invalid-feedback d-none">Já existe uma conta associada com esse CNPJ no mi.Core. Utilize outro CNPJ para continuar</div>
</div>
<input
    type="hidden"
    id="document_type"
    name="document_type"
    value="{{ old('document_type', $data['document_type'] ?? ((old('no_cnpj', $data['no_cnpj'] ?? false)) ? 'cpf' : 'cnpj')) }}"
>
<div class="form-check mb-3">
    <input class="form-check-input" id="no_cnpj" type="checkbox" @checked(old('document_type', $data['document_type'] ?? ((old('no_cnpj', $data['no_cnpj'] ?? false)) ? 'cpf' : 'cnpj')) === 'cpf')>
    <label class="form-check-label" for="no_cnpj">Nao tenho CNPJ</label>
</div>
<div class="mb-3">
    <label class="form-label text-gray-700 fw-bolder mb-0" for="password">Senha</label>
    <div class="position-relative">
        <input class="form-control pe-12" id="password" type="password" name="password" value="{{ old('password', $data['password'] ?? '') }}" placeholder="Crie uma senha" minlength="8" maxlength="32" required>
        <button
            id="toggle-password-visibility"
            type="button"
            class="btn btn-sm btn-icon position-absolute top-50 end-0 translate-middle-y me-1 border-0 bg-transparent text-muted bg-white"
            aria-label="Mostrar ou ocultar senha"
        >
            <i id="toggle-password-icon" class="fa-regular fa-eye fs-5"></i>
        </button>
    </div>
    <div id="password-rules" class="d-none mt-3">
        <div class="small text-muted mb-2">Sua senha precisa conter:</div>
        <ul class="list-unstyled mb-0 small" id="password-rules-list">
            <li class="d-flex align-items-center gap-2 mb-1" data-rule="length">
                <i class="fa-solid fa-xmark text-danger"></i>
                <span class="text-gray-700">Mínimo 8 e máximo 32 caracteres</span>
            </li>
            <li class="d-flex align-items-center gap-2 mb-1" data-rule="uppercase">
                <i class="fa-solid fa-xmark text-danger"></i>
                <span class="text-gray-700">Ao menos 1 letra maiúscula</span>
            </li>
            <li class="d-flex align-items-center gap-2 mb-1" data-rule="lowercase">
                <i class="fa-solid fa-xmark text-danger"></i>
                <span class="text-gray-700">Ao menos 1 letra minúscula</span>
            </li>
            <li class="d-flex align-items-center gap-2 mb-1" data-rule="number">
                <i class="fa-solid fa-xmark text-danger"></i>
                <span class="text-gray-700">Ao menos 1 número</span>
            </li>
            <li class="d-flex align-items-center gap-2" data-rule="special">
                <i class="fa-solid fa-xmark text-danger"></i>
                <span class="text-gray-700">Ao menos 1 caractere especial</span>
            </li>
        </ul>
    </div>
</div>
{{-- <div class="form-check mb-3">
    <input class="form-check-input" id="has_coupon" type="checkbox" name="has_coupon" value="1" @checked(old('has_coupon', $data['has_coupon'] ?? false))>
    <label class="form-check-label" for="has_coupon">Tenho cupom</label>
</div>
<div class="mb-3 d-none" id="coupon-field">
    <label class="form-label text-gray-700 fw-bolder mb-0" for="coupon_code">Cupom</label>
    <input class="form-control" id="coupon_code" name="coupon_code" value="{{ old('coupon_code', $data['coupon_code'] ?? '') }}" placeholder="Digite o código do cupom">
</div> --}}

@env('local')
    <button
        id="fill-test-data-account"
        type="button"
        class="btn btn-dark position-fixed bottom-0 end-0 m-4 shadow"
    >
        Preencher teste
    </button>
@endenv

<div class="d-flex justify-content-between mt-4">
    <span></span>
    <button class="btn btn-primary w-100" type="submit" name="navigation" value="next" disabled>
        Comecar a testar
    </button>
</div>

@push('step-scripts')
<script>
    $(function () {
        // Estado global
        const checkEmailUrl = '{{ route('onboarding.check-email') }}';
        const checkDocumentUrl = '{{ route('onboarding.check-document') }}';
        const $noCnpjCheckbox = $('#no_cnpj');
        const $cnpjField = $('#cnpj-field');
        const $cpfField = $('#cpf-field');
        const $hasCouponCheckbox = $('#has_coupon');
        const $couponField = $('#coupon-field');
        const $fillTestDataButton = $('#fill-test-data-account');
        const $nextStepButton = $('.onboarding-step[data-step="account"] button[name="navigation"][value="next"]');
        const $fullNameInput = $('#full_name');
        const $fullNameError = $('#full-name-error');
        const $emailInput = $('#email');
        const $emailError = $('#email-error');
        const $phoneInput = $('#phone');
        const $cpfInput = $('#cpf');
        const $cnpjInput = $('#cnpj');
        const $cpfError = $('#cpf-error');
        const $cpfExistsError = $('#cpf-exists-error');
        const $cnpjExistsError = $('#cnpj-exists-error');
        const $passwordInput = $('#password');
        const $passwordToggleButton = $('#toggle-password-visibility');
        const $passwordToggleIcon = $('#toggle-password-icon');
        const $passwordRules = $('#password-rules');
        const $passwordRulesList = $('#password-rules-list');
        const $documentTypeInput = $('#document_type');
        let hasInteractedWithFullName = false;
        let hasInteractedWithEmail = false;
        let hasInteractedWithCpf = false;
        let hasInteractedWithCnpj = false;
        let hasInteractedWithPassword = false;
        let isEmailCheckLoading = false;
        let isEmailAlreadyRegistered = false;
        let checkedEmail = '';
        let activeEmailRequestId = 0;
        let isDocumentCheckLoading = false;
        let isDocumentAlreadyRegistered = false;
        let checkedDocumentType = '';
        let checkedDocumentValue = '';
        let activeDocumentRequestId = 0;
        let hasPhoneMaskApplied = false;
        let hasCpfMaskApplied = false;
        let hasCnpjMaskApplied = false;

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

        /**
         * Valida se o nome contem ao menos nome e sobrenome.
         * Garante um preenchimento mínimo de nome completo.
         */
        function isValidFullName(value) {
            const normalizedName = (value || '').trim().replace(/\s+/g, ' ');
            const nameParts = normalizedName.split(' ').filter(Boolean);
            return nameParts.length >= 2;
        }

        /**
         * Normaliza o email para comparacoes de estado entre validacoes.
         * Evita duplicar consultas para o mesmo valor digitado.
         */
        function getNormalizedEmail(value) {
            return (value || '').trim().toLowerCase();
        }

        /**
         * Verifica se o email atende as regras basicas do input HTML.
         * Reaproveita validacao nativa do navegador para reduzir regra manual.
         */
        function isEmailSyntaxValid() {
            const emailValue = getNormalizedEmail($emailInput.val());
            if (!emailValue.length) {
                return false;
            }

            return $emailInput.get(0).checkValidity();
        }

        /**
         * Avalia todos os criterios de senha forte exigidos no cadastro.
         * Centraliza regras para reuso no checklist e bloqueio de avanço.
         */
        function getPasswordRulesStatus(value) {
            const passwordValue = value || '';

            return {
                length: passwordValue.length >= 8 && passwordValue.length <= 32,
                uppercase: /[A-Z]/.test(passwordValue),
                lowercase: /[a-z]/.test(passwordValue),
                number: /[0-9]/.test(passwordValue),
                special: /[^A-Za-z0-9]/.test(passwordValue),
            };
        }

        /**
         * Retorna true quando a senha atende todos os criterios obrigatorios.
         * Evita duplicar validacoes em varios pontos do fluxo.
         */
        function isStrongPassword(value) {
            const rulesStatus = getPasswordRulesStatus(value);
            return Object.keys(rulesStatus).every(function (ruleKey) {
                return rulesStatus[ruleKey];
            });
        }

        /**
         * Aplica mascara de telefone quando usuario foca no campo.
         * Evita inicializacao global e preserva navegacao de teclado.
         */
        function applyPhoneMaskIfNeeded() {
            if (hasPhoneMaskApplied || typeof Inputmask === 'undefined') {
                return;
            }

            Inputmask(["(99) 9999-9999", "(99) 9 9999-9999"], {
                clearIncomplete: true,
            }).mask($phoneInput.get(0));

            hasPhoneMaskApplied = true;
        }

        /**
         * Aplica mascara de CPF assim que o campo recebe foco.
         * Evita inicializacao global para manter foco e tab navegaveis.
         */
        function applyCpfMaskIfNeeded() {
            if (hasCpfMaskApplied || typeof Inputmask === 'undefined') {
                return;
            }

            Inputmask(["999.999.999-99"], {
                clearIncomplete: true,
            }).mask($cpfInput.get(0));

            hasCpfMaskApplied = true;
        }

        /**
         * Aplica mascara de CNPJ assim que o campo recebe foco.
         * Evita inicializacao global para manter foco e tab navegaveis.
         */
        function applyCnpjMaskIfNeeded() {
            if (hasCnpjMaskApplied || typeof Inputmask === 'undefined') {
                return;
            }

            Inputmask(["99.999.999/9999-99"], {
                clearIncomplete: true,
            }).mask($cnpjInput.get(0));

            hasCnpjMaskApplied = true;
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
            $cpfError.addClass('d-none');
            if ($cpfExistsError.hasClass('d-none')) {
                $cpfInput.removeClass('is-invalid');
            }
        }

        /**
         * Exibe feedback de erro para nome completo em formato inválido.
         * Reaproveita classes nativas do Metronic/Bootstrap.
         */
        function showFullNameError() {
            $fullNameInput.addClass('is-invalid');
            $fullNameError.removeClass('d-none');
        }

        /**
         * Remove feedback de erro visual do nome quando valor estiver válido.
         * Evita mensagem residual durante correção do campo.
         */
        function hideFullNameError() {
            $fullNameInput.removeClass('is-invalid');
            $fullNameError.addClass('d-none');
        }

        /**
         * Exibe mensagem quando o email informado ja existe na central.
         * Mantem padrao visual de erro com classes nativas do Bootstrap.
         */
        function showEmailError() {
            $emailInput.addClass('is-invalid');
            $emailError.removeClass('d-none');
        }

        /**
         * Limpa mensagem de erro do email ao alterar valor do campo.
         * Evita exibir estado invalido para um novo email ainda nao testado.
         */
        function hideEmailError() {
            $emailInput.removeClass('is-invalid');
            $emailError.addClass('d-none');
        }

        /**
         * Atualiza icones do checklist da senha para X ou check.
         * Mantem feedback visual imediato para cada regra.
         */
        function renderPasswordRules() {
            const rulesStatus = getPasswordRulesStatus($passwordInput.val());

            Object.keys(rulesStatus).forEach(function (ruleName) {
                const $ruleItem = $passwordRulesList.find(`[data-rule="${ruleName}"]`);
                const $ruleIcon = $ruleItem.find('i');
                const isRuleValid = rulesStatus[ruleName];

                $ruleIcon
                    .toggleClass('fa-check text-success', isRuleValid)
                    .toggleClass('fa-xmark text-danger', !isRuleValid);
            });
        }

        /**
         * Exibe o checklist de senha assim que houver interacao no campo.
         * Evita poluir a tela antes de o usuario iniciar a digitacao.
         */
        function togglePasswordRulesVisibility() {
            $passwordRules.toggleClass('d-none', !hasInteractedWithPassword);
        }

        /**
         * Exibe mensagem de documento ja vinculado na central.
         * Mantem o campo com estilo de erro padrao do Bootstrap.
         */
        function showDocumentExistsError(documentType) {
            if (documentType === 'cpf') {
                $cpfInput.addClass('is-invalid');
                $cpfExistsError.removeClass('d-none');
                return;
            }

            $cnpjInput.addClass('is-invalid');
            $cnpjExistsError.removeClass('d-none');
        }

        /**
         * Remove mensagem de duplicidade do documento informado.
         * Evita erro residual ao trocar valor ou tipo de documento.
         */
        function hideDocumentExistsError(documentType) {
            if (documentType === 'cpf') {
                $cpfExistsError.addClass('d-none');
                if ($cpfError.hasClass('d-none')) {
                    $cpfInput.removeClass('is-invalid');
                }
                return;
            }

            $cnpjInput.removeClass('is-invalid');
            $cnpjExistsError.addClass('d-none');
        }

        /**
         * Reinicia estado da validacao assíncrona de documento.
         * Cancela respostas antigas quando o usuario altera o input.
         */
        function resetDocumentAvailabilityState() {
            isDocumentCheckLoading = false;
            isDocumentAlreadyRegistered = false;
            checkedDocumentType = '';
            checkedDocumentValue = '';
            activeDocumentRequestId += 1;
        }

        /**
         * Alterna entre campos de CNPJ e CPF conforme opcao do usuario.
         * Mantem o erro de CPF oculto quando o documento nao e necessario.
         */
        function toggleDocumentFields() {
            const withoutCnpj = $noCnpjCheckbox.is(':checked');
            $cnpjField.toggleClass('d-none', withoutCnpj);
            $cpfField.toggleClass('d-none', !withoutCnpj);
            $cnpjInput.prop('required', !withoutCnpj);
            $cpfInput.prop('required', withoutCnpj);
            $documentTypeInput.val(withoutCnpj ? 'cpf' : 'cnpj');
            resetDocumentAvailabilityState();
            hideDocumentExistsError('cpf');
            hideDocumentExistsError('cnpj');
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
            applyPhoneMaskIfNeeded();
            $('#phone').val('11999999999');
            $('#no_cnpj').prop('checked', false).trigger('change');
            applyCnpjMaskIfNeeded();
            $('#cnpj').val('12345678000199');
            $('#password').val('Senha@12345');
            $('#has_coupon').prop('checked', true).trigger('change');
            $('#coupon_code').val('BEMVINDO10');
            $('#tips_whatsapp').prop('checked', true);
            $('#tips_email').prop('checked', true);

            updateNextStepButtonState();
        }

        /**
         * Consulta a central para identificar email ja cadastrado.
         * Ignora respostas antigas quando o usuario altera rapidamente o valor.
         */
        function checkEmailAvailability(forceValidation = false) {
            const normalizedEmail = getNormalizedEmail($emailInput.val());
            if (!isEmailSyntaxValid()) {
                isEmailCheckLoading = false;
                isEmailAlreadyRegistered = false;
                checkedEmail = '';
                hideEmailError();
                return $.Deferred().resolve(true).promise();
            }

            if (checkedEmail === normalizedEmail && !isEmailCheckLoading) {
                if (isEmailAlreadyRegistered && (forceValidation || hasInteractedWithEmail)) {
                    showEmailError();
                } else if (!isEmailAlreadyRegistered) {
                    hideEmailError();
                }

                return $.Deferred().resolve(!isEmailAlreadyRegistered).promise();
            }

            const requestId = activeEmailRequestId + 1;
            activeEmailRequestId = requestId;
            isEmailCheckLoading = true;
            checkedEmail = normalizedEmail;
            updateNextStepButtonState();

            return $.ajax({
                url: checkEmailUrl,
                method: 'GET',
                dataType: 'json',
                data: { email: normalizedEmail }
            }).done(function (response) {
                if (requestId !== activeEmailRequestId) {
                    return;
                }

                isEmailAlreadyRegistered = Boolean(response.exists);

                if (isEmailAlreadyRegistered && (forceValidation || hasInteractedWithEmail)) {
                    showEmailError();
                    return;
                }

                hideEmailError();
            }).fail(function () {
                if (requestId !== activeEmailRequestId) {
                    return;
                }

                // Em caso de indisponibilidade, nao bloqueamos o fluxo por falso positivo.
                isEmailAlreadyRegistered = false;
                hideEmailError();
            }).always(function () {
                if (requestId !== activeEmailRequestId) {
                    return;
                }

                isEmailCheckLoading = false;
                updateNextStepButtonState();
            });
        }

        /**
         * Retorna se o documento atual possui formato pronto para consulta.
         * Evita chamadas prematuras antes de o usuario concluir a digitacao.
         */
        function isDocumentReadyForLookup(documentType) {
            if (documentType === 'cpf') {
                return getDigits($cpfInput.val()).length === 11 && isValidCpf($cpfInput.val());
            }

            return getDigits($cnpjInput.val()).length === 14;
        }

        /**
         * Consulta a central para verificar duplicidade de CPF/CNPJ.
         * Ignora retorno antigo quando houver nova digitacao.
         */
        function checkDocumentAvailability(documentType, forceValidation = false) {
            const documentValue = getDigits(documentType === 'cpf' ? $cpfInput.val() : $cnpjInput.val());
            if (!isDocumentReadyForLookup(documentType)) {
                resetDocumentAvailabilityState();
                hideDocumentExistsError(documentType);
                return $.Deferred().resolve(true).promise();
            }

            if (
                checkedDocumentType === documentType &&
                checkedDocumentValue === documentValue &&
                !isDocumentCheckLoading
            ) {
                const hasInteracted = documentType === 'cpf' ? hasInteractedWithCpf : hasInteractedWithCnpj;
                if (isDocumentAlreadyRegistered && (forceValidation || hasInteracted)) {
                    showDocumentExistsError(documentType);
                } else if (!isDocumentAlreadyRegistered) {
                    hideDocumentExistsError(documentType);
                }

                return $.Deferred().resolve(!isDocumentAlreadyRegistered).promise();
            }

            const requestId = activeDocumentRequestId + 1;
            activeDocumentRequestId = requestId;
            isDocumentCheckLoading = true;
            checkedDocumentType = documentType;
            checkedDocumentValue = documentValue;
            updateNextStepButtonState();

            return $.ajax({
                url: checkDocumentUrl,
                method: 'GET',
                dataType: 'json',
                data: {
                    type: documentType,
                    value: documentValue
                }
            }).done(function (response) {
                if (requestId !== activeDocumentRequestId) {
                    return;
                }

                isDocumentAlreadyRegistered = Boolean(response.exists);
                const hasInteracted = documentType === 'cpf' ? hasInteractedWithCpf : hasInteractedWithCnpj;
                if (isDocumentAlreadyRegistered && (forceValidation || hasInteracted)) {
                    showDocumentExistsError(documentType);
                    return;
                }

                hideDocumentExistsError(documentType);
            }).fail(function () {
                if (requestId !== activeDocumentRequestId) {
                    return;
                }

                // Evita bloquear fluxo em caso de instabilidade temporaria da central.
                isDocumentAlreadyRegistered = false;
                hideDocumentExistsError(documentType);
            }).always(function () {
                if (requestId !== activeDocumentRequestId) {
                    return;
                }

                isDocumentCheckLoading = false;
                updateNextStepButtonState();
            });
        }

        /**
         * Valida campo de nome completo em modo silencioso ou forçado.
         * Só mostra erro após interação do usuário ou validação final.
         */
        function validateFullNameField(forceValidation = false) {
            const isNameValid = isValidFullName($fullNameInput.val());
            if (isNameValid) {
                hideFullNameError();
                return true;
            }

            if (forceValidation || hasInteractedWithFullName) {
                showFullNameError();
            } else {
                hideFullNameError();
            }

            return false;
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
         * Valida campos obrigatórios visíveis da primeira etapa.
         * Mantém bloqueio de avanço enquanto houver campos inválidos.
         */
        function validateVisibleRequiredFields() {
            const $requiredFields = $('.onboarding-step[data-step="account"]')
                .find(':input[required]')
                .filter(':enabled:visible');

            let isValid = true;
            $requiredFields.each(function () {
                if (this.checkValidity()) {
                    return true;
                }

                isValid = false;
                return false;
            });

            return isValid;
        }

        /**
         * Valida disponibilidade do email para permitir avancar no fluxo.
         * Bloqueia enquanto houver consulta pendente ou email sem consulta.
         */
        function validateEmailAvailability(forceValidation = false) {
            const normalizedEmail = getNormalizedEmail($emailInput.val());
            if (!isEmailSyntaxValid()) {
                hideEmailError();
                return true;
            }

            if (isEmailCheckLoading) {
                return false;
            }

            if (checkedEmail !== normalizedEmail) {
                if (forceValidation) {
                    checkEmailAvailability(true);
                }
                return false;
            }

            if (isEmailAlreadyRegistered) {
                if (forceValidation || hasInteractedWithEmail) {
                    showEmailError();
                }
                return false;
            }

            hideEmailError();
            return true;
        }

        /**
         * Valida disponibilidade do documento ativo na etapa account.
         * Bloqueia avanço quando houver consulta pendente ou duplicidade.
         */
        function validateDocumentAvailability(forceValidation = false) {
            const documentType = $noCnpjCheckbox.is(':checked') ? 'cpf' : 'cnpj';
            if (!isDocumentReadyForLookup(documentType)) {
                hideDocumentExistsError(documentType);
                return true;
            }

            if (isDocumentCheckLoading) {
                return false;
            }

            const currentValue = getDigits(documentType === 'cpf' ? $cpfInput.val() : $cnpjInput.val());
            if (checkedDocumentType !== documentType || checkedDocumentValue !== currentValue) {
                if (forceValidation) {
                    checkDocumentAvailability(documentType, true);
                }
                return false;
            }

            if (isDocumentAlreadyRegistered) {
                const hasInteracted = documentType === 'cpf' ? hasInteractedWithCpf : hasInteractedWithCnpj;
                if (forceValidation || hasInteracted) {
                    showDocumentExistsError(documentType);
                }
                return false;
            }

            hideDocumentExistsError(documentType);
            return true;
        }

        /**
         * Valida senha forte e sincroniza com validacao nativa do navegador.
         * Aplica mensagem customizada somente apos interacao do usuario.
         */
        function validatePasswordField(forceValidation = false) {
            const passwordValue = $passwordInput.val() || '';
            const isPasswordValid = isStrongPassword(passwordValue);
            const shouldShowValidation = forceValidation || hasInteractedWithPassword;

            if (shouldShowValidation && passwordValue.length && !isPasswordValid) {
                $passwordInput.get(0).setCustomValidity('A senha nao atende aos critérios mínimos.');
            } else {
                $passwordInput.get(0).setCustomValidity('');
            }

            $passwordInput.toggleClass('is-invalid', shouldShowValidation && passwordValue.length && !isPasswordValid);
            renderPasswordRules();
            return isPasswordValid;
        }

        /**
         * Atualiza estado do botão de avanço conforme regras da etapa 1.
         * Libera botão somente quando todas as validações passarem.
         */
        function updateNextStepButtonState() {
            const isFullNameValid = validateFullNameField(false);
            const isEmailAvailable = validateEmailAvailability(false);
            const isCpfValid = validateCpfField(false);
            const isDocumentAvailable = validateDocumentAvailability(false);
            const isPasswordValid = validatePasswordField(false);
            const hasValidRequiredFields = validateVisibleRequiredFields();
            const canProceed = isFullNameValid && isEmailAvailable && isCpfValid && isDocumentAvailable && isPasswordValid && hasValidRequiredFields;

            $nextStepButton.prop('disabled', !canProceed);
        }

        /**
         * Executa validacoes do step account antes de avancar no wizard.
         * Garante foco no campo CPF quando houver erro de preenchimento.
         */
        function validateAccountStep() {
            const isFullNameValid = validateFullNameField(true);
            if (!isFullNameValid) {
                $fullNameInput.trigger('focus');
                return false;
            }

            const isEmailAvailable = validateEmailAvailability(true);
            if (!isEmailAvailable) {
                $emailInput.trigger('focus');
                return false;
            }

            const isCpfValid = validateCpfField(true);
            if (!isCpfValid) {
                $cpfInput.trigger('focus');
                return false;
            }

            const isDocumentAvailable = validateDocumentAvailability(true);
            if (!isDocumentAvailable) {
                ($noCnpjCheckbox.is(':checked') ? $cpfInput : $cnpjInput).trigger('focus');
                return false;
            }

            const isPasswordValid = validatePasswordField(true);
            if (!isPasswordValid) {
                $passwordInput.trigger('focus');
                return false;
            }

            return validateVisibleRequiredFields();
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
        $fullNameInput.on('input', function () {
            validateFullNameField(false);
            updateNextStepButtonState();
        });
        $fullNameInput.on('blur', function () {
            hasInteractedWithFullName = true;
            validateFullNameField(true);
            updateNextStepButtonState();
        });
        /**
         * Escuta mudancas no email para invalidar a ultima consulta
         * e impedir que email novo reutilize validacao de valor antigo.
         */
        $emailInput.on('input', function () {
            isEmailCheckLoading = false;
            isEmailAlreadyRegistered = false;
            checkedEmail = '';
            activeEmailRequestId += 1;
            hideEmailError();
            updateNextStepButtonState();
        });

        /**
         * Escuta saida do campo de email para consultar duplicidade
         * e exibir mensagem de erro apenas apos finalizar preenchimento.
         */
        $emailInput.on('blur', function () {
            hasInteractedWithEmail = true;
            checkEmailAvailability(true);
        });

        /**
         * Escuta digitacao no CPF para validar apenas quando houver 11 digitos
         * e evitar feedback de erro prematuro durante o preenchimento.
         */
        $cpfInput.on('focus', applyCpfMaskIfNeeded);
        $cpfInput.on('input', function () {
            hasInteractedWithCpf = true;
            resetDocumentAvailabilityState();
            hideDocumentExistsError('cpf');

            if (!$noCnpjCheckbox.is(':checked')) {
                hideCpfError();
                updateNextStepButtonState();
                return;
            }

            if (getDigits($cpfInput.val()).length === 11) {
                validateCpfField();
                updateNextStepButtonState();
                return;
            }

            hideCpfError();
            updateNextStepButtonState();
        });

        /**
         * Escuta saida do campo CPF para validar valor completo digitado
         * e manter a regra de erro apenas quando o documento estiver finalizado.
         */
        $cpfInput.on('blur', function () {
            hasInteractedWithCpf = true;
            if (!$noCnpjCheckbox.is(':checked')) {
                hideCpfError();
                updateNextStepButtonState();
                return;
            }

            if (getDigits($cpfInput.val()).length === 11) {
                validateCpfField(true);
                if (isValidCpf($cpfInput.val())) {
                    checkDocumentAvailability('cpf', true);
                }
                updateNextStepButtonState();
                return;
            }

            hideCpfError();
            hideDocumentExistsError('cpf');
            updateNextStepButtonState();
        });

        /**
         * Escuta alteracoes no CNPJ para invalidar consulta anterior
         * e garantir verificação com o valor final digitado no campo.
         */
        $cnpjInput.on('focus', applyCnpjMaskIfNeeded);
        $cnpjInput.on('input', function () {
            hasInteractedWithCnpj = true;
            resetDocumentAvailabilityState();
            hideDocumentExistsError('cnpj');
            updateNextStepButtonState();
        });

        /**
         * Escuta saida do CNPJ e consulta duplicidade na central.
         * Exibe erro abaixo do campo quando ja houver conta vinculada.
         */
        $cnpjInput.on('blur', function () {
            hasInteractedWithCnpj = true;
            if ($noCnpjCheckbox.is(':checked')) {
                hideDocumentExistsError('cnpj');
                updateNextStepButtonState();
                return;
            }

            if (getDigits($cnpjInput.val()).length === 14) {
                checkDocumentAvailability('cnpj', true);
                updateNextStepButtonState();
                return;
            }

            hideDocumentExistsError('cnpj');
            updateNextStepButtonState();
        });

        /**
         * Escuta digitacao na senha para exibir checklist e atualizar status.
         * Mantem o botao bloqueado ate todas as regras serem satisfeitas.
         */
        $passwordInput.on('input', function () {
            hasInteractedWithPassword = true;
            togglePasswordRulesVisibility();
            validatePasswordField(false);
            updateNextStepButtonState();
        });

        /**
         * Escuta saida do campo senha para reforcar validacao final.
         * Garante borda de erro quando usuario deixa campo invalido.
         */
        $passwordInput.on('blur', function () {
            hasInteractedWithPassword = true;
            togglePasswordRulesVisibility();
            validatePasswordField(true);
            updateNextStepButtonState();
        });

        /**
         * Escuta clique no icone de olho para alternar visibilidade da senha.
         * Mantem feedback visual do proprio icone conforme estado atual.
         */
        $passwordToggleButton.on('click', function () {
            const shouldShowPassword = $passwordInput.attr('type') === 'password';
            $passwordInput.attr('type', shouldShowPassword ? 'text' : 'password');
            $passwordToggleIcon
                .toggleClass('fa-eye', !shouldShowPassword)
                .toggleClass('fa-eye-slash', shouldShowPassword);
        });

        /**
         * Escuta mudanca no checkbox de CNPJ para limpar erro residual do CPF
         * quando o usuario alterna rapidamente entre os tipos de documento.
         */
        $noCnpjCheckbox.on('change', hideCpfError);
        $noCnpjCheckbox.on('change', updateNextStepButtonState);
        $hasCouponCheckbox.on('change', updateNextStepButtonState);
        $phoneInput.on('focus', applyPhoneMaskIfNeeded);
        $phoneInput.on('input', function () {
            updateNextStepButtonState();
        });
        $phoneInput.on('blur', updateNextStepButtonState);

        window.validateAccountStep = validateAccountStep;

        toggleDocumentFields();
        toggleCouponField();
        togglePasswordRulesVisibility();
        validatePasswordField(false);
        updateNextStepButtonState();
    });
</script>
@endpush

<div class="mt-15">
    <p class="form-label text-gray-700 fw-bolder mb-1">Receber dicas</p>
    <div class="d-flex gap-4">
        <div class="form-check">
            <input class="form-check-input" id="tips_whatsapp" type="checkbox" name="tips_whatsapp" value="1" @checked(old('tips_whatsapp', $data['tips_whatsapp'] ?? true))>
            <label class="form-check-label" for="tips_whatsapp">Receber por WhatsApp</label>
        </div>
        <div class="form-check">
            <input class="form-check-input" id="tips_email" type="checkbox" name="tips_email" value="1" @checked(old('tips_email', $data['tips_email'] ?? true))>
            <label class="form-check-label" for="tips_email">Receber por e-mail</label>
        </div>
    </div>
    <p class="text-muted small mt-6 mb-0">
        Ao utilizar o sistema, voce concorda com nossos
        <a class="text-muted text-decoration-underline fw-bold" href="http://micore.com.br/termos-de-uso" target="_blank" rel="noopener noreferrer">Termos de Uso</a>
        e
        <a class="text-muted text-decoration-underline fw-bold" href="http://micore.com.br/termos-de-uso" target="_blank" rel="noopener noreferrer">Politica de Privacidade</a>.
    </p>
    <p class="text-muted small mb-0">
        Este site e protegido por reCAPTCHA. A Politica de Privacidade e os Termos de Uso do Google se aplicam.
    </p>
</div>
