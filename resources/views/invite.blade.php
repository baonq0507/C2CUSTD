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
                <p class="text-white f-14 mb-0">Mời bạn bè</p>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
    <div class="content">
        <div class="mask text-center">
            <p class="text-white  f-14 mb-0">Mã mời của tôi</p>
            <p class="text-white mt-3 f-14 mb-0">{{ auth()->user()->referral_code }}</p>

            <button class="btn btn-warning mt-2" onclick="copyText('{{ auth()->user()->referral_code }}')">Sao chép</button>
            <p class="text-white mt-2 f-14">Sao chép mã mời và chia sẻ cho bạn bè</p>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
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
