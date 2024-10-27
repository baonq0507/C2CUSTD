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
                <p class="text-white f-14 mb-0">Liên kết ngân hàng</p>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
    <div class="content text-center">
        @if(!auth()->user()->accept_info)
        <p class="d-flex align-items-center justify-content-center">
            <img src="{{ asset('images/icons/clock.png') }}" alt="logo" class="logo" width="30" height="30">
            &nbsp;
            <span class="text-warning f-14">Đang chờ kiểm tra</span>
        </p>
        @endif
    </div>
    <div class="container">
        <form action="{{ route('postBank') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row align-items-center border-bottom pb-3 mb-3">
                <div class="col-4">
                    <label for="bank_owner" class="form-label f-14 text-gray">Tên đầy đủ</label>
                </div>
                <div class="col-8">
                    <input type="text" class="form-control small" id="bank_owner" name="bank_owner" placeholder="Nhập tên đầy đủ">
                </div>
            </div>
            <div class="row align-items-center border-bottom pb-3 mb-3">
                <div class="col-4">
                    <label for="phone" class="form-label f-14 text-gray">Số điện thoại</label>
                </div>
                <div class="col-8">
                    <input type="text" class="form-control small" id="phone" name="phone" placeholder="Nhập số điện thoại">
                </div>
            </div>
            <div class="row align-items-center border-bottom pb-3 mb-3">
                <div class="col-4">
                    <label for="bank_name" class="form-label f-14 text-gray">Tên ngân hàng</label>
                </div>
                <div class="col-8">
                    <input type="text" class="form-control small" id="bank_name" name="bank_name" placeholder="Nhập tên ngân hàng">
                </div>
            </div>
            <div class="row align-items-center border-bottom pb-3 mb-3">
                <div class="col-4">
                    <label for="bank_account" class="form-label f-14 text-gray">Số tài khoản</label>
                </div>
                <div class="col-8">
                    <input type="text" class="form-control small" id="bank_account" name="bank_account" placeholder="Nhập số tài khoản">
                </div>
            </div>
            <div class="row align-items-center pb-3 mb-3">
                <p class="text-gray f-14">Tải lên ảnh CMND/CCCD</p>
                <div class="col-6">
                    <div class="row mt-3 card_item mx-2 mb-1" id="preview_before" style="align-items: center; justify-content: center; min-height: 100px;">
                        <div class="col-6 text-center" id="upload_before">
                            <i class="fas fa-plus f-20 text-white"></i>
                        </div>
                    </div>
                    <p class="text-gray f-12 text-center">Ảnh CMND/CCCD trước</p>
                    <input type="file" class="form-control d-none" id="cccd_before" name="cccd_before">
                </div>
                <div class="col-6">
                    <div class="row mt-3 card_item mx-2 mb-1" id="preview_after" style="align-items: center; justify-content: center; min-height: 100px;">
                        <div class="col-6 text-center" id="upload_after">
                            <i class="fas fa-plus f-20 text-white"></i>
                        </div>
                    </div>
                    <p class="text-gray f-12 text-center">Ảnh CMND/CCCD sau</p>
                    <input type="file" class="form-control d-none" id="cccd_after" name="cccd_after">
                </div>
            </div>

            <div class="text-center mb-2">
                <p class="text-gray f-14">Vui lòng đảm bảo thông tin chính xác, nếu không sẽ ảnh hưởng đến giao dịch thông qua hệ thống</p>
            </div>
            <div class="text-center">
                <button class="btn btn-warning w-100">Gửi yêu cầu</button>
            </div>
        </form>

    </div>

</div>
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

        $('form').submit(function(e) {
            e.preventDefault();
            if ($('#cccd_before').val() == '' || $('#cccd_after').val() == '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Vui lòng tải lên ảnh CMND/CCCD',
                });
                return false;
            }
            const formData = new FormData(this);
            formData.append('cccd_before', $('#cccd_before').val());
            formData.append('cccd_after', $('#cccd_after').val());

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Gửi yêu cầu thành công',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(function() {
                        window.location.href = "/user";
                    }, 1500);
                },
                error: function(response) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gửi yêu cầu thất bại',
                    });
                }
            });
        });
    });
</script>

@endsection
