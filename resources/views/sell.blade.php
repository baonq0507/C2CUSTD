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
                <p class="text-white f-14 mb-0">Bán USDT</p>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <p class="text-white f-14">Họ và tên: <span class="text-warning">{{ auth()->user()->username }}</span></p>
            <p class="text-white f-14">Số dư (USDT): <span class="text-warning">{{ number_format(auth()->user()->usdt_balance, 0, ',', '.') }}</span></p>
            <p class="text-white f-14">Giá hiện tại (USDT): <span class="text-warning" id="price_usdt">{{ '23232323' }}</span></p>
            <p class="text-white f-14">Giá tốt nhất (USDT): <span class="text-warning" id="best_price_usdt">{{ '23232323' }}</span></p>
            <p class="text-white f-14">Lợi nhuận (USDT): <span class="text-warning" id="profit_usdt">{{ '3.3%' }}</span></p>
            <div class="row align-items-center w-100">
                <div class="col-3">
                    <label for="amount" class="text-white f-14">Số lượng bán:</label>
                </div>
                <div class="col-6">
                    <input type="number" class="form-control" id="amount" placeholder="Nhập số lượng USDT">
                </div>
                <div class="col-3">
                    <button class="btn btn-warning w-100" id="all">Tất cả</button>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-warning w-100" id="sell">Bán ngay</button>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(async function() {

        $('#all').on('click', function() {
            $('#amount').val('{{ auth()->user()->usdt_balance }}');
        });
        let load = false;
        $('#sell').on('click', function() {
            if (load) return;
            load = true;
            if ($('#amount').val() == '' || $('#amount').val() == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Vui lòng nhập số lượng bán',
                });
                load = false;
                return;
            }

            if (parseInt($('#amount').val()) > parseInt('{{ auth()->user()->usdt_balance }}')) {
                Swal.fire({
                    icon: 'error',
                    title: 'Số lượng bán không được lớn hơn số dư',
                });
                load = false;
                return;
            }
            $('#sell').html('<i class="fas fa-spinner fa-spin"></i> Đang bán...');
            $('#sell').prop('disabled', true);
            $.ajax({
                url: "{{ route('sellNow') }}",
                type: 'POST',
                data: {
                    amount: $('#amount').val(),
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#sell').html('Bán ngay');
                    $('#sell').prop('disabled', false);
                    Swal.fire({
                        icon: 'success',
                        title: 'Bán thành công',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('#amount').val('');
                    load = false;
                    setTimeout(function() {
                        window.location.href = "/detail?tab=usdt";
                    }, 1500);
                },
                error: function(response) {
                    $('#sell').html('Bán ngay');
                    $('#sell').prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Bán thất bại',
                        text: response.responseJSON.message,
                    });
                    load = false;
                }
            });
        });
        // get price usdt
        async function getPriceUsdt() {
            const url = `https://api.binance.com/api/v3/klines?symbol=BTCUSDT&interval=1m&limit=1`;
            const response = await fetch(url);
            const data = await response.json();
            return data[0][4];
        }
        const price_usdt = await getPriceUsdt();
        $('#price_usdt').html(parseFloat(price_usdt).toFixed(2));
        const best_price_usdt = price_usdt * 1.0333;
        $('#best_price_usdt').html(best_price_usdt.toFixed(2));
        const profit_usdt = ((best_price_usdt - price_usdt) / price_usdt) * 100;
        $('#profit_usdt').html(profit_usdt.toFixed(1) + '%');
    });
</script>
@endsection
