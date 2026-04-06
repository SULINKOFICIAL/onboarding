@extends('app')

@section('title', 'Onboarding')

@section('content')
    <div class="container-fluid">
        <div class="row min-vh-100">
            <div class="col-12 col-lg-6 bg-white d-flex align-items-center z-index-3" style="box-shadow: 20px 0px 100px #10161f97;">
                <div class="w-100 px-4 px-md-5 py-4 mx-auto" style="max-width: 640px;">
                    @if ($currentStep !== 'address')
                        <div class="mb-3">
                            <span class="badge badge-success">30 dias gratuitos</span>
                        </div>
                        <div class="d-flex gap-2 mb-3" aria-label="Progresso do onboarding">
                            @for ($bar = 1; $bar <= 3; $bar++)
                                <div
                                    class="flex-fill rounded-pill h-10px {{ ($currentStepIndex + 1) >= $bar ? 'bg-primary' : 'bg-gray-200' }}"
                                ></div>
                            @endfor
                        </div>
                    @endif

                    <h1 class="fs-2x fw-bolder mt-6 mb-10 me-md-13">Experimente o mi.Core: organize seu atendimento e impulsione o crescimento da sua empresa.</h1>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('onboarding.submit') }}">
                        @csrf
                        <input type="hidden" name="current_step" value="{{ $currentStep }}">

                        @includeIf('onboarding.steps.' . $currentStep)

                        <div class="d-flex justify-content-between mt-4">
                            @if ($previousStep)
                                <button class="btn btn-outline-secondary" type="submit" name="navigation" value="back" formnovalidate>Voltar</button>
                            @else
                                <span></span>
                            @endif

                            <button class="btn btn-primary w-100" type="submit" name="navigation" value="next">
                                {{ $currentStep === 'account' ? 'Comecar a testar' : ($currentStep !== 'address' ? 'Continuar' : 'Finalizar') }}
                            </button>
                        </div>

                        @if ($currentStep === 'account')
                            <div class="mt-15">
                                <p class="form-label text-gray-700 fw-bolder mb-1">Receber dicas</p>
                                <div class="d-flex gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" id="tips_whatsapp" type="checkbox" name="tips_whatsapp" value="1" checked>
                                        <label class="form-check-label" for="tips_whatsapp">Receber por WhatsApp</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" id="tips_email" type="checkbox" name="tips_email" value="1" checked>
                                        <label class="form-check-label" for="tips_email">Receber por e-mail</label>
                                    </div>
                                </div>
                                <p class="text-muted small mt-3 mb-0">
                                    Este site e protegido por reCAPTCHA. A Politica de Privacidade e os Termos de Uso do Google se aplicam.
                                </p>
                            </div>
                        @endif
                    </form>
                </div>
            </div>

            <div class="col-12 col-lg-6 d-flex align-items-end p-4 p-lg-8 justify-content-center position-relative overflow-hidden" style="background: url('{{ asset('assets/media/bg-big.jpg') }}') no-repeat center center; background-size: cover;">
                <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(0deg, #131924f2 20%, #1d253438 80%);"></div>

                <div class="z-index-2 w-100 mw-600px">
                    <div class="mb-8 text-white">
                        <span class="badge text-success mb-4" style="background-color: #68c7170f !important;">Teste Gratuitamente</span>
                        <h2 class="fw-bolder lh-sm mb-3 text-white" style="font-size: clamp(1.7rem, 2.8vw, 2.4rem);">
                            <span style="color: #62de04;">Venda mais</span> e
                            <span style="color: #62de04;">ganhe produtividade</span>
                            com uma operação centralizada!
                        </h2>
                        <p class="mb-0 text-gray-200 fs-5">
                            Complete seu cadastro em minutos e comece a usar um sistema pensado para acelerar resultados.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
