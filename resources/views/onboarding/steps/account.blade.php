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
    id="fill-test-data"
    type="button"
    class="btn btn-dark position-fixed bottom-0 end-0 m-4 shadow"
>
    Preencher teste
</button>

@section('custom-footer')
    <script>
        // Estado global
        const $noCnpjCheckbox = $('#no_cnpj');
        const $cnpjField = $('#cnpj-field');
        const $cpfField = $('#cpf-field');
        const $hasCouponCheckbox = $('#has_coupon');
        const $couponField = $('#coupon-field');
        const $fillTestDataButton = $('#fill-test-data');

        // Helpers / utilitários
        /**
         * Define valor em um input quando ele existe para evitar erros em etapas diferentes.
         * Mantem o preenchimento de teste centralizado e reutilizavel.
         */
        function setInputValue(selector, value) {
            const $input = $(selector);
            if (!$input.length) {
                return;
            }

            $input.val(value);
        }

        /**
         * Define estado de checkbox e dispara change para manter efeitos colaterais originais.
         * O disparo de evento garante a mesma logica das interacoes manuais.
         */
        function setCheckboxValue(selector, isChecked) {
            const $checkbox = $(selector);
            if (!$checkbox.length) {
                return;
            }

            $checkbox.prop('checked', isChecked).trigger('change');
        }

        // Funções de renderização / UI
        /**
         * Controla exibicao de CNPJ e CPF com base no checkbox "Nao tenho CNPJ".
         * Essa regra preserva a alternancia original entre os dois campos.
         */
        function toggleDocumentFields() {
            if (!$noCnpjCheckbox.length || !$cnpjField.length || !$cpfField.length) {
                return;
            }

            const withoutCnpj = $noCnpjCheckbox.is(':checked');
            $cnpjField.toggleClass('d-none', withoutCnpj);
            $cpfField.toggleClass('d-none', !withoutCnpj);
        }

        /**
         * Controla exibicao do campo de cupom com base no checkbox correspondente.
         * Mantem o mesmo comportamento do formulario antes da refatoracao.
         */
        function toggleCouponField() {
            if (!$hasCouponCheckbox.length || !$couponField.length) {
                return;
            }

            $couponField.toggleClass('d-none', !$hasCouponCheckbox.is(':checked'));
        }

        /**
         * Preenche dados de teste da etapa atual para acelerar validacoes manuais.
         * Mantem os mesmos valores e fluxo utilizados anteriormente.
         */
        function fillTestDataStep() {
            setInputValue('#full_name', 'Usuario Teste');
            setInputValue('#email', 'teste+onboarding@micore.com');
            setInputValue('#phone', '11999999999');
            setCheckboxValue('#no_cnpj', false);
            setInputValue('#cnpj', '12345678000199');
            setInputValue('#password', 'Senha@12345');
            setCheckboxValue('#has_coupon', true);
            setInputValue('#coupon_code', 'BEMVINDO10');

            // Mantem checkboxes opcionais ativados no preenchimento de teste.
            $('#tips_whatsapp').prop('checked', true);
            $('#tips_email').prop('checked', true);
        }

        // Event listeners
        /**
         * Explica o que este listener escuta, o que ele dispara
         * e por que esse comportamento é necessário neste arquivo.
         */
        $noCnpjCheckbox.on('change', toggleDocumentFields);

        /**
         * Explica o que este listener escuta, o que ele dispara
         * e por que esse comportamento é necessário neste arquivo.
         */
        $hasCouponCheckbox.on('change', toggleCouponField);

        /**
         * Explica o que este listener escuta, o que ele dispara
         * e por que esse comportamento é necessário neste arquivo.
         */
        $fillTestDataButton.on('click', fillTestDataStep);

        // Garante consistencia visual ao carregar pagina com dados anteriores.
        toggleDocumentFields();
        toggleCouponField();
    </script>
@endsection
