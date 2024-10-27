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
        border: 1px solid #e0e0e0;
    }

    input#password,
    input#password_confirm {
        border-top-right-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
    }
</style>
@endsection

@section('content')
<div class="container mt-5">
    <div class="row align-items-center">
        <div class="col-6">
            <p class=" text-uppercase text-white">Chào mừng</p>
        </div>
    </div>
    <div class="card mt-5">
        <form action="{{ route('postRegister') }}" method="post">
            @csrf
            <div class="card-body">

                <div class="form-group mb-3">
                    <label for="email" class="form-label text-white">Email</label>
                    <div class="input-group">
                        <span class="input-group-text" id="email">
                            <i class="fas fa-user text-white"></i>
                        </span>
                        <input type="text" class="form-control" id="email" aria-describedby="email" name="email" value="{{ old('email') }}">
                    </div>
                    @error('email')
                    <small class="text-danger">{{ $message }}</small>
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
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="password_confirm" class="form-label text-white">Nhập lại mật khẩu</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock text-white"></i>
                        </span>
                        <input type="password" class="form-control" id="password_confirm" name="password_confirm">
                        <span class="input-group-text" id="hide-password_confirm">
                            <i class="fas fa-eye text-white"></i>
                        </span>
                        <span class="input-group-text" id="show-password_confirm">
                            <i class="fas fa-eye-slash text-white"></i>
                        </span>
                    </div>
                    @error('password_confirm')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="referral_code" class="form-label text-white">Mã giới thiệu</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-qrcode text-white"></i>
                        </span>
                        <input type="text" class="form-control" id="referral_code" name="referral_code" value="{{ old('referral_code') }}">
                    </div>
                    @error('referral_code')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-warning btn-sm w-100">Đăng ký ngay</button>
            </div>
        </form>
    </div>
</div>



<div class="text-center mt-3">
    <a href="{{ route('login') }}" class="text-warning text-decoration-none">Trở về đăng nhập</a>
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

        $('#hide-password_confirm').hide();

        $('#show-password_confirm').on('click', function() {
            $('#password_confirm').attr('type', 'text');
            $('#hide-password_confirm').show();
            $('#show-password_confirm').hide();
        });
    });
</script>
@endsection
