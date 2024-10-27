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
                <p class="text-white f-14 mb-0">Chi tiết tài khoản</p>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
    <div class="content">
        <div class="row mb-3">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <p class="text-white f-14 mb-0">
                            <img src="{{ asset('images/icons/dolla.png') }}" alt="logo" class="logo">
                            <span>Balance(USDT)</span>
                        </p>
                        <p class="text-warning text-center f-14 mb-3">
                            {{ number_format(auth()->user()->balance, 2, '.', ',') }}
                        </p>
                        <!-- <p class="text-center mb-0"><a href="#" class="btn btn-warning btn-sm">Nạp tiền</a></p> -->
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
                            {{ number_format(auth()->user()->balance, 0, '.', ',') }}
                        </p>
                        <!-- <p class="text-center mb-0"><a href="#" class="btn btn-warning btn-sm">Rút tiền</a></p> -->
                    </div>
                </div>
            </div>

        </div>


        <div class="card mb-3">
            <div class="card-body">
                <div class="row justify-content-center align-items-center">
                    <div class="col-4">
                        <p class="text-white f-12 mb-0"><a href="/detail?tab=usdt" class=" f-12 text-white btn btn-sm text-decoration-none @if(request()->tab == 'usdt') btn-warning @else btn-secondary @endif">Mua và bán USDT</a></p>
                    </div>
                    <div class="col-4">
                        <p class="text-white f-12 mb-0"><a href="/detail?tab=deposit" class="f-12 w-100 text-white btn btn-sm text-decoration-none @if(request()->tab == 'deposit') btn-warning @else btn-secondary @endif">Nạp tiền</a></p>
                    </div>
                    <div class="col-4">
                        <p class="text-white f-12 mb-0"><a href="/detail?tab=withdraw" class="f-12 w-100 text-white btn btn-sm text-decoration-none @if(request()->tab == 'withdraw') btn-warning @else btn-secondary @endif">Rút tiền</a></p>
                    </div>
                </div>
            </div>
        </div>
        @if(count($transactions) > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="text-white f-12">STT</th>
                        <th class="text-white f-12">Thời gian</th>
                        <th class="text-white f-12">Số tiền</th>
                        <th class="text-white f-12">Loại</th>
                        <th class="text-white f-12">Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                    <tr>
                        <td class="text-white f-12">
                            {{ $loop->iteration }}
                        </td>
                        <td class="text-white f-12">
                            {{ $transaction->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="text-white f-12">
                            {{ $transaction->amount }}
                        </td>
                        <td class="text-white f-12">
                            {{ $transaction->type == 'deposit_ustd' ? 'Nạp tiền' : ($transaction->type == 'buy_usdt' ? 'Mua USDT' : ($transaction->type == 'sell_usdt' ? 'Bán USDT' : 'Rút tiền')) }}
                        </td>
                        <td class="text-white f-12">
                           <span class="badge {{ $transaction->status == 'pending' ? 'bg-warning' : ($transaction->status == 'approved' ? 'bg-success' : 'bg-danger') }}">{{ $transaction->status == 'pending' ? 'Chờ duyệt' : ($transaction->status == 'approved' ? 'Đã duyệt' : 'Đã từ chối') }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center">
            <img src="{{ asset('images/icons/nodata.png') }}" alt="logo" class="logo">
            <p class="text-white f-12 mb-0">Không có dữ liệu</p>
        </div>
        @endif
    </div>
</div>
@include('includes.footer')
@endsection

@section('js')

@endsection
