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
            <div class="col-8">
                <p class="text-white f-14 mb-0">Hướng dẫn cho người mới bắt đầu</p>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
    <div class="content">
        <div class="card mb-3">
            <div class="card-body">
                <p class="text-white f-14 mb-0">Hướng dẫn rút tiền</p>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <p class="text-white f-14 mb-0">Hướng dẫn nạp tiền</p>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <p class="text-white f-14 mb-0">Hướng dẫn liên kết tài khoản ngân hàng</p>
            </div>
        </div>
    </div>
</div>
@endsection
