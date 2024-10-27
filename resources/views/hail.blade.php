@extends('layout.app')

@section('css')
<style>
    .nav-link {
        color: #fff;

    }

    .nav-link.active {
        color: #000;
        background-color: #ffc107 !important;
    }

    input.form-control {
        border-radius: 0;
        background-color: #fff !important;
        border: 1px solid #ccc !important;
        color: #000 !important;
    }
</style>
@endsection

@section('content')
<div class="container mt-3">
    <div class="card mb-3">
        <div class="card-body text-center">
            <img src="{{ asset('images/icons/level' . auth()->user()->level . '.png') }}" alt="logo" class="logo">
            <span class="badge bg-{{ auth()->user()->level == 1 ? 'warning' : (auth()->user()->level == 2 ? 'success' : (auth()->user()->level == 3 ? 'danger' : (auth()->user()->level == 4 ? 'info' : 'primary'))) }}">{{ auth()->user()->level == 1 ? 'Hạng thường' : (auth()->user()->level == 2 ? 'Hạng thương gia' : (auth()->user()->level == 3 ? 'Hạng vàng' : (auth()->user()->level == 4 ? 'Hạng bạc' : 'Hạng kim cương'))) }}</span>
            @if (auth()->user()->level == 1)
            <a id="upgrade" class="f-14 text-warning">Nâng cấp thương gia</a>
            @endif
            <p class="f-14 text-white">Số dư USDT: {{ number_format(auth()->user()->usdt_balance, 0, ',', '.') }}</p>

            <div class="row">
                <div class="col-6">
                    @if (auth()->user()->level == 1)
                    <button class="btn btn-warning btn-sm w-100" id="buy_now">Tôi muốn mua</button>
                    @else
                    <a href="{{ route('buy') }}" class="btn btn-warning btn-sm w-100">Tôi muốn mua</a>
                    @endif
                </div>
                <div class="col-6">
                    <a href="{{ route('sell') }}" class="btn btn-warning btn-sm w-100">Tôi muốn bán</a>
                </div>
            </div>
        </div>
    </div>
    <ul class="nav nav-tabs justify-content-around mb-3" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active w-100" id="buy-tab" data-bs-toggle="tab" data-bs-target="#buy" type="button" role="tab" aria-controls="buy" aria-selected="true">Lệnh bán</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link w-100" id="order-tab" data-bs-toggle="tab" data-bs-target="#order" type="button" role="tab" aria-controls="order" aria-selected="false">Đơn đặt hàng</button>
        </li>
    </ul>
    <div class="tab-content" style="margin-bottom: 100px;">
        <div class="tab-pane fade show active" id="buy" role="tabpanel">
            @foreach ($buy_usdt as $item)
            <div class="card mb-2 card_buy" data-id="{{ $item->id }}">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <p class="f-14 text-white">Đơn hàng lợi nhuận</p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="f-14 text-white profit_price"></p>
                        </div>
                    </div>
                    <p class="f-14 text-gray">Doanh nghiệp: {{ $item->user->email }}</p>
                    <p class="f-14 text-gray ">Đơn giá: <span class="price text-warning">{{ number_format($item->price_buy, 0, ',', '.') }}</span> USDT</p>
                    <p class="f-14 text-gray">Số lượng: <span class="amount text-warning">{{ number_format($item->total_buy, 0, ',', '.') }}</span> USDT</p>
                    <p class="f-14 text-gray">Khả dụng: <span class="remaining text-warning">{{ number_format($item->remaining_buy, 0, ',', '.') }}</span> USDT</p>
                    <p class="f-14 text-gray">Giới hạn: <span class="limit text-warning">{{ number_format($item->min_limit_buy, 0, ',', '.') }}</span> - <span class="limit_max text-warning">{{ number_format($item->max_limit_buy, 0, ',', '.') }}</span> USDT</p>
                    <p class="f-14 text-gray">Giới hạn số lượng người: {{ $item->transaction_count }}</p>
                </div>
                <div class="card-footer">
                    <button class="btn btn-warning btn-sm w-100 sell_now">Bán ngay</button>
                </div>
            </div>
            @endforeach
        </div>
        <div class="tab-pane fade" id="order" role="tabpanel">
            @if (count($sell_usdt) == 0)
            <div class="text-center">
                <img src="{{ asset('images/icons/nodata.png') }}" alt="logo" class="logo">
                <p class="f-14 text-gray">Không có dữ liệu</p>
            </div>
            @else
            @foreach ($sell_usdt as $item)
            <div class="card mb-2">
                <div class="card-body">
                    <p class="f-14 text-white">Trạng thái: <span class="@if ($item->status == 'pending') text-warning @else text-danger @endif">{{ $item->status == 'pending' ? 'Đang bán' : 'Ngừng bán' }}</span></p>
                    <p class="f-14 text-gray">Doanh nghiệp: {{ $item->user->email }}</p>
                    <p class="f-14 text-gray ">Đơn giá: <span class="price text-warning">{{ number_format($item->price, 0, ',', '.') }}</span> USDT</p>
                    <p class="f-14 text-gray">Số lượng: <span class="amount text-warning">{{ number_format($item->total_buy, 0, ',', '.') }}</span> USDT</p>
                    <p class="f-14 text-gray">Khả dụng: <span class="remaining text-warning">{{ number_format($item->remaining_buy, 0, ',', '.') }}</span> USDT</p>
                    <p class="f-14 text-gray">Giới hạn: <span class="limit text-warning">{{ number_format($item->min_limit_buy, 0, ',', '.') }}</span> - <span class="limit_max text-warning">{{ number_format($item->max_limit_buy, 0, ',', '.') }}</span> USDT</p>
                    <p class="f-14 text-gray">Đã giao dịch: {{ $item->transaction_count }}</p>
                </div>
                <div class="card-footer text-end">
                    <button class="btn btn-warning btn-sm stop_sell" data-id="{{ $item->id }}">Ngừng bán</button>
                    <button class="btn btn-danger btn-sm delete_sell" data-id="{{ $item->id }}">Xóa</button>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modal_sell" tabindex="-1" aria-labelledby="modal_sellLabel" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_sellLabel">BÁN USDT</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" placeholder="Nhập số lượng USDT" id="amount_sell">
                    <p class="f-14 mt-2 mb-0">Số tiền nhận được: <span class="text-warning" id="money_sell">100.000.000 </span> VNĐ</p>
                </div>
                <div class="modal-footer">
                    <div class="row justify-content-around w-100">
                        <div class="col-6">
                            <button type="button" class="btn btn-secondary btn-sm w-100" data-bs-dismiss="modal">Đóng</button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-warning btn-sm w-100" id="sell_now">Bán ngay</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes.footer')
@endsection

@section('js')
<script>
    $(document).ready(async function() {
        let price_dollar = 0;
        let id_card = 0;
        $('#amount_sell').on('keyup', function() {
            let amount = $(this).val();
            amount = parseInt(amount)
            let result = amount * price_dollar;
            $('#money_sell').text(result.toLocaleString('vi-VN'));
        });
        $('#modal_sell').on('show.bs.modal', function() {
            $('#amount_sell').val('');
            $('#money_sell').text('0');
        });
        $('.sell_now').on('click', function() {
            $('#modal_sell').modal('show');
            price_dollar = $(this).parents('.card').find('.price').text()
            price_dollar = parseInt(price_dollar.replaceAll('.', ''))
            id_card = $(this).parents('.card').data('id');
        });
        $('#sell_now').on('click', function() {
            let amount = $('#amount_sell').val();
            amount = parseInt(amount);
            const usdt_balance = "{{ auth()->user()->usdt_balance }}";
            if (amount > parseInt(usdt_balance)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Số dư USDT không đủ.',
                });
                return;
            }

            $(this).prop('disabled', true);
            $(this).html('<i class="fa fa-spinner fa-spin"></i> Đang bán');

            $.ajax({
                url: "{{ route('sell') }}",
                method: "POST",
                data: {
                    amount: amount,
                    id_card: id_card,
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Bán thành công',
                    });

                    setTimeout(function() {
                        window.location.reload();
                    }, 1500);
                },
                error: function(response) {
                    Swal.fire({
                        icon: 'error',
                        title: response.responseJSON.message,
                    });
                    $('#sell_now').prop('disabled', false);
                    $('#sell_now').html('Bán ngay');
                }
            });
        });

        $('#buy_now').on('click', function() {
            Swal.fire({
                icon: 'warning',
                title: 'Tài khoản hiện tại cần nâng cấp lên tài khoản người bán?',
                showCancelButton: true,
                confirmButtonText: 'Nâng cấp ngay',
                cancelButtonText: 'Đóng',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('cskh') }}";
                }
            });
        });
        $('#upgrade').on('click', function() {
            Swal.fire({
                icon: 'warning',
                title: 'Vui lòng liên hệ CSKH để nâng cấp tài khoản.',
                showCancelButton: true,
                confirmButtonText: 'Nâng cấp ngay',
                cancelButtonText: 'Đóng',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('cskh') }}";
                }
            });
        });

        async function getPriceUsdt() {
            const url = `https://api.binance.com/api/v3/klines?symbol=BTCUSDT&interval=1m&limit=1`;
            const response = await fetch(url);
            const data = await response.json();
            return data[0][4];
        }
        const price_usdt = await getPriceUsdt();
        const card_buy = $('.card_buy');
        card_buy.each(function() {
            let price = $(this).find('.price').text();
            price = parseInt(price.replaceAll('.', ''));
            console.log(price);

            let profit_price = $(this).find('.profit_price');

            let profit = ((price_usdt - price) / price) * 100;
            profit_price.text(profit.toFixed(1) + '%');
        });

        $('.stop_sell').on('click', function() {
            let id = $(this).data('id');
            console.log(id);
            $(this).prop('disabled', true);
            $(this).html('<i class="fa fa-spinner fa-spin"></i> Đang ngừng');

            $.ajax({
                url: "{{ route('sellUpdate') }}",
                method: "POST",
                data: {
                    id: id,
                    status: 'cancel',
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Ngừng bán thành công',
                    });

                    setTimeout(function() {
                        window.location.reload();
                    }, 1500);
                },
                error: function(response) {
                    Swal.fire({
                        icon: 'error',
                        title: response.responseJSON.message,
                    });
                    $(this).prop('disabled', false);
                    $(this).html('Ngừng bán');
                }
            });
        });

        $('.delete_sell').on('click', function() {
            let id = $(this).data('id');
            $(this).prop('disabled', true);
            $(this).html('<i class="fa fa-spinner fa-spin"></i> Đang xóa');

            $.ajax({
                url: "{{ route('deleteSell') }}",
                method: "POST",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Xóa thành công',
                    });

                    setTimeout(function() {
                        window.location.reload();
                    }, 1500);
                },
                error: function(response) {
                    Swal.fire({
                        icon: 'error',
                        title: response.responseJSON.message,
                    });
                    $(this).prop('disabled', false);
                    $(this).html('Xóa');
                }
            });
        });

    });
</script>
@endsection
