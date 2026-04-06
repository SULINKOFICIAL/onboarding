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
    <input class="form-control" id="phone" name="phone" value="{{ old('phone', $data['phone'] ?? '') }}" placeholder="(11) 99999-9999">
</div>
<div class="mb-3 d-none" id="cpf-field">
    <label class="form-label text-gray-700 fw-bolder mb-0" for="cpf">CPF</label>
    <input class="form-control input-cpf" id="cpf" name="cpf" value="{{ old('cpf', $data['cpf'] ?? ($data['cif'] ?? '')) }}" placeholder="000.000.000-00">
</div>
<div class="mb-3" id="cnpj-field">
    <label class="form-label text-gray-700 fw-bolder mb-0" for="cnpj">CNPJ</label>
    <input class="form-control" id="cnpj" name="cnpj" value="{{ old('cnpj', $data['cnpj'] ?? '') }}" placeholder="00.000.000/0000-00">
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
        const $noCnpjCheckbox = $('#no_cnpj');
        const $cnpjField = $('#cnpj-field');
        const $cpfField = $('#cpf-field');
        const $hasCouponCheckbox = $('#has_coupon');
        const $couponField = $('#coupon-field');
        const $fillTestDataButton = $('#fill-test-data-account');
        const $phoneInput = $('#phone');
        const $cpfInput = $('#cpf');
        const $cnpjInput = $('#cnpj');

        function getDigits(value) {
            return (value || '').replace(/\D/g, '');
        }

        function formatPhone(value) {
            const digits = getDigits(value).slice(0, 11);
            if (digits.length <= 2) {
                return digits;
            }

            if (digits.length <= 10) {
                return `(${digits.slice(0, 2)}) ${digits.slice(2, 6)}${digits.length > 6 ? `-${digits.slice(6)}` : ''}`;
            }

            return `(${digits.slice(0, 2)}) ${digits.slice(2, 7)}-${digits.slice(7)}`;
        }

        function formatCpf(value) {
            const digits = getDigits(value).slice(0, 11);
            if (digits.length <= 3) {
                return digits;
            }

            if (digits.length <= 6) {
                return `${digits.slice(0, 3)}.${digits.slice(3)}`;
            }

            if (digits.length <= 9) {
                return `${digits.slice(0, 3)}.${digits.slice(3, 6)}.${digits.slice(6)}`;
            }

            return `${digits.slice(0, 3)}.${digits.slice(3, 6)}.${digits.slice(6, 9)}-${digits.slice(9)}`;
        }

        function formatCnpj(value) {
            const digits = getDigits(value).slice(0, 14);
            if (digits.length <= 2) {
                return digits;
            }

            if (digits.length <= 5) {
                return `${digits.slice(0, 2)}.${digits.slice(2)}`;
            }

            if (digits.length <= 8) {
                return `${digits.slice(0, 2)}.${digits.slice(2, 5)}.${digits.slice(5)}`;
            }

            if (digits.length <= 12) {
                return `${digits.slice(0, 2)}.${digits.slice(2, 5)}.${digits.slice(5, 8)}/${digits.slice(8)}`;
            }

            return `${digits.slice(0, 2)}.${digits.slice(2, 5)}.${digits.slice(5, 8)}/${digits.slice(8, 12)}-${digits.slice(12)}`;
        }

        function toggleDocumentFields() {
            const withoutCnpj = $noCnpjCheckbox.is(':checked');
            $cnpjField.toggleClass('d-none', withoutCnpj);
            $cpfField.toggleClass('d-none', !withoutCnpj);
        }

        function toggleCouponField() {
            $couponField.toggleClass('d-none', !$hasCouponCheckbox.is(':checked'));
        }

        function fillTestDataStep() {
            $('#full_name').val('Usuario Teste');
            $('#email').val('teste+onboarding@micore.com');
            $('#phone').val('(11) 99999-9999');
            $('#no_cnpj').prop('checked', false).trigger('change');
            $('#cnpj').val('12.345.678/0001-99');
            $('#password').val('Senha@12345');
            $('#has_coupon').prop('checked', true).trigger('change');
            $('#coupon_code').val('BEMVINDO10');
            $('#tips_whatsapp').prop('checked', true);
            $('#tips_email').prop('checked', true);
        }

        function maskPhoneInput() {
            $phoneInput.val(formatPhone($phoneInput.val()));
        }

        function maskCpfInput() {
            $cpfInput.val(formatCpf($cpfInput.val()));
        }

        function maskCnpjInput() {
            $cnpjInput.val(formatCnpj($cnpjInput.val()));
        }

        $noCnpjCheckbox.on('change', toggleDocumentFields);
        $hasCouponCheckbox.on('change', toggleCouponField);
        $fillTestDataButton.on('click', fillTestDataStep);
        $phoneInput.on('input', maskPhoneInput);
        $cpfInput.on('input', maskCpfInput);
        $cnpjInput.on('input', maskCnpjInput);

        toggleDocumentFields();
        toggleCouponField();
        maskPhoneInput();
        maskCpfInput();
        maskCnpjInput();
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
