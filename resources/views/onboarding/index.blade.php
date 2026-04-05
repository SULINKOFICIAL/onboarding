@extends('app')

@section('title', 'Onboarding')

@section('content')
    <div class="container-fluid">
        <div class="row min-vh-100">
            <div class="col-12 col-lg-6 bg-white d-flex align-items-center">
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

                    <form method="POST" action="{{ route('onboarding.submit', ['step' => $currentStep]) }}">
                        @csrf

                        @includeIf('onboarding.steps.' . $currentStep)

                        <div class="d-flex justify-content-between mt-4">
                            @if ($previousStep)
                                <a class="btn btn-outline-secondary" href="{{ route('onboarding.step', ['step' => $previousStep]) }}">Voltar</a>
                            @else
                                <span></span>
                            @endif

                            <button class="btn btn-primary" type="submit">
                                {{ $currentStep === 'account' ? 'Comecar a testar' : ($currentStep !== 'address' ? 'Continuar' : 'Finalizar') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center bg-light">
                <div class="w-100 px-4 px-md-5 py-4" style="max-width: 680px;"></div>
            </div>
        </div>
    </div>
@endsection
