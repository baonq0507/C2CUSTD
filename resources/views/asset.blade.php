@extends('layout.app')

@section('content')
<div class="container mt-2">
    <div class="header mb-5">
        <div class="row align-items-center">
            <div class="col-3">
                <a href="{{ url()->previous() }}" class="text-white f-20">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
            <div class="col-6 text-center">
                <p class="text-white f-14 mb-0">Tài sản của tôi</p>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
    <div class="content">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <p class="text-white f-14 mb-0">
                            <img src="{{ asset('images/icons/dolla.png') }}" alt="logo" class="logo">
                            <span>Balance(USDT)</span>
                        </p>
                        <p class="text-warning text-center f-14 mb-3">
                            0
                        </p>
                        <p class="text-center mb-0"><a href="#" class="btn btn-warning btn-sm">Nạp tiền</a></p>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <p class="text-white f-14 mb-0">
                            <img src="{{ asset('images/icons/dolla.png') }}" alt="logo" class="logo">
                            <span>Balance(VND)</span>
                        </p>
                        <p class="text-warning text-center f-14 mb-3">
                            0
                        </p>
                        <p class="text-center mb-0"><a href="#" class="btn btn-warning btn-sm">Rút tiền</a></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('js')

@endsection
