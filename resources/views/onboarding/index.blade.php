@extends('app')

@section('title', 'Onboarding')

@section('content')
    <div class="container-fluid">
        <div class="row min-vh-100">
            <div class="col-12 col-lg-6 order-lg-2 bg-white d-flex align-items-center z-index-3" style="box-shadow: 20px 0px 100px #10161f97;">
                <div class="w-100 px-4 px-md-5 py-4 mx-auto" style="max-width: 640px;">
                    @if ($currentStep !== 'address')
                        <div class="d-flex gap-2 mb-3" aria-label="Progresso do onboarding">
                            @for ($bar = 1; $bar <= 3; $bar++)
                                <div
                                    class="flex-fill rounded-pill {{ ($currentStepIndex + 1) >= $bar ? 'bg-primary' : 'bg-secondary-subtle' }}"
                                    style="height: 8px;"
                                ></div>
                            @endfor
                        </div>
                        <div class="mb-3">
                            <span class="badge bg-light-primary text-primary">Teste gratuitamente</span>
                        </div>
                    @endif

                    <h1 class="h3 mb-3">Onboarding - Etapa {{ $currentStepIndex + 1 }} de {{ count($stepLabels) }}</h1>

                    <div class="d-flex gap-2 mb-4">
                        @foreach ($stepLabels as $stepName => $stepLabel)
                            <span class="badge {{ $currentStep === $stepName ? 'bg-primary' : 'bg-secondary' }}">{{ $stepLabel }}</span>
                        @endforeach
                    </div>

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

                            <button class="btn btn-primary" type="submit" name="navigation" value="next">
                                {{ $currentStep === 'account' ? 'Comecar a testar' : ($currentStep !== 'address' ? 'Continuar' : 'Finalizar') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-12 col-lg-6 order-lg-1 d-flex align-items-end p-4 p-lg-8 justify-content-center position-relative overflow-hidden" style="background: url('{{ asset('assets/media/bg-big.jpg') }}') no-repeat center center; background-size: cover;">
                <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(0deg, #131924f2 20%, #1d253438 80%);"></div>

                <div class="z-index-2 w-100 mw-600px">
                    <div class="mb-8 text-white">
                        <span class="badge bg-light-success text-success mb-4">Teste sem compromisso</span>
                        <h2 class="fw-bolder lh-sm mb-3 text-white" style="font-size: clamp(1.7rem, 2.8vw, 2.4rem);">
                            Venda mais e ganhe produtividade com uma operação centralizada
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
