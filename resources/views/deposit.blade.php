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
                <p class="text-white f-14 mb-0">Nạp tiền (USDT)</p>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
    <div class="content">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center mb-3">
                    <div class="col-3">
                        <p class="text-white f-14 mb-0">Loại: </p>
                    </div>
                    <div class="col-9">
                        <select class="form-control small" name="type" id="type" placeholder="Chọn loại">
                            <option value="1" selected disabled>Chọn loại</option>
                            @foreach ($deposit_ustd as $item)
                            <option value="{{ $item->id }}">{{ $item->type }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row align-items-center mb-3">
                    <div class="col-3">
                        <p class="text-white f-14 mb-0">Địa chỉ:</p>
                    </div>
                    <div class="col-7">
                        <p class="text-white f-14 mb-0" id="address">----</p>
                    </div>
                    <div class="col-2">
                        <button class="btn btn-primary w-100" id="copy" onclick="copyText($('#address').text())">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>

                <div class="row align-items-center mb-3">
                    <div class="col-3">
                        <p class="text-white f-14 mb-0">Số lượng: </p>
                    </div>
                    <div class="col-9">
                        <input type="number" class="form-control small" name="amount" id="amount" placeholder="Nhập số lượng USDT">
                    </div>
                </div>
                <div class="row align-items-center mb-3">
                    <div class="col-3">
                        <p class="text-white f-14 mb-0">Số lượng: </p>
                    </div>
                    <div class="col-9">
                        <div class="row mt-3 card_item mx-2 mb-1" id="preview_proof" style="align-items: center; justify-content: center; min-height: 100px;">
                            <div class="col-6 text-center" id="upload_proof">
                                <i class="fas fa-plus f-20 text-white"></i>
                            </div>
                        </div>
                        <p class="text-gray f-12 text-center">Ảnh chụp chứng thực</p>
                        <input type="file" id="proof" hidden>

                    </div>
                    <p class="text-gray f-14 text-center mb-0">
                        Để đảm bảo an toàn cho tài sản của bạn, sau khi chuyển khoản thành công, vui lòng gửi ảnh chụp màn hình chuyển khoản thành công để kiểm tra
                    </p>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-warning w-100" id="deposit">Nạp tiền</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        const usdt_address = @json($deposit_ustd);
        // $('#address').text($('#type option:selected').text());
        $('#type').change(function() {
            var type = $(this).val();
            $('#address').text(usdt_address[type].address);
        });

        $('#proof').change(function() {
            var file = $(this).val();
            $('#preview_proof').css('background-image', 'url(' + URL.createObjectURL($(this)[0].files[0]) + ')');
            $('#preview_proof').css('background-size', 'cover');
            $('#preview_proof').css('background-position', 'center');
        });

        $('#preview_proof').click(function() {
            $('#proof').click();
        });

        $('#deposit').click(function() {
            var amount = $('#amount').val();
            var proof = $('#proof').val();
            var type = $('#type').val();
            if (amount == '' || proof == '' || type == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Vui lòng nhập đầy đủ thông tin',
                });
                return;
            }
            let id_deposit = usdt_address[type].id;

            $('#deposit').html('<i class="fas fa-spinner fa-spin"></i> Đang nạp tiền');
            $('#deposit').prop('disabled', true);

            var formData = new FormData();
            formData.append('amount', amount);
            formData.append('proof', $('#proof')[0].files[0]);
            formData.append('id_deposit', id_deposit);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url: "{{ route('postDeposit') }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#deposit').html('Nạp tiền');
                    $('#deposit').prop('disabled', false);
                    Swal.fire({
                        icon: 'success',
                        title: 'Nạp tiền thành công',
                    });

                    setTimeout(function() {
                        window.location.href = "/detail?tab=deposit";
                    }, 1500);
                },
                error: function(xhr, status, error) {
                    $('#deposit').html('Nạp tiền');
                    $('#deposit').prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Có lỗi xảy ra',
                        text: 'Vui lòng thử lại sau'
                    });
                }
            });
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
