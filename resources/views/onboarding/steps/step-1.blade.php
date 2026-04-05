<div class="mb-3">
    <label class="form-label" for="full_name">Nome</label>
    <input class="form-control" id="full_name" name="full_name" value="{{ old('full_name', $data['full_name'] ?? '') }}" placeholder="Digite seu nome completo">
</div>
<div class="mb-3">
    <label class="form-label" for="email">E-mail</label>
    <input class="form-control" id="email" type="email" name="email" value="{{ old('email', $data['email'] ?? '') }}" placeholder="voce@empresa.com">
</div>
<div class="mb-3">
    <label class="form-label" for="phone">Numero</label>
    <input class="form-control" id="phone" name="phone" value="{{ old('phone', $data['phone'] ?? '') }}" placeholder="(11) 99999-9999">
</div>
<div class="mb-3" id="cnpj-field">
    <label class="form-label" for="cnpj">CNPJ</label>
    <input class="form-control" id="cnpj" name="cnpj" value="{{ old('cnpj', $data['cnpj'] ?? '') }}" placeholder="00.000.000/0000-00">
</div>
<div class="form-check mb-3">
    <input class="form-check-input" id="no_cnpj" type="checkbox" name="no_cnpj" value="1" @checked(old('no_cnpj', $data['no_cnpj'] ?? false))>
    <label class="form-check-label" for="no_cnpj">Nao tenho CNPJ</label>
</div>
<div class="mb-3 d-none" id="cif-field">
    <label class="form-label" for="cif">CIF</label>
    <input class="form-control" id="cif" name="cif" value="{{ old('cif', $data['cif'] ?? '') }}" placeholder="Informe seu CIF">
</div>
<div class="mb-3">
    <label class="form-label" for="password">Senha</label>
    <input class="form-control" id="password" type="password" name="password" value="{{ old('password', $data['password'] ?? '') }}" placeholder="Crie uma senha">
</div>
<div class="form-check mb-3">
    <input class="form-check-input" id="has_coupon" type="checkbox" name="has_coupon" value="1" @checked(old('has_coupon', $data['has_coupon'] ?? false))>
    <label class="form-check-label" for="has_coupon">Tenho cupom</label>
</div>
<div class="mb-3 d-none" id="coupon-field">
    <label class="form-label" for="coupon_code">Cupom</label>
    <input class="form-control" id="coupon_code" name="coupon_code" value="{{ old('coupon_code', $data['coupon_code'] ?? '') }}" placeholder="Digite o código do cupom">
</div>

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

<button
    id="fill-test-data"
    type="button"
    class="btn btn-dark position-fixed bottom-0 end-0 m-4 shadow"
>
    Preencher teste
</button>

@section('custom-footer')
    <script>
        const noCnpjCheckbox = document.getElementById('no_cnpj');
        const cnpjField = document.getElementById('cnpj-field');
        const hasCouponCheckbox = document.getElementById('has_coupon');
        const couponField = document.getElementById('coupon-field');
        const fillTestDataButton = document.getElementById('fill-test-data');

        function toggleDocumentFields() {
            if (!noCnpjCheckbox || !cnpjField) {
                return;
            }

            const withoutCnpj = noCnpjCheckbox.checked;
            cnpjField.classList.toggle('d-none', withoutCnpj);
            document.getElementById('cif-field')?.classList.toggle('d-none', !withoutCnpj);
        }

        function toggleCouponField() {
            if (!hasCouponCheckbox || !couponField) {
                return;
            }

            couponField.classList.toggle('d-none', !hasCouponCheckbox.checked);
        }

        noCnpjCheckbox?.addEventListener('change', toggleDocumentFields);
        hasCouponCheckbox?.addEventListener('change', toggleCouponField);
        toggleDocumentFields();
        toggleCouponField();

        fillTestDataButton?.addEventListener('click', function () {
            document.getElementById('full_name').value = 'Usuario Teste';
            document.getElementById('email').value = 'teste+onboarding@micore.com';
            document.getElementById('phone').value = '11999999999';
            noCnpjCheckbox.checked = false;
            noCnpjCheckbox.dispatchEvent(new Event('change'));
            document.getElementById('cnpj').value = '12345678000199';
            document.getElementById('password').value = 'Senha@12345';
            hasCouponCheckbox.checked = true;
            hasCouponCheckbox.dispatchEvent(new Event('change'));
            document.getElementById('coupon_code').value = 'BEMVINDO10';

            const tipsWhatsapp = document.getElementById('tips_whatsapp');
            const tipsEmail = document.getElementById('tips_email');
            if (tipsWhatsapp) tipsWhatsapp.checked = true;
            if (tipsEmail) tipsEmail.checked = true;
        });
    </script>
@endsection
