@extends('app')

@section('title', 'Onboarding')

@section('content')
    <div class="container-fluid">
        <div class="row min-vh-100">
            <div class="col-12 col-lg-6 bg-white d-flex align-items-center z-index-3" style="box-shadow: 20px 0px 100px #10161f97;">
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

            <div class="col-12 col-lg-6 d-flex align-items-end p-4 justify-content-center bg-light position-relative" style="background: url('{{ asset('assets/media/bg-big.jpg') }}') no-repeat center center; background-size: cover;">
                <div class="z-index-2 position-absolute mb-20">
                    <p class="text-white text-center fs-2x fw-bolder">Tudo o que sua empresa precisa, <span style="color: #62de04">no lugar certo</span>.</p>
                    <p class="text-white fs-6">Tudo o que sua empresa precisa, <span style="color: #62de04">no lugar certo</span>.</p>
                </div>
                <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(0deg, #131924f2 20%, #1d253438 80%);"></div>
            </div>
        </div>
    </div>
@endsection
