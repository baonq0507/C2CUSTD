@extends('layout.app')

@section('css')
<style>
    .input-group-text {
        background-color: transparent;
    }

    input {
        background-color: transparent;
        border-top-left-radius: 0 !important;
        border-bottom-left-radius: 0 !important;
    }

    input#password {
        border-top-right-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }
</style>
@endsection

@section('content')
<div class="container mt-5">
    <div class="row align-items-center">
        <div class="col-6">
            <p class=" text-uppercase text-white">Tải xuống app</p>
        </div>
        <div class="col-6 text-end">
            <img src="{{ asset('images/icons/vie.png') }}" alt="app" width="30" height="30">
        </div>
    </div>
    <div class="content mt-5">
        <div class="text-center">
            <img src="{{ asset('images/logo.jpg') }}" alt="logo" width="50">
        </div>
    </div>

    <div class="card mt-5">
        <form action="{{ route('postLogin') }}" method="post">
            @csrf
            <div class="card-body">
                @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif

                <div class="form-group mb-3">
                    <label for="email" class="form-label text-white">Email</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-user text-white"></i>
                        </span>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                    </div>
                    @error('email')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="password" class="form-label text-white">Mật khẩu</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock text-white"></i>
                        </span>
                        <input type="password" class="form-control" id="password" name="password">
                        <span class="input-group-text" id="hide-password">
                            <i class="fas fa-eye text-white"></i>
                        </span>
                        <span class="input-group-text" id="show-password">
                            <i class="fas fa-eye-slash text-white"></i>
                        </span>
                    </div>
                    @error('password')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="card-footer">
                    <div class="text-end mt-3">
                        <a href="" class="text-warning text-decoration-none">Quên mật khẩu</a>
                    </div>
                    <div class="text-center mt-3">
                        <button class="btn btn-warning btn-sm w-100">Đăng nhập ngay</button>
                    </div>
                </div>
            </div>
        </form>
    </div>



</div>
<div class="text-center mt-3">
    <div class="row">
        <div class="col-6 text-end">
            <a href="" class="text-white text-decoration-none">Không có tài khoản?</a>
        </div>
        <div class="col-6">
            <a href="{{ route('register') }}" class="text-warning text-decoration-none">Đăng ký ngay</a>
        </div>
    </div>
</div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#hide-password').hide();

        $('#show-password').on('click', function() {
            $('#password').attr('type', 'text');
            $('#hide-password').show();
            $('#show-password').hide();
        });

        $('#hide-password').on('click', function() {
            $('#password').attr('type', 'password');
            $('#hide-password').hide();
            $('#show-password').show();
        });
    });
</script>
@endsection
