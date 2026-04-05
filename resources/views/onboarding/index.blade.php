@extends('app')

@section('title', 'Onboarding')

@section('content')
    <div class="container-fluid">
        <div class="row min-vh-100">
            <div class="col-12 col-lg-6 bg-white d-flex align-items-center">
                <div class="w-100 px-4 px-md-5 py-4 mx-auto" style="max-width: 640px;">
                    @if ($step !== 4)
                        <div class="d-flex gap-2 mb-3" aria-label="Progresso do onboarding">
                            @for ($bar = 1; $bar <= 3; $bar++)
                                <div
                                    class="flex-fill rounded-pill {{ $step >= $bar ? 'bg-primary' : 'bg-secondary-subtle' }}"
                                    style="height: 8px;"
                                ></div>
                            @endfor
                        </div>
                        <div class="mb-3">
                            <span class="badge bg-light-primary text-primary">Teste gratuitamente</span>
                        </div>
                    @endif

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

                        @includeIf('onboarding.steps.step-' . $step)

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
                    </form>
                </div>
            </div>

            <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center bg-light">
                <div class="w-100 px-4 px-md-5 py-4" style="max-width: 680px;"></div>
            </div>
        </div>
    </div>
@endsection
