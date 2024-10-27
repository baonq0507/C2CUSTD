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
                <p class="text-white f-14 mb-0">Mua USDT</p>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body text-center">
            <img src="{{ asset('images/icons/dolla.png') }}" alt="logo" class="logo" width="20" height="20">
            <span class="text-white f-14">Số dư (VND)</span>
            <p class="text-warning f-14 mb-0">{{ number_format(auth()->user()->balance, 0, ',', '.') }}</p>
        </div>
    </div>
    <div class="container">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif
        <form action="{{ route('postWithdraw') }}" method="post">
            @csrf
            <div class="row align-items-center border-bottom pb-3 mb-3">
                <div class="col-4">
                    <label for="bank_name" class="form-label f-14 text-gray">Tên ngân hàng</label>
                </div>
                <div class="col-8 text-end">
                    <p class="f-14 text-gray mb-0">{{ auth()->user()->bank_name }}</p>
                </div>
            </div>
            <div class="row align-items-center border-bottom pb-3 mb-3">
                <div class="col-4">
                    <label for="bank_account" class="form-label f-14 text-gray">Số tài khoản</label>
                </div>
                <div class="col-8 text-end">
                    <p class="f-14 text-gray mb-0">{{ auth()->user()->bank_account ? substr(auth()->user()->bank_account, 0, 4) . str_repeat('*', strlen(auth()->user()->bank_account) - 4) : '-' }}</p>
                </div>
            </div>
            <div class="row align-items-center border-bottom pb-3 mb-3">
                <div class="col-4">
                    <label for="amount" class="form-label f-14 text-gray">Họ và tên</label>
                </div>
                <div class="col-8 text-end">
                    <p class="f-14 text-gray mb-0">{{ auth()->user()->bank_owner }}</p>
                </div>
            </div>
            <div class="row align-items-center border-bottom pb-3 mb-3">
                <div class="col-4">
                    <label for="phone" class="form-label f-14 text-gray">Số điện thoại</label>
                </div>
                <div class="col-8 text-end">
                    <p class="f-14 text-gray mb-0">{{ auth()->user()->phone }}</p>
                </div>
            </div>
            <div class="row align-items-center border-bottom pb-3 mb-3">
                <div class="col-4">
                    <label for="amount" class="form-label f-14 text-gray">Số tiền:</label>
                </div>
                <div class="col-5 text-end">
                    <input type="number" class="form-control small" id="amount" name="amount" placeholder="Nhập số tiền">
                </div>

                <div class="col-3 text-end">
                    <button class="btn btn-warning" type="button" id="all">Tất cả</button>
                </div>
            </div>
            @error('amount')
            <p class="text-danger f-14 text-start">{{ $message }}</p>
            @enderror

            <div class="row">
                <div class="col-12">
                    <button class="btn btn-warning w-100 " type="submit">Gửi yêu cầu</button>
                </div>
            </div>
        </form>
    </div>
</div>
@include('includes.footer')
@endsection

@section('js')
<script>
    $('#all').click(function() {
        $('#amount').val('{{ auth()->user()->balance }}');
    });
</script>
@endsection
