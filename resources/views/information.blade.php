@extends('layout.app')
@section('css')
<style>
    .card_item {
        background-color: #2a303c;
        border-radius: 10px;
        border: 1px solid #ccc;
    }
</style>
@endsection
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
                <p class="text-white f-14 mb-0">Thông tin cá nhân</p>
            </div>
            <div class="col-3"></div>
        </div>
    </div>

    <div class="container">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <form action="{{ route('informationUpdate') }}" method="POST">
            @csrf
            <div class="row align-items-center border-bottom pb-3 mb-3">
                <div class="col-4">
                    <label for="username" class="form-label f-14 text-gray">Biệt hiệu</label>
                </div>
                <div class="col-8">
                    <input type="text" class="form-control small" id="username" name="username" placeholder="Nhập biệt hiệu" value="{{ old('username', auth()->user()->username) }}">
                </div>
            </div>
            <div class="row align-items-center border-bottom pb-3 mb-3">
                <div class="col-4">
                    <label for="bank_account_number" class="form-label f-14 text-gray">Số tài khoản</label>
                </div>
                <div class="col-8 text-end">
                    <p class="text-gray f-14 mb-0">{{ auth()->user()->bank_account ? substr(auth()->user()->bank_account, 0, 4) . str_repeat('*', strlen(auth()->user()->bank_account) - 4) : '-' }}</p>
                </div>
            </div>
            <div class="row align-items-center border-bottom pb-3 mb-3">
                <div class="col-4">
                    <label for="referral_code" class="form-label f-14 text-gray">Mã giới thiệu</label>
                </div>
                <div class="col-8 text-end">
                    <span class="text-gray f-14 mb-0">
                        {{ auth()->user()->referral_code }}
                    </span>
                    <button class="btn btn-sm btn-warning" type="button" onclick="copyText('{{ auth()->user()->referral_code }}')">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
            </div>

            <div class="row align-items-center border-bottom pb-3 mb-3">
                <div class="col-4">
                    <label for="password" class="form-label f-14 text-gray">Thay đổi mật khẩu</label>
                </div>
                <div class="col-8">
                    <input type="password" class="form-control small" id="password" name="password" placeholder="Nhập mật khẩu">
                    <p class="text-gray f-14 mb-0">Mật khẩu có ít nhất 8 ký tự</p>
                    @error('password')
                    <p class="text-danger f-14 mb-0">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-warning w-100">Gửi yêu cầu</button>
            </div>
        </form>

    </div>
</div>
@include('includes.footer')
@endsection

@section('js')

<script>
    $(document).ready(function() {
        $('#upload_before').click(function() {
            $('#cccd_before').click();
        });
        $('#upload_after').click(function() {
            $('#cccd_after').click();
        });

        $('#cccd_before').change(function() {
            $('#preview_before').css('background-image', 'url(' + URL.createObjectURL($(this)[0].files[0]) + ')');
            $('#preview_before').css('background-size', 'cover');
            $('#preview_before').css('background-position', 'center');
        });

        $('#cccd_after').change(function() {
            $('#preview_after').css('background-image', 'url(' + URL.createObjectURL($(this)[0].files[0]) + ')');
            $('#preview_after').css('background-size', 'cover');
            $('#preview_after').css('background-position', 'center');
        });

    });

    function copyText(value) {
        // Create a temporary input element
        var tempInput = document.createElement("input");
        // Set its value to the text we want to copy
        tempInput.value = value;
        // Append it to the body
        document.body.appendChild(tempInput);
        // Select the text
        tempInput.select();
        // Copy the text
        document.execCommand("copy");
        // Remove the temporary element
        document.body.removeChild(tempInput);
        // Optionally, provide some feedback to the user
        alert("Mã mời đã được sao chép vào bộ nhớ đệm!");
    }
</script>

@endsection
