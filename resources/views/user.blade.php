@extends('layout.app')

@section('content')
<div class="container mt-2">
    <div class="card mb-3">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-6">
                    <p class="text-white f-14 mb-0">{{ auth()->user()->username }}</p>
                    <p>
                        <img src="{{ asset('images/icons/level' . auth()->user()->level . '.png') }}" alt="logo" class="logo">
                        <span class="badge bg-{{ auth()->user()->level == 1 ? 'warning' : (auth()->user()->level == 2 ? 'success' : (auth()->user()->level == 3 ? 'danger' : (auth()->user()->level == 4 ? 'info' : 'primary'))) }}">{{ auth()->user()->level == 1 ? 'Hạng thường' : (auth()->user()->level == 2 ? 'Hạng thương gia' : (auth()->user()->level == 3 ? 'Hạng vàng' : (auth()->user()->level == 4 ? 'Hạng bạc' : 'Hạng kim cương'))) }}</span>
                    </p>
                </div>
                <div class="col-6 text-end">
                    <a href="{{ route('information') }}">
                        <img src="{{ asset('images/icons/setting.png') }}" alt="logo" class="logo">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <p class="text-white f-14 mb-0">
                        <img src="{{ asset('images/icons/dolla.png') }}" alt="logo" class="logo">
                        <span>Balance(USDT)</span>
                    </p>
                    <p class="text-warning text-center f-14 mb-3">
                        {{ number_format(auth()->user()->usdt_balance, 0, ',', '.') }}
                    </p>
                    <p class="text-center mb-0"><a href="{{ route('deposit') }}" class="btn btn-warning btn-sm">Nạp tiền</a></p>
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
                        {{ number_format(auth()->user()->balance, 0, ',', '.') }}
                    </p>
                    @if(!auth()->user()->bank_owner && !auth()->user()->bank_number && !auth()->user()->bank_name)
                    <p class="text-center mb-0"><a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#withdraw">Rút tiền</a></p>
                    @else
                    <p class="text-center mb-0"><a href="{{ route('withdraw') }}" class="btn btn-warning btn-sm">Rút tiền</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row text-center">
                <div class="col-4 mb-3">
                    <a href="{{ route('asset') }}" class="text-decoration-none">
                        <img src="{{ asset('images/icons/asset.png') }}" alt="logo" class="logo">
                        <p class="text-white f-14 mb-0">Tài sản</p>
                    </a>
                </div>
                <div class="col-4 mb-3">
                    <a href="{{ route('team') }}" class="text-decoration-none">
                        <img src="{{ asset('images/icons/team.png') }}" alt="logo" class="logo">
                        <p class="text-white f-14 mb-0">Thành viên</p>
                    </a>
                </div>
                <div class="col-4 mb-3">
                    <a href="{{ route('bank') }}" class="text-decoration-none">
                        <img src="{{ asset('images/icons/bank.png') }}" alt="logo" class="logo">
                        <p class="text-white f-14 mb-0">Ngân hàng</p>
                    </a>
                </div>
                <div class="col-4 mb-3">
                    <a href="/detail?tab=usdt" class="text-decoration-none">
                        <img src="{{ asset('images/icons/detail.png') }}" alt="logo" class="logo">
                        <p class="text-white f-14 mb-0">Chi tiết</p>
                    </a>
                </div>
                <div class="col-4 mb-3">
                    <a href="{{ route('intro') }}" class="text-decoration-none">
                        <img src="{{ asset('images/icons/intro.png') }}" alt="logo" class="logo">
                        <p class="text-white f-14 mb-0">Giới thiệu</p>
                    </a>
                </div>
                <div class="col-4">
                    <a href="{{ route('invite') }}" class="text-decoration-none">
                        <img src="{{ asset('images/icons/invite.png') }}" alt="logo" class="logo">
                        <p class="text-white f-14 mb-0">Lời mời </p>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <!-- <p class="text-white f-14 mb-0 text-center"><a href="#" class="text-white text-decoration-none">Đăng xuất</a></p> -->
                <button type="submit" class="btn btn-warning btn-sm w-100">Đăng xuất</button>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="withdraw" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="withdrawLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="withdrawLabel">Lời nhắc</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-center mb-0">Bạn chưa liên kết ngân hàng?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                    <a href="{{ route('bank') }}" class="btn btn-warning">Đồng ý</a>
                </div>
            </div>
        </div>
    </div>

    @include('includes.footer')
</div>
@endsection

@section('js')

@endsection
