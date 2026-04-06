@extends('app')

@section('title', 'Onboarding')

@section('content')
    <div class="container-fluid">
        <div class="row min-vh-100">
            <div class="col-12 col-lg-6 bg-white d-flex align-items-center z-index-3" style="box-shadow: 20px 0px 100px #10161f97;">
                <div class="w-100 px-4 px-md-5 py-4 mx-auto" style="max-width: 640px;">
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
